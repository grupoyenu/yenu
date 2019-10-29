<?php

class ControladorAula {

    private $aula;
    private $aulas;
    private $descripcion;

    public function __construct() {
        $this->aula = new Aula();
        $this->aulas = new Aulas();
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function buscar($campo, $valor) {
        $resultado = $this->aulas->buscar($campo, $valor);
        $this->descripcion = $this->aulas->getDescripcion();
        return $resultado;
    }

    public function crear($sector, $nombre) {
        $parametros = array(NULL, $nombre, $sector);
        $this->aula = new Aula($parametros);
        $creacion = $this->aula->crear();
        $this->descripcion = $this->aula->getDescripcion();
        return $creacion;
    }

    public function listar() {
        return $this->aulas->listar();
    }

    public function listarUltimasCreadas() {
        $resultado = $this->aulas->listarUltimasCreadas();
        $this->descripcion = $this->aulas->getDescripcion();
        return $resultado;
    }

    public function listarAulasDisponibles($dia, $desde, $hasta) {
        $aulas = new Aulas();
        $resultado = $aulas->listarAulasDisponibles($dia, $desde, $hasta);
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
        $this->aula = new Aula($id, $sector, $nombre);
        $modificacion = $this->aula->modificar();
        $this->descripcion = $this->aula->getDescripcion();
        return $modificacion;
    }

}
