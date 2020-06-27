<?php

namespace app\seguridad\controlador;

use app\seguridad\modelo\Permiso as Permiso;
use app\seguridad\modelo\ColeccionPermisos as Permisos;

/**
 * 
 * @package app\seguridad\controlador
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
class ControladorPermiso {

    public function borrar($id) {
        $permiso = new Permiso($id);
        $resultado = $permiso->borrar();
        return $resultado;
    }

    public function buscarPorNombre($nombrePermiso) {
        return Permisos::buscarPorNombre($nombrePermiso);
    }

    /**
     * Realizar la creacion de un nuevo permiso y guardarlo en la base de datos.
     * @param string $nombre Nombre del nuevo permiso.
     * @return array Arreglo de dos posiciones (codigo, mensaje).
     */
    public function crear($nombre) {
        $permiso = new Permiso(NULL, $nombre);
        return $permiso->crear();
    }

    public function listarPermisos() {
        return Permisos::listarPermisos();
    }

    public function listarInformesPermiso() {
        return Permisos::listarInformesPermiso();
    }

    public function listarResumenPermisos($limite) {
        return Permisos::listarResumenPermisos($limite);
    }

    public function modificar($id, $nombre) {
        $permiso = new Permiso($id, $nombre);
        $modificacion = $permiso->modificar();
        return $modificacion;
    }

}
