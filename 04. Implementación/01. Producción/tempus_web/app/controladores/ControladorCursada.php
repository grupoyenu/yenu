<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorCursada {

    private $cursada;
    private $descripcion;

    function __construct() {
        $this->cursada = new Cursada();
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function buscar($nombreAsignatura) {
        $cursadas = new Cursadas();
        return $cursadas->buscar($nombreAsignatura);
    }

    public function crear($plan, $clases) {
        Conexion::getInstancia()->setAutocommit(false);
        $this->cursada->cargar($plan, $clases);
        $creacion = $this->cursada->crear();
        $this->descripcion = $this->cursada->getDescripcion();
        $this->procesarTransaccion($creacion);
        Conexion::getInstancia()->setAutocommit(true);
        return $creacion;
    }

    private function procesarTransaccion($resultado) {
        switch ($resultado) {
            case 1:
                Conexion::getInstancia()->executeRollback();
                break;
            case 2:
                Conexion::getInstancia()->executeCommit();
                break;
            default:
                Conexion::getInstancia()->executeRollback();
                break;
        }
    }

}
