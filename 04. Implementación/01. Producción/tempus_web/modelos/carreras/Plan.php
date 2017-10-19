<?php
require_once 'Carrera.php';
require_once 'Asignatura.php';

/**
 * Esta clase corresponde con la tabla asignaturas-carreras de la base de datos.
 * Contiene los metodos necesarios para crear, borrar, buscar o modificar una relación.
 * Se relaciona con la clase Asignatura y Carrera.
 *
 * Fecha de creación: 18-10-2017.
 *
 * @version 1.0
 *
 * @author Oyarzo Mariela.
 * @author Quiroga Sandra.
 * @author Marquez Emanuel.
 * */
class Plan 
{
    /** @var Asignatura */
    private $asignatura;
    
    /** @var Carrera */
    private $carrera;
    
    /** @var integer */
    private $anio;
    
    /**
     * 
     * @param integer $idasignatura Recibe el identificador de la Asignatura.
     * @param integer $idcarrera Recibe el identificador de la Carrera.
     * */
    function __construct($idasignatura = null, $idcarrera = null) 
    {
        
    }
    
    /**
     * Devuelve la asignatura del plan.
     * @return Asignatura $asignatura
     */
    public function getAsignatura()
    {
        return $this->asignatura;
    }

    /**
     * Devuelve la carrera del plan.
     * @return Carrera $carrera
     */
    public function getCarrera()
    {
        return $this->carrera;
    }

    /**
     * Devuelve el anio al que pertenece la asignatura dentro de la carrera.
     * @return integer $anio
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * Modifica la asignatura que pertenece a la carrera.
     * @param Asignatura $asignatura
     */
    public function setAsignatura($asignatura)
    {
        $this->asignatura = $asignatura;
    }

    /**
     * Modifica la carrera.
     * @param carrera $carrera
     */
    public function setCarrera($carrera)
    {
        $this->carrera = $carrera;
    }

    /**
     * Modifica el anio.
     * @param integer $anio
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;
    }

    /**
     * Realiza la creación de una nueva relación asignatura-carrera.
     * @param integer $idasignatura Identificador de la Asignatura
     * @param integer $idcarrera Identificador de la Carrera.
     * @param integer $anio Anio al que pertenece la carrera.
     * */
    public function crear($idasignatura, $idcarrera, $anio)
    {
        
    }
    
    public function borrar($idasignatura, $idcarrera)
    {
        
    }
    
    /**
     * Realiza la busqueda de una relación asignatura-carrera.
     * @param integer $idasignatura Recibe el identificador de la Asignatura. 
     * @param integer $idcarrera Recibe el identificador de la Carrera.
     * */
    public function buscar($idasignatura, $idcarrera)
    {
        
    }
    
    
    
}