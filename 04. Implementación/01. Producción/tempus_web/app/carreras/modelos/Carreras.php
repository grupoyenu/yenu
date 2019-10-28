<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Carreras {

    private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function buscar($nombre) {
        $consulta = "SELECT ca.*, (CASE WHEN ma.cantidad IS NULL THEN 0 ELSE ma.cantidad END) cantidad "
                . "FROM carrera ca "
                . "LEFT JOIN (SELECT idcarrera, COUNT(idasignatura) cantidad "
                . "FROM asignatura_carrera GROUP BY idcarrera) ma ON ca.codigo = ma.idcarrera "
                . "WHERE ca.nombre LIKE '%{$nombre}%'";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

    public function listarUltimasCreadas() {
        $consulta = "SELECT ca.*, (CASE WHEN ma.cantidad IS NULL THEN 0 ELSE ma.cantidad END) cantidad "
                . "FROM carrera ca LEFT JOIN (SELECT idcarrera, COUNT(idasignatura) cantidad "
                . "FROM asignatura_carrera GROUP BY idcarrera) ma ON ca.codigo = ma.idcarrera LIMIT 10";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

}
