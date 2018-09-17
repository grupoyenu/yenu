<?php

/**
 * 
 * @author Oyarzo Mariela.
 * @author Quiroga Sandra.
 * @author Marquez Emanuel.
 * */
class Llamado {
    
    /** @var integer */
    private $idllamado;
    
    /** @var string */
    private $fecha;
    
    /** @var string */
    private $hora;
    
    /** @var Aula */
    private $aula;
    
    /** @var string Fecha de modificacion */
    private $fechamod;
    
    /** @var mysqli_result */
    private $datos;

    /**
     * Constructor de clase. Cuando recibe el identificador del llamado realiza
     * la busqueda de la informacion en la base de datos. En caso contrario, se
     * crear con sus atributos nulos.
     * @param integer $idllamado Identificador del llamado.
     * @author Marquez Emanuel.
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
     * @author Marquez Emanuel.
     */
    public function getIdllamado()
    {
        return $this->idllamado;
    }

    /**
     * @return string $fecha
     * @author Marquez Emanuel.
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @return string $hora
     * @author Marquez Emanuel.
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * @return Aula $aula
     * @author Marquez Emanuel.
     */
    public function getAula()
    {
        return $this->aula;
    }
    
    /**
     * @return string $fechamod
     * */
    public function getFechamod()
    {
        return $this->fechamod;
    }
    
    /**
     * @param integer $idllamado
     * @author Marquez Emanuel.
     */
    public function setIdllamado($idllamado)
    {
        $this->idllamado = $idllamado;
    }

    /**
     * @param string $fecha
     * @author Marquez Emanuel.
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * @param string $hora
     * @author Marquez Emanuel.
     */
    public function setHora($hora)
    {
        $this->hora = $hora;
    }
    
    /**
     * @param Aula $aula
     * @author Marquez Emanuel.
     */
    public function setAula($aula)
    {
        $this->aula = $aula;
    }
    
    /**
     * @param string $fechamod
     * */
    public function setFechamod($fechamod)
    {
        $this->fechamod = $fechamod;
    }
    
    /**
     * Realiza la creacion de una nueva fecha de llamado para una mesa de examen. 
     * @param string $fecha Fecha en formato YYYY-MM-DD (Obligatorio).
     * @param string $hora Hora en formato HH:MM (Obligatorio).
     * @param integer $aula Identificador de aula (Opcional).
     * @author Marquez Emanuel.
     * */
    public function crear($fecha, $hora, $aula = NULL)
    {
        if (!$aula) {
            $aula = "NULL";
        }
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery("INSERT INTO llamado VALUES (null,'".$fecha."','".$hora."',".$aula.")");
        if(ObjetoDatos::getInstancia()->affected_rows) {
            $this->idllamado = (Int) ObjetoDatos::getInstancia()->insert_id;
            $this->fecha = date('d-m-Y', strtotime($fecha));
            $this->hora = $hora;
            if ($aula) {
                $this->aula = new Aula($aula);
            } else {
                $this->aula = null;
            }
            
        } else {
            $this->limpiar();
        }
    }
    
    public function borrar($idllamado)
    {
        
    }
    
    /**
     * Coloca cada uno de los atributos del llamado en nulo.
     * @author Marquez Emanuel.
     * */
    private function limpiar()
    {
        $this->idllamado = null;
        $this->fecha = null;
        $this->hora = null;
        $this->aula = null;
        $this->datos = null;
    }
    
    /**
     * Realiza la modificación del llamado indicado. Cuando la operación se hace
     * correctamente, se asignan los parametros recibidos al llamado y se devuelve
     * un mensaje. En caso contrario, los atributos del llamado serán nulos y se
     * devuelve un mensaje.
     * @param integer $idllamado Recibe el identificador del llamado a modificar.
     * @param string $fecha Recibe la fecha en formato YYYY-MM-DD. 
     * @param string $hora Recibe la hora en formato HH:MM. 
     * @param Aula $aula Recibe el aula.
     * @return string Mensaje con el resultado de la operación.
     * @author Marquez Emanuel.
     * */
    public function modificar($idllamado, $fecha, $hora, $aula)
    {
        if ($idllamado) {
            /* Solo la fecha y hora son obligatorios */
            if ($fecha && $hora) {
                
                $idaula = "null";
                if ($aula) {
                    $idaula = $aula->getIdaula();
                }
                
                $consulta = "UPDATE llamado SET fecha={$fecha}, hora={$hora}, idaula={$aula} WHERE idllamado=".$idaula;
                ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
                if (ObjetoDatos::getInstancia()->affected_rows > 0) {
                    $this->idllamado = $idllamado;
                    $this->fecha = $fecha;
                    $this->hora = $hora;
                    if ($aula) {
                        $this->aula = $aula;
                    } else {
                        $this->aula = null;
                    }
                    return "Se ha modificado el llamado correctamente";
                } else {
                    $this->limpiar();
                    return "No se ha modificado el llamado correctamente";
                }
            }
            return "No se obtuvo la fecha u hora, necesaria para realizar la modificación del llamado";
        }
        return "No se obtuvo la información necesaria para realizar la modificación del llamado";
    }

}