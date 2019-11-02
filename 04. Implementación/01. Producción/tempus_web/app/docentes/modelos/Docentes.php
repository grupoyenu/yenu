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

    public function borrar() {
        $consulta = "DELETE FROM docente WHERE 1";
        $eliminacion = Conexion::getInstancia()->borrarConSubconsulta($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
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

}
