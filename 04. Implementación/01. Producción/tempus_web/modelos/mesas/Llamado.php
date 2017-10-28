<?php


class Llamado {
    
    /** @var integer */
    private $idllamado;
    
    /** @var string */
    private $fecha;
    
    /** @var string */
    private $hora;
    
    /** @var Aula */
    private $aula;
    
    /** @var mysqli_result */
    private $datos;

    /**
     * Constructor de clase. Cuando recibe el identificador del llamado realiza
     * la busqueda de la informacion en la base de datos. En caso contrario, se
     * crear con sus atributos nulos.
     * @param integer $idllamado Identificador del llamado.
     * */
    function __construct($idllamado = NULL){
        if($idllamado) {
            $consulta = "SELECT idllamado, DATE_FORMAT(fecha, '%d-%m-%Y'), DATE_FORMAT(hora, '%H:%i'), idaula FROM llamado WHERE idllamado = ".$idllamado;
            $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
            if ($this->datos->num_rows > 0) {
                $fila = $this->datos->fetch_row();
                $this->idllamado = $fila[0];
                $this->fecha = $fila[1];
                
                $this->hora = $fila[2];
                $this->aula = null;
                if($fila[3]) {
                    $this->aula = new Aula($fila[3]);
                }
            }
            $this->datos = null;
        }
    }
    /**
     * @return integer $idllamado
     */
    public function getIdllamado()
    {
        return $this->idllamado;
    }

    /**
     * @return string $fecha
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @return string $hora
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * @return Aula $aula
     */
    public function getAula()
    {
        return $this->aula;
    }
    
    
    
    /**
     * @param integer $idllamado
     */
    public function setIdllamado($idllamado)
    {
        $this->idllamado = $idllamado;
    }

    /**
     * @param string $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * @param string $hora
     */
    public function setHora($hora)
    {
        $this->hora = $hora;
    }
    
    /**
     * @param Aula $aula
     */
    public function setAula($aula)
    {
        $this->aula = $aula;
    }
    
    /**
     * Realiza la creacion de una nueva fecha de llamado para una mesa de examen. 
     * @param string $fecha Fecha en formato YYYY-MM-DD (Obligatorio).
     * @param string $hora Hora en formato HH:MM (Obligatorio).
     * @param integer $aula Identificador de aula (Opcional).
     * */
    public function crear($fecha, $hora, $aula = NULL)
    {
        if (!$aula) {
            $aula = "NULL";
        }
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery("INSERT INTO llamado VALUES (null,'".$fecha."','".$hora."',".$aula.")");
        if(ObjetoDatos::getInstancia()->affected_rows) {
            $this->idllamado = (Int) ObjetoDatos::getInstancia()->insert_id;
            $this->fecha = $fecha;
            $this->hora = $hora;
        } else {
            $this->idllamado = null;
            $this->fecha = null;
            $this->hora = null;
        }
    }
    
    public function borrar($idllamado)
    {
        
    }

    
    
    
}