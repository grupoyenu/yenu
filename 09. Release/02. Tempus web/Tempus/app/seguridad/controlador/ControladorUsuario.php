<?php

namespace app\seguridad\controlador;

use app\principal\modelo\Conexion;
use app\seguridad\modelo\ColeccionUsuarios as Usuarios;
use app\seguridad\modelo\Usuario;
use app\seguridad\modelo\UsuarioManual;
use app\seguridad\modelo\UsuarioGoogle;

/**
 * 
 * @package app\seguridad\controlador
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
class ControladorUsuario {

    public function borrarUsuario($id) {
        if (Conexion::getInstancia()->iniciarTransaccion()) {
            $usuario = new Usuario($id);
            $resultado = $usuario->borrar();
            $confirmar = ($resultado[0] == 2) ? TRUE : FALSE;
            Conexion::getInstancia()->finalizarTransaccion($confirmar);
            return $resultado;
        }
        return array(0, "No se pudo inicializar la transacción para operar");
    }

    public function borrarUsuarioGoogle($id) {
        if (Conexion::getInstancia()->iniciarTransaccion()) {
            $usuario = new UsuarioGoogle($id);
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

    public function crear($nombre, $email, $rol, $estado, $metodo) {
        if (Conexion::getInstancia()->iniciarTransaccion()) {
            $usuario = new Usuario(NULL, $email, $nombre, $metodo, $estado, $rol);
            $resultado = $usuario->crear();
            $confirmar = ($resultado[0] == 2) ? TRUE : FALSE;
            Conexion::getInstancia()->finalizarTransaccion($confirmar);
            return $resultado;
        }
        return array(0, "No se pudo inicializar la transacción para operar");
    }

    public function listarInformesUsuario() {
        return Usuarios::listarInformesUsuario();
    }

    public function listarResumenUsuarios($limite) {
        return Usuarios::listarResumenUsuarios($limite);
    }

    public function modificar($id, $nombre, $email, $rol, $estado, $metodo) {
        if (Conexion::getInstancia()->iniciarTransaccion()) {
            $usuario = new Usuario($id, $email, $nombre, $metodo, $estado, $rol);
            $resultado = $usuario->modificar();
            $confirmar = ($resultado[0] == 2) ? TRUE : FALSE;
            Conexion::getInstancia()->finalizarTransaccion($confirmar);
            return $resultado;
        }
        return array(0, "No se pudo inicializar la transacción para operar");
    }

}
