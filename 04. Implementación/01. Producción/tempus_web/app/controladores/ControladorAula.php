<?php
/**
 * Description of ControladorAula
 *
 * @author Emanuel
 */
class ControladorAula {
    
    /** @var Aula Aula con la que se va a trabajar */
    private $aula;
    
    
    function __construct() {
        $this->aula = new Aula();
    }
    
    public function getDescripcion() {
        return $this->aula->getDescripcion();
    }
    
    /**
     * @return Null, empty o arreglo asociativo de aulas.
     */
    public function buscarAulas(){
        return $this->aula->buscarAulas();
    }
    
    /**
     * @param string $sector Nombre del sector.
     * @param string $nombre Nombre del aula.
     * @return integer 0, 1, 2, 3.
     */
    public function crear($sector, $nombre) {
        $this->aula->constructor($nombre, $sector);
        return $this->aula->crear();
    }
    
    /**
     * @param integer $idaula Identificador del aula a realizar informe.
     * @return multitype null, empty o arreglo de horarios.
     */
    public function informe($idaula) {
        $this->aula->setIdaula($idaula);
        return $this->aula->obtenerHorarios($idaula);
    }
    
    /**
     * @param integer $idaula Identificador del aula a modificar.
     * @param string $sector Nombre del sector.
     * @param string $nombre Nombre del aula.
     * @return integer 0, 1 o 2.
     */
    public function modificar($idaula, $sector, $nombre) {
        $this->aula->constructor($nombre, $sector, $idaula);
        return $this->aula->modificar();
    }
    
}
