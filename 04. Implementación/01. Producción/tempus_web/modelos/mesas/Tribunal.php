<?php

class Tribunal
{
    private $idtribunal;
    private $presidente;
    private $vocal1;
    private $vocal2;
    private $suplente;
    private $datos;
    
    function __construct()
    {}
    
    /**
     * @return the $idtribunal
     */
    public function getIdtribunal()
    {
        return $this->idtribunal;
    }

    /**
     * @return the $presidente
     */
    public function getPresidente()
    {
        return $this->presidente;
    }

    /**
     * @return the $vocal1
     */
    public function getVocal1()
    {
        return $this->vocal1;
    }

    /**
     * @return the $vocal2
     */
    public function getVocal2()
    {
        return $this->vocal2;
    }

    /**
     * @return the $suplente
     */
    public function getSuplente()
    {
        return $this->suplente;
    }

    /**
     * @param field_type $idtribunal
     */
    public function setIdtribunal($idtribunal)
    {
        $this->idtribunal = $idtribunal;
    }

    /**
     * @param field_type $presidente
     */
    public function setPresidente($presidente)
    {
        $this->presidente = $presidente;
    }

    /**
     * @param field_type $vocal1
     */
    public function setVocal1($vocal1)
    {
        $this->vocal1 = $vocal1;
    }

    /**
     * @param field_type $vocal2
     */
    public function setVocal2($vocal2)
    {
        $this->vocal2 = $vocal2;
    }

    /**
     * @param field_type $suplente
     */
    public function setSuplente($suplente)
    {
        $this->suplente = $suplente;
    }

    
    
    
}

?>