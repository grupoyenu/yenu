<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControladorDocentes
 *
 * @author Emanuel
 */
class ControladorDocentes {

    private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function crear() {
        
    }

    public function buscar($nombre) {
        $docentes = new Docentes();
        $resultado = $docentes->buscar($nombre);
        $this->descripcion = $docentes->getDescripcion();
        return $resultado;
    }

    public function listarUltimosCreados() {
        $docentes = new Docentes();
        $resultado = $docentes->listarUltimosCreados();
        $this->descripcion = $docentes->getDescripcion();
        return $resultado;
    }

}
