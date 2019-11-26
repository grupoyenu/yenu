<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorUsuarios {

    private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function borrar($id, $metodo) {
        if (Conexion::getInstancia()->iniciarTransaccion()) {
            $usuario = ($metodo == "Manual") ? new UsuarioManual($id, NULL, NULL, NULL, NULL, NULL) : new Usuario($id, NULL, NULL, NULL, NULL, NULL);
            $eliminacion = $usuario->borrar();
            $this->descripcion = $usuario->getDescripcion();
            $confirmar = ($eliminacion == 2) ? TRUE : FALSE;
            Conexion::getInstancia()->finalizarTransaccion($confirmar);
            return $eliminacion;
        }
        $this->descripcion = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function buscar($nombre) {
        $usuarios = new Usuarios();
        $resultado = $usuarios->buscar($nombre);
        $this->descripcion = $usuarios->getDescripcion();
        return $resultado;
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
        $this->descripcion = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function listarUltimosCreados() {
        $usuarios = new Usuarios();
        $resultado = $usuarios->listarUltimosCreados();
        $this->descripcion = $usuarios->getDescripcion();
        return $resultado;
    }

    public function listarResumenInicial() {
        $usuarios = new Usuarios();
        $resultado = $usuarios->listarResumenInicial();
        $this->descripcion = $usuarios->getDescripcion();
        return $resultado;
    }

    public function modificar($id, $nombre, $email, $rol, $estado, $metodo, $clave) {
        if (Conexion::getInstancia()->iniciarTransaccion()) {
            $usuario = ($metodo == "Manual") ? new UsuarioManual($id, $email, $nombre, $estado, $rol, $clave) : new Usuario($id, $email, $nombre, $metodo, $estado, $rol);
            $modificacion = $usuario->modificar();
            $this->descripcion = $usuario->getDescripcion();
            $confirmar = ($modificacion == 2) ? TRUE : FALSE;
            Conexion::getInstancia()->finalizarTransaccion($confirmar);
            return $modificacion;
        }
        $this->descripcion = "No se pudo inicializar la transacción para operar";
        return 1;
    }

}
