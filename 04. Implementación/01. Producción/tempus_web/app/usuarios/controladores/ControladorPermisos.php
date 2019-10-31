<?php

/**
 * Description of ControladorPermisos
 *
 * @author Emanuel
 */
class ControladorPermisos {

    private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function borrar($idPermiso) {
        $permiso = new Permiso($idPermiso);
        $creacion = $permiso->borrar();
        $this->descripcion = $permiso->getDescripcion();
        return $creacion;
    }

    public function buscar($nombre) {
        $permisos = new Permisos();
        $resultado = $permisos->buscar($nombre);
        $this->descripcion = $permisos->getDescripcion();
        return $resultado;
    }

    public function crear($nombre) {
        $permiso = new Permiso(NULL, $nombre);
        $creacion = $permiso->crear();
        $this->descripcion = $permiso->getDescripcion();
        return $creacion;
    }

    public function listar() {
        $permisos = new Permisos();
        return $permisos->listar();
    }

    public function listarUltimosCreados() {
        $permisos = new Permisos();
        $resultado = $permisos->listarUltimosCreados();
        $this->descripcion = $permisos->getDescripcion();
        return $resultado;
    }

    public function modificar($idPermiso, $nombre) {
        
    }

}
