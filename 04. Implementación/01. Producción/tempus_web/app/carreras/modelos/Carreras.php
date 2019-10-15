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
        $carreras = array();
        if ($nombre) {
            $consulta = "SELECT ca.*, ma.cantidad "
                    . "FROM carrera ca "
                    . "LEFT JOIN (SELECT idcarrera, COUNT(idasignatura) cantidad "
                    . "FROM asignatura_carrera GROUP BY idcarrera) ma ON ca.codigo = ma.idcarrera "
                    . "WHERE ca.nombre LIKE '%{$nombre}%'";
            $carreras = Conexion::getInstancia()->seleccionar($consulta);
            if (!empty($carreras)) {
                return $carreras;
            }
            $this->descripcion = (is_null($carreras)) ? "No se pudo realizar la consulta de carreras" : "No se encontraron resultados";
            return $carreras;
        }
        $this->descripcion = "El nombre de la carrera no cumple con el formato requerido";
        return $carreras;
    }

}
