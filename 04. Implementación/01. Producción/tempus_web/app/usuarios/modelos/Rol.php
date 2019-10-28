<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Rol {

    /** @var integer Identificador del rol en la base de datos */
    private $idRol;

    /** @var string Nombre del rol */
    private $nombre;

    /** @var array() Permisos asociados al rol */
    private $permisos;

    /** @var string Descripcion para mostrar mensajes */
    private $descripcion;

    public function __construct($id = NULL, $nombre = NULL, $permisos = NULL) {
        $this->setIdRol($id);
        $this->setNombre($nombre);
        $this->setPermisos($permisos);
    }

    public function getIdRol() {
        return $this->idRol;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getPermisos() {
        return $this->permisos;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setIdRol($idRol) {
        if ($idRol) {
            $this->idRol = $idRol;
        } else {
            $this->descripcion = "No se pudo hacer referencia al rol";
        }
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setPermisos($permisos) {
        $this->permisos = $permisos;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    private function agregarPermiso() {
        if (!empty($this->permisos)) {
            foreach ($this->permisos as $permiso) {
                $values = "({$this->idRol}, {$permiso})";
                $creacion = Conexion::getInstancia()->insertar("rol_permiso", $values);
                if ($creacion != 2) {
                    $this->descripcion = "No se realizó la creación del registro asociado al rol";
                    return 1;
                }
            }
            return 2;
        }
        $this->descripcion = "Se debe indicar al menos un permiso para crear el rol";
        return 0;
    }

    public function borrar() {
        if ($this->idRol) {
            
        }
        return 1;
    }

    public function crear() {
        if ($this->nombre) {
            $values = "(NULL, '$this->nombre')";
            $creacion = Conexion::getInstancia()->insertar("rol", $values);
            $this->descripcion = Conexion::getInstancia()->getDescripcion();
            if ($creacion == 2) {
                $this->idRol = (Int) Conexion::getInstancia()->insert_id;
                $creacion = $this->agregarPermiso();
                $this->descripcion = ($creacion == 2) ? $this->nombre . ": Se realizó la creación del registro correctamente" : $this->descripcion;
            }
            return $creacion;
        }
        return 0;
    }

    public function modificar() {
        if ($this->idRol && $this->nombre) {
            
        }
        return 1;
    }

    public function obtener() {
        if ($this->idRol) {
            $consulta = "SELECT * FROM rol WHERE idrol = {$this->idRol}";
            $fila = Conexion::getInstancia()->obtener($consulta);
            if (!is_null($fila)) {
                $this->nombre = $fila['nombre'];
                $this->permisos = $this->obtenerPermisos();
                return 2;
            }
            $this->descripcion = Conexion::getInstancia()->getDescripcion();
        }
        return 1;
    }

    private function obtenerPermisos() {
        $consulta = "SELECT pe.* FROM permiso pe "
                . "INNER JOIN rol_permiso rp ON rp.idpermiso = pe.idpermiso "
                . "AND rp.idrol = {$this->idRol}";
        return Conexion::getInstancia()->seleccionar($consulta);
    }

}
