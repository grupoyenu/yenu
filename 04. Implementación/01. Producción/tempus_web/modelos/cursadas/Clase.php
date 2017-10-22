<?php

/**
 * 
 * */
class Clase
{
    /** @var integer */
    private $idclase;
    
    /** @var integer */
    private $dia;
    
    /** @var string */
    private $desde;
    
    /** @var string */
    private $hasta;
    
    /** @var Aula */
    private $aula;
    
    /** @var mysqli_result */
    private $datos;
    
    /**
     * Constructor de la clase.
     * @var integer $idclase Identificador de la clase (Opcional).
     * */
    function __construct($idclase = null)
    {
       
    }
    
    /**
     * @return the $idclase
     */
    public function getIdclase()
    {
        return $this->idclase;
    }

    /**
     * @return the $dia
     */
    public function getDia()
    {
        return $this->dia;
    }

    /**
     * @return the $desde
     */
    public function getDesde()
    {
        return $this->desde;
    }

    /**
     * @return the $hasta
     */
    public function getHasta()
    {
        return $this->hasta;
    }

    /**
     * @return the $aula
     */
    public function getAula()
    {
        return $this->aula;
    }

    /**
     * @param field_type $idclase
     */
    public function setIdclase($idclase)
    {
        $this->idclase = $idclase;
    }

    /**
     * @param field_type $dia
     */
    public function setDia($dia)
    {
        $this->dia = $dia;
    }

    /**
     * @param field_type $desde
     */
    public function setDesde($desde)
    {
        $this->desde = $desde;
    }

    /**
     * @param field_type $hasta
     */
    public function setHasta($hasta)
    {
        $this->hasta = $hasta;
    }

    /**
     * @param field_type $aula
     */
    public function setAula($aula)
    {
        $this->aula = $aula;
    }

   
   
    
}