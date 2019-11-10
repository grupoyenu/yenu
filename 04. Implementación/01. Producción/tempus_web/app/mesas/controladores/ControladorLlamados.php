<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorLlamados {

    private $descripcion;

    function getDescripcion() {
        return $this->descripcion;
    }

    public function modificar($id, $fecha, $hora, $aula) {
        $llamado = new Llamado($id, $fecha, $hora, $aula);
        $modificacion = $llamado->modificar();
        $this->descripcion = $llamado->getDescripcion();
        return $modificacion;
    }

    public function borrar($id) {
        $llamado = new Llamado($id);
        $eliminacion = $llamado->borrar();
        $this->descripcion = $llamado->getDescripcion();
        return $eliminacion;
    }

    public function listarFechas() {
        $llamados = new Llamados();
        $resultado = $llamados->listarFechas();
        $this->descripcion = $llamados->getDescripcion();
        return $resultado;
    }

}
