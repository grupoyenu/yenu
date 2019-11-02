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

    public function borrar() {
        $consulta = "DELETE FROM llamado WHERE 1";
        $eliminacion = Conexion::getInstancia()->borrarConSubconsulta($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $eliminacion;
    }

    /**
     * Elimina de la base de datos a los llamados que no pertenecen a ninguna mesa de examen.
     */
    public function borrarSinMesa() {
        $consulta = "DELETE LLA FROM llamado LLA JOIN (SELECT idllamado FROM llamado "
                . "WHERE idllamado NOT IN (SELECT DISTINCT primero idllamado FROM mesa_examen "
                . "WHERE primero IS NOT NULL UNION SELECT DISTINCT segundo idllamado "
                . "FROM mesa_examen WHERE segundo IS NOT NULL)) CAN ON CAN.idllamado = LLA.idllamado";
        $eliminacion = Conexion::getInstancia()->borrarConSubconsulta($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $eliminacion;
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
