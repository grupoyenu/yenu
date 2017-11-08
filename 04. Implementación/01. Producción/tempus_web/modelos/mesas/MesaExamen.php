<?php

/**
 * 
 * */
class MesaExamen
{
    /** @var integer Identificador de la mesa en la base de datos. */
    private $idmesa;
    
    /** @var Plan Asignatura y Carrera a la que pertenece la mesa. */
    private $plan;
    
    /** @var Tribunal Tribunal de la mesa. */
    private $tribunal;
    
    /** @var Llamado Primer llamado. */
    private $primero;
    
    /**@var Llamado Segundo llamado.  */
    private $segundo;
    
    /** @var mysqli_result Resultado de una consulta a la base de datos. */
    private $datos;
    
    function __construct($idmesa = null)
    {
       
    }
    
    /**
     * @return integer $idmesa
     */
    public function getIdmesa()
    {
        return $this->idmesa;
    }

    /**
     * @return Plan $plan
     */
    public function getPlan()
    {
        return $this->plan;
    }

    /**
     * @return Tribunal $tribunal
     */
    public function getTribunal()
    {
        return $this->tribunal;
    }

    /**
     * @return Llamado $primero
     */
    public function getPrimero()
    {
        return $this->primero;
    }

    /**
     * @return Llamado $segundo
     */
    public function getSegundo()
    {
        return $this->segundo;
    }

    /**
     * @param integer $idmesa
     */
    public function setIdmesa($idmesa)
    {
        $this->idmesa = $idmesa;
    }

    /**
     * @param Plan $plan
     */
    public function setPlan($plan)
    {
        $this->plan = $plan;
    }

    /**
     * @param Tribunal $tribunal
     */
    public function setTribunal($tribunal)
    {
        $this->tribunal = $tribunal;
    }

    /**
     * @param Llamado $primero
     */
    public function setPrimero($primero)
    {
        $this->primero = $primero;
    }

    /**
     * @param Llamado $segundo
     */
    public function setSegundo($segundo)
    {
        $this->segundo = $segundo;
    }
    
    /**
     * Realiza la creacion de una nueva mesa de examen. Primero se realiza la búsqueda de 
     * mesa de examen. En caso que exista, se obtiene su información. En caso contrario, 
     * se crea un nuevo registro. Para ello, tambien se hace la creacion del tribunal, 
     * primer llamado y segundo llamado. 
     * @param Plan $plan El plan debe existir en la base de datos (Obligatorio).
     * @param Tribunal $tribunal El tribunal debe existir en la base de datos (Obligatorio).
     * @param Llamado $primero El llamado se crea (Obligatorio).
     * @param Llamado $segundo El llamado se crea (Opcional).
     * @return string Mensaje asociado a la operación.
     * */
    public function crear($plan, $tribunal, $primero, $segundo) 
    {
        $this->buscar($plan);
        if (is_null($this->idmesa)) {
            /* No se ha encontrado una mesa de examen - Se crea una nueva. */
            $idasignatura = $plan->getAsignatura()->getIdasignatura();
            $idcarrera = $plan->getCarrera()->getCodigo();
            $idprimero = 'null';
            $idsegundo = 'null';
            
            /* Crea el o los llamados para la mesa de examen */
            if ($primero) {
                $idaula = null;
                if ($primero->getAula()) {
                    $idaula = $primero->getAula()->getIdaula();
                }
                
                $primero->crear($primero->getFecha(), $primero->getHora(), $idaula);
                if ($primero->getIdllamado()) {
                    $idprimero = $primero->getIdllamado();
                } else {
                    $primero = null;
                }
            }
            if ($segundo) {
                $idaula = null;
                if ($segundo->getAula()) {
                    $idaula = $segundo->getAula()->getIdaula();
                }
                $segundo->crear($segundo->getFecha(), $segundo->getHora(), $idaula);
                if ($segundo->getIdllamado()) {
                    $idsegundo = $segundo->getIdllamado();
                } else {
                    $segundo = null;
                }
            }
            
            if ($primero || $segundo) {
                $consulta = "INSERT INTO mesa_examen VALUES ";
                $consulta = $consulta."(null,".$idasignatura.",".$idcarrera.",".$tribunal->getIdtribunal().",".$idprimero.",".$idsegundo.")";
                
                ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
                
                if (ObjetoDatos::getInstancia()->affected_rows > 0) {
                    $this->idmesa = (Int) ObjetoDatos::getInstancia()->insert_id;
                    $this->plan = $plan;
                    $this->tribunal = $tribunal;
                    $this->primero = $primero;
                    $this->segundo = $segundo;
                    return "Se ha creado la mesa de examen correctamente";
                } else {
                    $this->limpiarMesaExamen();
                    return "No se ha podido realizar la creación de la mesa de examen";
                }
            } else {
                $this->limpiarMesaExamen();
                return "No se ha podido realizar la creación de llamado para la mesa de examen";
            }
        }
        return "Se ha encontrado una mesa de examen para la asignatura en la carrera indicada";
    }
    
    /**
     * */
    public function borrar()
    {
        
    }
    
    /**
     * Realiza la búsqueda de una mesa de examen. Cuando se encuentra la mesa de examen
     * se obtiene toda la información asociada. En caso contrario, cada uno de sus atributos
     * seran nulos. 
     * @param Plan $plan Recibe la asignatura y carrera de la mesa de examen (Obligatorio).
     * */
    public function buscar($plan)
    {
        $idasignatura = $plan->getAsignatura()->getIdasignatura();
        $idcarrera = $plan->getCarrera()->getCodigo();
        $consulta = "SELECT * FROM mesa_examen WHERE ";
        $consulta = $consulta."idasignatura = ".$idasignatura." AND idcarrera = ".$idcarrera;
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if ($this->datos->num_rows > 0) {
            
            $fila = $this->datos->fetch_row();
            $this->idmesa = $fila[0];
            $this->plan = new Plan($fila[1], $fila[2]);
            $this->tribunal = new Tribunal($fila[3]);
            $this->primero = new Llamado($fila[4]);
            if($fila[5]) {
                $this->segundo = new Llamado($fila[5]);
            }
            
        } else {
            $this->limpiarMesaExamen();
        }
        $this->datos = null;
    }
    
    /**
     * Coloca todos los atributos de la mesa de examen en nulo.
     * 
     * */
    private function limpiarMesaExamen() 
    {
        $this->idmesa = null;
        $this->plan = null;
        $this->tribunal = null;
        $this->primero = null;
        $this->segundo = null;
    }

}
