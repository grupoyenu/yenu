<?php

namespace app\seguridad\controlador;

use app\principal\modelo\Conexion;
use app\seguridad\modelo\ColeccionUsuarios as Usuarios;
use app\seguridad\modelo\Usuario;

/**
 * 
 * @package app\seguridad\controlador
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
class ControladorUsuario {

    public function borrar($id, $metodo) {
        if (Conexion::getInstancia()->iniciarTransaccion()) {
            $usuario = ($metodo == "Manual") ? new UsuarioManual($id, NULL, NULL, NULL, NULL, NULL) : new Usuario($id, NULL, NULL, NULL, NULL, NULL);
            $resultado = $usuario->borrar();
            $confirmar = ($resultado[0] == 2) ? TRUE : FALSE;
            Conexion::getInstancia()->finalizarTransaccion($confirmar);
            return $resultado;
        }
        return array(0, "No se pudo inicializar la transacción para operar");
    }

    public function buscarPorNombre($nombreUsuario) {
        return Usuarios::buscarPorNombre($nombreUsuario);
    }

    public function crear($nombre, $email, $rol, $estado, $metodo, $clave) {
        if (Conexion::getInstancia()->iniciarTransaccion()) {
            $usuario = ($metodo == "Manual") ? new UsuarioManual(NULL, $email, $nombre, $estado, $rol, $clave) : new Usuario(NULL, $email, $nombre, $metodo, $estado, $rol);
            $creacion = $usuario->crear();
            $this->descripcion = $usuario->getDescripcion();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            Conexion::getInstancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        return array(0, "No se pudo inicializar la transacción para operar");
    }

    public function listarInformesUsuario() {
        return Usuarios::listarInformesUsuario();
    }

    public function listarResumenUsuarios($limite) {
        return Usuarios::listarResumenUsuarios($limite);
    }

    public function modificar($id, $nombre, $email, $rol, $estado, $metodo, $clave) {
        if (Conexion::getInstancia()->iniciarTransaccion()) {
            $usuario = ($metodo == "Manual") ? new UsuarioManual($id, $email, $nombre, $estado, $rol, $clave) : new Usuario($id, $email, $nombre, $metodo, $estado, $rol);
            $resultado = $usuario->modificar();
            $confirmar = ($resultado[0] == 2) ? TRUE : FALSE;
            Conexion::getInstancia()->finalizarTransaccion($confirmar);
            return $resultado;
        }
        return array(0, "No se pudo inicializar la transacción para operar");
    }

}
