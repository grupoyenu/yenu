<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Carreras {

    /** @var string Descripcion del resultado de alguna busqueda. */
    private $descripcion;

    /**
     * Retorna la descripcion del resultado de alguna busqueda.
     * @return stirng Descripcion de la operacion.
     */
    public function getDescripcion() {
        return $this->descripcion;
    }

    /**
     * Realiza la busqueda de carreras a partir del nombre. Se puede indicar el
     * nombre completo o parte del nombre de la carrera a buscar.
     * @param string $nombre Nombre de la carrera a buscar.
     * @return integer 0 si falla la consulta, 1 si no hay resultado o resource.
     */
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

    /**
     * Realiza la busqueda de las ultimas 10 carreras que se crearon. El objetivo
     * es mostrar resultados previos antes de realizar una busqueda de carrera.
     * @return integer 0 si falla la consulta, 1 si no hay resultado o resource.
     */
    public function listarUltimasCreadas() {
        $consulta = "SELECT ca.*, (CASE WHEN ma.cantidad IS NULL THEN 0 ELSE ma.cantidad END) cantidad "
                . "FROM carrera ca LEFT JOIN (SELECT idcarrera, COUNT(idasignatura) cantidad "
                . "FROM asignatura_carrera GROUP BY idcarrera) ma ON ca.codigo = ma.idcarrera LIMIT 10";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

    /**
     * Realiza la busqueda de todas las asignaturas de una determinada carrera. Se
     * busca cada una de las asignturas a partir del codigo de la carrera.
     * @param integer $codigo Codigo de la carrera a consultar.
     * @return integer 0 si falla la consulta, 1 si no hay resultado o resource.
     */
    public function listarAsignaturasDeCarrera($codigo) {
        $consulta = "SELECT ac.anio, ac.idasignatura, asi.nombre "
                . "FROM asignatura_carrera ac "
                . "LEFT JOIN asignatura asi ON asi.idasignatura = ac.idasignatura "
                . "WHERE ac.idcarrera = {$codigo} ORDER BY ac.anio, asi.nombre";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

    /**
     * Realiza la busqueda de todas las carreras que tengan al menos una asignatura
     * sin cursada. El objetivo es que se seleccionen solo las carreras que
     * puedan tener asignaturas sin cursada al momento de crear o modificar un
     * horario de cursada.
     * @param string $nombre Nombre de la carrera.
     * @return integer 0 si la consulta falla, 1 si no hay resultados o resource.
     */
    public function listarSinCursada($nombre) {
        $consulta = "";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

    /**
     * Realiza la busqueda de todas las carreras que no tengan al menos una 
     * asignatura sin mesa. El objetivo es mostrar solo las carreras que cumplan
     * esta condicion al momento de realizar la creacion o modificacion de una
     * mesa de examen.
     * @param string $nombre Nombre de la carrera.
     * @return integer 0 si la consulta falla, 1 si no hay resultados o resource.
     */
    public function listarSinMesa($nombre) {
        $consulta = "";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

}
