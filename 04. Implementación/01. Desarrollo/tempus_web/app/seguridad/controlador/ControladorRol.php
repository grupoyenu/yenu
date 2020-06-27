<?php

namespace app\seguridad\controlador;

use app\principal\modelo\Conexion;
use app\seguridad\modelo\ColeccionRoles as Roles;
use app\seguridad\modelo\Rol;

/**
 * 
 * @package app\seguridad\controlador
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
class ControladorRol {

    public function borrar($idRol): array {
        if (Conexion::getInstancia()->iniciarTransaccion()) {
            $rol = new Rol($idRol);
            $resultado = $rol->borrar();
            $confirmar = ($resultado[0] == 2) ? TRUE : FALSE;
            Conexion::getInstancia()->finalizarTransaccion($confirmar);
            return $resultado;
        }
        return array(0, "No se pudo inicializar la transacción para operar");
    }

    public function buscarPorNombre($nombreRol) {
        return Roles::buscarPorNombre($nombreRol);
    }

    public function crear($nombre, $permisos) {
        if (Conexion::getInstancia()->iniciarTransaccion()) {
            $rol = new Rol(NULL, $nombre, $permisos);
            $resultado = $rol->crear();
            $confirmar = ($resultado[0] == 2) ? TRUE : FALSE;
            Conexion::getInstancia()->finalizarTransaccion($confirmar);
            return $resultado;
        }
        return array(0, "No se pudo inicializar la transacción para operar");
    }

    public function listarInformesRol() {
        return Roles::listarInformesRol();
    }

    public function listarRoles() {
        return Roles::listarRoles();
    }

    public function listarResumenRoles($limite) {
        return Roles::listarResumenRoles($limite);
    }

    public function modificar($id, $nombre, $permisos) {
        if (Conexion::getInstancia()->iniciarTransaccion()) {
            $rol = new Rol($id, $nombre, $permisos);
            $resultado = $rol->modificar();
            $confirmar = ($resultado[0] == 2) ? TRUE : FALSE;
            Conexion::getInstancia()->finalizarTransaccion($confirmar);
            return $resultado;
        }
        return array(0, "No se pudo inicializar la transacción para operar");
    }

    public function seleccionar($nombre) {
        return Roles::seleccionar($nombre);
    }

}
