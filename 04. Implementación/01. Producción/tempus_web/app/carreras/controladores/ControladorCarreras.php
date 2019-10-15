<?php

/**
 * Description of ControladorCarreras
 *
 * @author Emanuel
 */
class ControladorCarreras {

    private $carrera;
    private $carreras;
    private $descripcion;

    public function __construct() {
        ;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function agregarAsignatura($codigo, $idAsignatura, $anio) {
        $this->carrera = new Carrera();
        $this->carrera->setCodigo($codigo);
        $resultado = $this->carrera->agregarAsignatura($idAsignatura, $anio);
        $this->descripcion = $this->carrera->getDescripcion();
        return $resultado;
    }

    public function buscar($nombre) {
        $this->carreras = new Carreras();
        $resultado = $this->carreras->buscar($nombre);
        $this->descripcion = $this->carreras->getDescripcion();
        return $resultado;
    }

    public function crear($codigo, $nombre) {
        
    }

}
