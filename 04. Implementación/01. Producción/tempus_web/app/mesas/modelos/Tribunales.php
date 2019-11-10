<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Tribunales {

    private $descripcion;

    /**
     * Retorna la descripcion de la ultima operacion que se haya realizado.
     * @return string Descripcion de la operacion realizada.
     */
    public function getDescripcion() {
        return $this->descripcion;
    }

    private function alter() {
        $consulta = "ALTER TABLE tribunal AUTO_INCREMENT = 1";
        $alter = Conexion::getInstancia()->borrarConSubconsulta($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $alter;
    }

    public function borrar() {
        $consulta = "DELETE FROM tribunal";
        $eliminacion = Conexion::getInstancia()->borrarConSubconsulta($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        if ($eliminacion == 2) {
            return $this->alter();
        }
        return $eliminacion;
    }

    public function borrarSinMesa() {
        $consulta = "DELETE TRI FROM tribunal TRI JOIN (SELECT idtribunal FROM tribunal "
                . "WHERE idtribunal NOT IN (SELECT DISTINCT idtribunal FROM mesa_examen)) "
                . "CAN ON CAN.idtribunal = TRI.idtribunal";
        $eliminacion = Conexion::getInstancia()->borrarConSubconsulta($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $eliminacion;
    }

}
