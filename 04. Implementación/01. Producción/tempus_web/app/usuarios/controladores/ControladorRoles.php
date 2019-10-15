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

    private $rol;
    private $roles;
    private $descripcion;

    public function __construct() {

        ;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function crear($nombre, $permisos) {
        $parametros = array(NULL, $nombre, $permisos);
        $this->rol = new Rol($parametros);
        $creacion = $this->rol->crear();
        $this->descripcion = $this->permiso->getDescripcion();
        return $creacion;
    }

    public function buscar($nombre) {
        $this->roles = new Roles();
        $resultado = $this->roles->buscar($nombre);
        $this->descripcion = $this->roles->getDescripcion();
        return $resultado;
    }

}
