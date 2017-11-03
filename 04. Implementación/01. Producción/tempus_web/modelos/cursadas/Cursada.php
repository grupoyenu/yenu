<?php

/**
 * 
 * */
class Cursada 
{
    /** @var Plan  */
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
     * Realiza la creación de una cursada. Para ello realiza la creacion de cada
     * una de las clases del arreglo y luego crea la relación entre el plan y la
     * clase. Devuelve verdadero cuando ambos registros se crean, falso cuando no
     * se crea la clase o la relación (tabla cursada de la base de datos).
     * @param Plan $plan Asignatura y Carrera para la Cursada (Obligatorio).
     * @param Clase[] $clases Recibe el conjunto de clases para el plan (Obligatorio).
     * @return boolean true o false.
     * @author Márquez Emanuel.
     * */
    public function crear($plan, $clases = array())
    {
        if (isset($clases)) {
            
            $tamanio = count($clases);
            $idasignatura = $plan->getAsignatura()->getIdasignatura();
            $idcarrera = $plan->getCarrera()->getCodigo();
            $contadorexitos = 0;
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
                        $contadorexitos = $contadorexitos + 1;
                        $this->clases [] = $clase;
                    }
                }
            }
            
            if ($contadorexitos > 0) {
                return true;
            } else {
                return false;
            }
            
        } else {
            return false;
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