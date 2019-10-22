<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControladorRoles
 *
 * @author Emanuel
 */
class ControladorRoles {

    private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function buscar($nombre) {
        $roles = new Roles();
        $resultado = $roles->buscar($nombre);
        $this->descripcion = $roles->getDescripcion();
        return $resultado;
    }

    public function crear($nombre, $permisos) {
        $parametros = array(NULL, $nombre, $permisos);
        $this->rol = new Rol($parametros);
        $creacion = $this->rol->crear();
        $this->descripcion = $this->permiso->getDescripcion();
        return $creacion;
    }

    public function listarUltimosCreados() {
        $roles = new Roles();
        $resultado = $roles->listarUltimosCreados();
        $this->descripcion = $roles->getDescripcion();
        return $resultado;
    }

}
