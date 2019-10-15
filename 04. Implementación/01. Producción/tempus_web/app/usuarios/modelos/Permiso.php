<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Permiso
 *
 * @author Emanuel
 */
class Permiso {

    /** @var integer Identificador del permiso en la base de datos */
    private $idPermiso;

    /** @var string Nombre del permiso */
    private $nombre;
    private $roles;

    /** @var string Descripcion para mostrar mensajes */
    private $descripcion;

    public function __construct($parametros = NULL) {
        if ($parametros) {
            $this->setIdPermiso($parametros[0]);
            $this->setNombre($parametros[1]);
        }
    }

    public function getIdPermiso() {
        return $this->idPermiso;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getRoles() {
        return $this->roles;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setIdPermiso($idPermiso) {
        if ($idPermiso) {
            $this->idPermiso = $idPermiso;
        } else {
            $this->descripcion = "No se pudo hacer referencia al permiso";
        }
    }

    public function setNombre($nombre) {
        if (preg_match("/^[A-Z ]{5,30}$/", $nombre)) {
            $this->nombre = $nombre;
        } else {
            $this->descripcion = "El nombre del permiso no cumple con el formato requerido";
        }
    }

    public function setRoles($roles) {
        $this->roles = $roles;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function borrar() {
        if ($this->idPermiso) {
            
        }
        return 1;
    }

    public function crear() {
        if ($this->nombre) {
            $values = "(NULL, '$this->nombre')";
            $creacion = Conexion::getInstancia()->insertar("permiso", $values);
            $this->idPermiso = ($creacion == 2) ? (Int) Conexion::getInstancia()->insert_id : NULL;
            $this->descripcion = Conexion::getInstancia()->getDescripcion();
            return $creacion;
        }
        return 1;
    }

    public function modificar() {
        
    }

}
