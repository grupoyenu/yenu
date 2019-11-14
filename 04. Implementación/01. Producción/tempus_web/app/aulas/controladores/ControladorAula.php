<?php

class ControladorAula {

    private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function buscar($campo, $valor) {
        $aulas = new Aulas();
        $resultado = $aulas->buscar($campo, $valor);
        $this->descripcion = $aulas->getDescripcion();
        return $resultado;
    }

    public function crear($sector, $nombre) {
        $aula = new Aula(NULL, $sector, $nombre);
        $creacion = $aula->crear();
        $this->descripcion = $aula->getDescripcion();
        return $creacion;
    }

    public function listar() {
        return $this->aulas->listar();
    }

    public function listarUltimasCreadas() {
        $aulas = new Aulas();
        $resultado = $aulas->listarUltimasCreadas();
        $this->descripcion = $aulas->getDescripcion();
        return $resultado;
    }

    public function listarAulasDisponibles($dia, $desde, $hasta, $nombre) {
        $aulas = new Aulas();
        $resultado = $aulas->listarAulasDisponibles($dia, $desde, $hasta, $nombre);
        $this->descripcion = $aulas->getDescripcion();
        return $resultado;
    }

    public function listarHorariosClase($id) {
        $aulas = new Aulas();
        $resultado = $aulas->listarHorariosClase($id);
        $this->descripcion = $aulas->getDescripcion();
        return $resultado;
    }

    public function modificar($id, $sector, $nombre) {
        $aula = new Aula($id, $sector, $nombre);
        $modificacion = $aula->modificar();
        $this->descripcion = $aula->getDescripcion();
        return $modificacion;
    }

}
