<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UsuarioManual extends Usuario {

    private $clave;

    public function __construct($id = NULL, $email = NULL, $nombre = NULL, $estado = NULL, $rol = NULL, $clave = NULL) {
        parent::__construct($id, $email, $nombre, "Manual", $estado, $rol);
        $this->setClave($clave);
    }

    public function getClave() {
        return $this->clave;
    }

    public function setClave($clave) {
        $this->clave = $clave;
    }

    public function crear() {
        $creacion = parent::crear();
        if ($creacion == 2) {
            if ($this->getIdUsuario() && $this->clave) {
                $idUsurio = $this->getIdUsuario();
                $values = "($idUsurio, '{$this->clave}')";
                $creacion = Conexion::getInstancia()->insertar("usuario_manual", $values);
                $this->descripcion = Conexion::getInstancia()->getDescripcion();
                return $creacion;
            }
            $this->descripcion = "No se recibieron todos los campos obligatorios";
            return 0;
        }
        return $creacion;
    }

    public function modificar() {
        $modificacion = parent::modificar();
        if ($modificacion == 2) {
            if ($this->getIdUsuario() && $this->clave) {
                $idUsuario = $this->getIdUsuario();
                $campos = "clave = '{$this->clave}'";
                $condicion = "idusuario={$idUsuario}";
                $modificacion = Conexion::getInstancia()->modificar("usuario_manual", $campos, $condicion);
                $this->descripcion = Conexion::getInstancia()->getDescripcion();
                return $modificacion;
            }
            $this->descripcion = "No se recibieron todos los campos obligatorios";
            return 0;
        }
        return $modificacion;
    }

}
