<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Docentes {

    private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }

    private function alter() {
        $consulta = "ALTER TABLE docente AUTO_INCREMENT = 1";
        $alter = Conexion::getInstancia()->borrarConSubconsulta($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $alter;
    }

    public function borrar() {
        $consulta = "DELETE FROM docente";
        $eliminacion = Conexion::getInstancia()->borrarConSubconsulta($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        if ($eliminacion == 2) {
            return $this->alter();
        }
        return $eliminacion;
    }

    /**
     * Elimina de la base de datos a los docentes que no pertenezcan a ningun tribunal.
     */
    public function borrarSinTribunal() {
        $consulta = "DELETE DOC FROM docente DOC JOIN (SELECT iddocente FROM docente "
                . "WHERE iddocente NOT IN (SELECT DISTINCT presidente iddocente "
                . "FROM tribunal UNION SELECT DISTINCT vocal1 iddocente FROM tribunal "
                . "UNION SELECT DISTINCT vocal2 iddocente FROM tribunal "
                . "UNION SELECT DISTINCT suplente iddocente FROM tribunal)) "
                . "CAN ON CAN.iddocente = DOC.iddocente";
        $eliminacion = Conexion::getInstancia()->borrarConSubconsulta($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $eliminacion;
    }

    public function buscar($nombre) {
        $consulta = "SELECT * FROM docente WHERE nombre LIKE '%{$nombre}%' ORDER BY nombre";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

    public function listarUltimosCreados() {
        $consulta = "SELECT * FROM docente ORDER BY iddocente DESC LIMIT 10";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

}
