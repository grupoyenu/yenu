<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Usuarios {

    private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function buscar($nombre) {
        $consulta = "SELECT * FROM vista_usuarios WHERE nombreUsuario LIKE '%{$nombre}%'";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

    public function listarUltimosCreados() {
        $consulta = "SELECT * FROM vista_usuarios WHERE estado = 'Activo' ORDER BY idUsuario DESC";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

    public function listarResumenInicial() {
        $consulta = "SELECT 'Total de usuarios' nombre, COUNT(*) cantidad FROM usuario UNION "
                . "SELECT 'Total de usuarios en estado activo' nombre, COUNT(*) cantidad FROM usuario WHERE estado = 'Activo' UNION "
                . "SELECT 'Total de usuarios en estado inactivo' nombre, COUNT(*) cantidad FROM usuario WHERE estado = 'Inactivo'";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

}
