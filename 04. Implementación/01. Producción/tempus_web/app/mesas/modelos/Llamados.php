<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Llamados {

    private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function obtenerNumeroLlamados() {
        $consulta = "SELECT COUNT(segundo) cantidad FROM mesa_examen WHERE segundo IS NOT NULL";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        if (gettype($resultado) == "object") {
            $fila = $resultado->fetch_assoc();
            return ($fila['cantidad'] > 0) ? 2 : 1;
        }
        return 0;
    }

    public function listarFechas() {
        $consulta = "SELECT DISTINCT fecha FROM llamado ORDER BY fecha";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

}
