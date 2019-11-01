<?php

/**
 * Description of ControladorCarreras
 *
 * @author Emanuel
 */
class ControladorCarreras {

    private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function agregarAsignatura($codigo, $idAsignatura, $anio) {
        $carrera = new Carrera();
        $carrera->setCodigo($codigo);
        $resultado = $this->carrera->agregarAsignatura($idAsignatura, $anio);
        $this->descripcion = $this->carrera->getDescripcion();
        return $resultado;
    }

    public function buscar($nombre) {
        $carreras = new Carreras();
        $resultado = $carreras->buscar($nombre);
        $this->descripcion = $carreras->getDescripcion();
        return $resultado;
    }

    public function crear($codigo, $nombre) {
        
    }

    public function listarUltimasCreadas() {
        $carreras = new Carreras();
        $resultado = $carreras->listarUltimasCreadas();
        $this->descripcion = $carreras->getDescripcion();
        return $resultado;
    }

    public function listarAsignaturasDeCarrera($codigo) {
        $carreras = new Carreras();
        $resultado = $carreras->listarAsignaturasDeCarrera($codigo);
        $this->descripcion = $carreras->getDescripcion();
        return $resultado;
    }

}
