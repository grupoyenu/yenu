<?php

/**
 * Description of ControladorPermisos
 *
 * @author Emanuel
 */
class ControladorPermisos {

    private $permiso;
    private $permisos;
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

    public function borrar($idPermiso) {
        $parametros = array($idPermiso, NULL);
        $this->permiso = new Permiso($parametros);
        $creacion = $this->permiso->borrar();
        $this->descripcion = $this->permiso->getDescripcion();
        return $creacion;
    }

    public function buscar($nombre) {
        $this->permisos = new Permisos();
        $resultado = $this->permisos->buscar($nombre);
        $this->descripcion = $this->permisos->getDescripcion();
        return $resultado;
    }

    public function crear($nombre) {
        $parametros = array(NULL, $nombre);
        $this->permiso = new Permiso($parametros);
        $creacion = $this->permiso->crear();
        $this->descripcion = $this->permiso->getDescripcion();
        return $creacion;
    }

    public function listar() {
        $this->permisos = new Permisos();
        return $this->permisos->listar();
    }

    public function modificar($idPermiso, $nombre) {
        
    }

}
