<?php
require_once '../lib/conf/ObjetoDatos.php';
require_once 'Tribunal.php';

/**
 * 
 * */
class MesaExamen
{
    /** @var integer Identificador de la mesa en la base de datos. */
    private $idmesa;
    
    /** @var Aula Aula en el que se dicta la mesa (Si tuviera asignada). */
    private $aula;
    
    /** @var string Fecha en formato YYYY/MM/DD */
    private $fecha;
    
    /** @var string Hora en formato HH:MM:SS */
    private $hora;
    
    /** @var integer 1 es primer llamado, 2 es segundo llamado. */
    private $llamado;
    
    /** @var Plan Asignatura y Carrera a la que pertenece la mesa. */
    private $plan;
    
    /** @var Tribunal Tribunal de la mesa. */
    private $tribunal;
    
    /** @var mysqli_result Resultado de una consulta a la base de datos. */
    private $datos;
    
    function __construct($idmesa = null)
    {
       
    }
   
    /**
     * Devuelve el identificador la mesa.
     * @return integer $idmesa
     */
    public function getIdmesa()
    {
        return $this->idmesa;
    }

    /**
     * Devuelve el identificador del aula.
     * @return integer $aula
     */
    public function getAula()
    {
        return $this->aula;
    }

    /**
     * Devuelve la fecha de mesa.
     * @return string $fecha
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Devuelve la hora de la mesa.
     * @return string $hora
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Devuelve el llamado de la mesa.
     * @return integer $llamado
     */
    public function getLlamado()
    {
        return $this->llamado;
    }

    /**
     * Devuelve el plan al que pertenece la mesa.
     * @return Plan $plan
     */
    public function getPlan()
    {
        return $this->plan;
    }

    /**
     * Devuelve el tribunal de mesa.
     * @return Tribunal $tribunal
     */
    public function getTribunal()
    {
        return $this->tribunal;
    }

    /**
     * Modifica el identificador de la mesa.
     * @param integer $idmesa
     */
    public function setIdmesa($idmesa)
    {
        $this->idmesa = $idmesa;
    }

    /**
     * Modifica el aula donde se desarrolla la mesa.
     * @param Aula $aula
     */
    public function setAula($aula)
    {
        $this->aula = $aula;
    }

    /**
     * Modifica la fecha de mesa.
     * @param string $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * Modifica la hora de la mesa.
     * @param string $hora
     */
    public function setHora($hora)
    {
        $this->hora = $hora;
    }

    /**
     * Modifica el llamado de mesa.
     * @param integer $llamado
     */
    public function setLlamado($llamado)
    {
        $this->llamado = $llamado;
    }

    /**
     * Modifica el plan al que pertenece la mesa.
     * @param Plan $plan
     */
    public function setPlan($plan)
    {
        $this->plan = $plan;
    }

    /**
     * Modifica el tribunal de la mesa.
     * @param Tribunal $tribunal
     */
    public function setTribunal($tribunal)
    {
        $this->tribunal = $tribunal;
    }
    
    /**
     * Realiza la creación de una nueva mesa de examen. Para ello, primero se realiza
     * una búsqueda para verificar que no exista la mesa. Si la mesa de examen ya 
     * existe (Asignatura-Carrera y llamado), se obtiene la información de la misma.
     * En caso contrario, se realiza la creación del registro y se obtiene el idmesa.
     * @param Plan $plan (Obligatorio).
     * @param Tribunal $tribunal Tribunal de mesa (Obligatorio).
     * @param Aula $aula Aula donde se dicta la mesa (Opcional).
     * @param string $fecha Fecha en formato YYYY-MM-DD (Obligatorio).
     * @param string $hora Hora HH:MM (Obligatorio).
     * @param integer $llamado 1 - Primer llamado o 2 - Segundo llamado (Obligatorio).
     * */
    public function crear($plan, $tribunal, $aula = null, $fecha, $hora, $llamado)
    {
        $this->buscar($plan, $llamado);
        if (is_null($this->idmesa)) {
            /* No se ha encontrado una mesa de examen. Se crea una nueva. */
            $idasignatura = $plan->getAsignatura()->getIdasignatura();
            $idcarrera = $plan->getCarrera()->getCodigo();
            $idtribunal = $tribunal->getIdtribunal();
            $idaula = "NULL";
            if ($aula) {
                $idaula = $aula->getIdaula();
            }
            $consulta = "INSERT INTO mesa_examen VALUES ";
            $consulta = $consulta."(null,".$idasignatura.",".$idcarrera.",".$idaula.",".$idtribunal.",'".$fecha."','".$hora."',".$llamado.")";
            ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
            $this->idmesa = (Int) ObjetoDatos::getInstancia()->insert_id;
            $this->plan = $plan;
            $this->tribunal = $tribunal;
            $this->aula = $aula;
            $this->fecha = $fecha;
            $this->hora = $hora;
            $this->llamado = $llamado;
        }
    }
    
    /**
     * */
    public function borrar()
    {
        
    }
    
    /**
     * Realiza la búsqueda de una mesa de examen.
     * @param Plan $plan
     * */
    public function buscar($plan, $llamado)
    {
        $idasignatura = $plan->getAsignatura()->getIdasignatura();
        $idcarrera = $plan->getCarrera()->getCodigo();
        $consulta = "SELECT * FROM mesa_examen WHERE ";
        $consulta = $consulta."idasignatura = ".$idasignatura." AND idcarrera = ".$idcarrera." AND llamado =".$llamado;
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if ($this->datos->num_rows > 0) {
            
            $fila = $this->datos->fetch_row();
            $this->idmesa = $fila[0];
            $this->plan = $plan;
            $this->aula = null;
            if($fila[3]) {
                $this->aula = new Aula($fila[3]);
            }
            $this->tribunal = new Tribunal($fila[4]);
            $this->fecha = $fila[5];
            $this->hora = $fila[6];
            $this->llamado = $fila[7];
            
        } else {
            $this->idmesa = null;
            $this->plan = null;
            $this->aula = null;
            $this->tribunal = null;
            $this->fecha = null;
            $this->hora = null;
            $this->llamado = null;
        }
        $this->datos = null;
    }

}
