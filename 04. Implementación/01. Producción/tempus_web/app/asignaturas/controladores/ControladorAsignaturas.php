<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorAsignaturas {

    private $asignatura;
    private $asignaturas;
    private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function agregarCarrera($id, $codigo, $anio) {
        $this->asignatura = new Asignatura();
        $this->asignatura->setIdAsignatura($id);
        $resultado = $this->asignatura->agregarCarrera($codigo, $anio);
        $this->descripcion = $this->asignatura->getDescripcion();
        return $resultado;
    }

    public function buscarPorNombre($nombre) {
        $this->asignaturas = new Asignaturas();
        $resultado = $this->asignaturas->buscarPorNombre($nombre);
        $this->descripcion = $this->asignaturas->getDescripcion();
        return $resultado;
    }

    public function buscarPorCarrera($codigo, $pertenece) {
        $this->asignaturas = new Asignaturas();
        $resultado = $this->asignaturas->buscarPorCarrera($codigo, $pertenece);
        $this->descripcion = $this->asignaturas->getDescripcion();
        return $resultado;
    }

    public function crear($nombre) {
        
    }

    public function listar() {
        $this->asignaturas = new Asignaturas();
        $resultado = $this->asignaturas->listar();
        $this->descripcion = $this->asignaturas->getDescripcion();
        return $resultado;
    }

    public function listarUltimasCreadas() {
        $this->asignaturas = new Asignaturas();
        $resultado = $this->asignaturas->listarUltimasCreadas();
        $this->descripcion = $this->asignaturas->getDescripcion();
        return $resultado;
    }

    public function listarCarrerasAsignatura($id) {
        $asignaturas = new Asignaturas();
        $resultado = $asignaturas->listarCarrerasAsignatura($id);
        $this->descripcion = $asignaturas->getDescripcion();
        return $resultado;
    }

    public function listarSinCursada($codigo, $nombre) {
        $asignaturas = new Asignaturas();
        $resultado = $asignaturas->listarSinCursada($codigo, $nombre);
        $this->descripcion = $asignaturas->getDescripcion();
        return $resultado;
    }

    public function listarSinMesa($codigo, $nombre) {
        $asignaturas = new Asignaturas();
        $resultado = $asignaturas->listarSinMesa($codigo, $nombre);
        $this->descripcion = $asignaturas->getDescripcion();
        return $resultado;
    }

}
