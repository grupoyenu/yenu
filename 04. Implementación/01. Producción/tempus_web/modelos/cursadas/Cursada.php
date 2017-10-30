<?php

/**
 * 
 * */
class Cursada 
{
    private $plan;
    
    /** @var Clase[] */
    private $clases;
    
    /** @var mysqli_result */
    private $datos;
   
    /**
     * Constructor de clase.
     * */ 
    function __construct()
    {
        $this->clases = array();
    }
    
    /**
     * @return Plan $plan
     */
    public function getPlan()
    {
        return $this->plan;
    }

    /**
     * @return Clase[] $clases
     */
    public function getClases()
    {
        return $this->clases;
    }

    /**
     * @param Plan $plan
     */
    public function setPlan($plan)
    {
        $this->plan = $plan;
    }

    /**
     * @param Clase[] $clases
     */
    public function setClases($clases)
    {
        $this->clases = $clases;
    }

    /**
     * Realiza la creacion de una cursada.
     * @param Plan $plan Asignatura y Carrera para la Cursada (Obligatorio).
     * @param array
     * */
    public function crear($plan, $clases = array())
    {
        $tamanio = count($clases);
        $idasignatura = $plan->getAsignatura()->getIdasignatura();
        $idcarrera = $plan->getCarrera()->getCodigo();
      
        for ($i=0; $i < $tamanio; $i++) {
            
            $clase =  $clases[$i];
            
            $dia = $clase->getDia();
            $desde = $clase->getDesde();
            $hasta = $clase->getHasta();
            $aula = $clase->getAula();
            $clase->crear($dia, $desde, $hasta, $aula);
            
            $idclase = $clase->getIdclase();
            
            if ($idclase) {
                /* Se ha creado la clase */
                $resultado = $this->crearRelacion($idasignatura, $idcarrera, $idclase);
                if ($resultado) {
                    $this->clases [] = $clase;
                }
            }
        }
    }
    
    /**
     * Crea una nueva relacion entre cursada y clase.
     * @param integer $idasignatura Identificador de la asignatura.
     * @param integer $idcarrera Identificador de la carrera.
     * @param integer $idclase Identificador de la clase.
     * */
    private function crearRelacion($idasignatura, $idcarrera, $idclase)
    {
        $resultado = $this->buscarRelacion($idasignatura, $idcarrera, $idclase);
        
        if (!$resultado) { 
            $consulta = "INSERT INTO cursada VALUES (".$idasignatura.",".$idcarrera.",".$idclase.")";
            $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
            if (ObjetoDatos::getInstancia()->affected_rows > 0) {
                $resultado = true;
            } else {
                $resultado = false;
            }
        }
        return $resultado;
    }
    
    public function buscar($idasignatura, $idcarrera)
    {
        
    }
    
    /**
     * Controla que no exista cargada la relacion entre cursada y clase.
     * @return boolean Verdadero si existe o Falso en caso contrario.
     * */
    private function buscarRelacion($idasignatura, $idcarrera, $idclase)
    {
        $resultado = false;
        $consulta = "SELECT * FROM cursada WHERE idasignatura = ".$idasignatura." AND idcarrera = ".$idcarrera." AND idclase = ".$idclase."";
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if ($this->datos->num_rows > 0) {
            $resultado = true;
        }
        $this->datos = null;
        return $resultado;
    }
    
    /**
     * Obtiene las clases de una asignatura para una determinada carrera.
     * */
    public function obtenerHorarios($idasignatura, $idcarrera)
    {
        $consulta = "SELECT `idclase` FROM `cursada` WHERE `idasignatura`={$idasignatura} AND `idcarrera`= ".$idcarrera;
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if ($this->datos->num_rows > 0) {
            $this->clases = array(6);
            while ($fila = mysqli_fetch_array($this->datos)) {
                $clase = new Clase($fila[0]);
                $this->clases [$clase->getDia()] = $clase;
            }
        } else {
            $this->clases = null;
        }
        $this->datos = null;
    }
    
    
    
  
}