<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorUsuarios {

    private $descripcion;

    public function buscar($nombre) {
        $usuarios = new Usuarios();
        $resultado = $usuarios->buscar($nombre);
        $this->descripcion = $usuarios->getDescripcion();
        return $resultado;
    }

    public function crear($email, $nombre, $metodo, $estado) {
        
    }

    public function listarUltimosCreados() {
        $usuarios = new Usuarios();
        $resultado = $usuarios->listarUltimosCreados();
        $this->descripcion = $usuarios->getDescripcion();
        return $resultado;
    }

}
