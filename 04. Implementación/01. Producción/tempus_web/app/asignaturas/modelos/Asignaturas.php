<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Asignaturas
 *
 * @author Emanuel
 */
class Asignaturas {

    private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function buscarPorNombre($nombre) {
        $consulta = "SELECT ma.*, ca.cantidad "
                . "FROM asignatura ma "
                . "LEFT JOIN (SELECT idasignatura, COUNT(idasignatura) cantidad "
                . "FROM asignatura_carrera "
                . "GROUP BY idasignatura) ca on ma.idasignatura = ca.idasignatura "
                . "WHERE ma.nombre LIKE '%{$nombre}%'";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

    public function buscarPorCarrera($codigo, $asignatura, $pertenece) {
        $condicion = ($pertenece) ? "IN" : "NOT IN";
        $consulta = "SELECT ma.* FROM asignatura ma "
                . "WHERE ma.idasignatura {$condicion} "
                . "(SELECT idasignatura FROM asignatura_carrera WHERE idcarrera = {$codigo}) "
                . "AND ma.nombre LIKE '%{$asignatura}%' ORDER BY ma.nombre ASC";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

    public function listar() {
        $consulta = "SELECT * FROM asignatura ORDER BY nombre ASC";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

    public function listarUltimasCreadas() {
        $consulta = "SELECT ma.*, (CASE WHEN ca.cantidad IS NULL THEN 0 ELSE ca.cantidad END) cantidad "
                . "FROM asignatura ma "
                . "LEFT JOIN (SELECT idasignatura, COUNT(idasignatura) cantidad "
                . "FROM asignatura_carrera GROUP BY idasignatura) ca on ma.idasignatura = ca.idasignatura "
                . "ORDER BY ma.idasignatura DESC LIMIT 10";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

    public function listarSinCursada($codigo, $nombre) {
        $consulta = "SELECT DISTINCT REL.idasignatura idAsignatura, ASI.nombre nombre "
                . "FROM asignatura_carrera REL "
                . "INNER JOIN asignatura ASI ON ASI.idasignatura = REL.idasignatura "
                . "INNER JOIN carrera CAR ON CAR.codigo = REL.idcarrera "
                . "LEFT JOIN cursada CUR ON CUR.idasignatura = REL.idasignatura AND CUR.idcarrera = REL.idcarrera "
                . "WHERE CUR.idclase IS NULL AND REL.idcarrera = {$codigo} AND ASI.nombre LIKE '%{$nombre}%'";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

    public function listarSinMesa($codigo, $nombre) {
        $consulta = "";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

    public function listarCarrerasAsignatura($idAsignatura) {
        $consulta = "SELECT ac.anio, ac.idcarrera, ca.nombre "
                . "FROM asignatura_carrera ac "
                . "LEFT JOIN carrera ca ON ca.codigo = ac.idcarrera "
                . "WHERE ac.idasignatura = {$idAsignatura} ORDER BY ac.anio, ca.nombre";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

}
