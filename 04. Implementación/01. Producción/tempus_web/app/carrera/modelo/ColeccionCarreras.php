<?php

namespace app\carrera\modelo;

use app\principal\modelo\Conexion;
use app\principal\modelo\Log;

/**
 * 
 * @package app\carrera\modelo.
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
class ColeccionCarreras {

    public static function borrarCarreras() {
        Log::guardar("INF", "COLECCION ASIGNATURAS --> BORRAR CARRERAS NO ASOCIADAS");
        $consulta = "DELETE FROM carrera WHERE id NOT IN "
                . "(SELECT DISTINCT idCarrera FROM Plan)";
        return Conexion::getInstancia()->borrar($consulta);
    }

    /**
     * Realiza la busqueda de carreras a partir del nombre. Se puede indicar el
     * nombre completo o parte del nombre de la carrera a buscar.
     * @param string $nombreCarrera Nombre de la carrera a buscar.
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public static function buscarPorNombre($nombreCarrera) {
        $expresion = "/^[a-záéíóúñü,. ]{0,60}$/";
        if (preg_match($expresion, mb_strtolower($nombreCarrera))) {
            $consulta = "SELECT * FROM vw_carrera "
                    . "WHERE nombreLargo LIKE '%{$nombreCarrera}%' "
                    . "ORDER BY id";
            return Conexion::getInstancia()->seleccionar($consulta);
        }
        return array(0, "El nombre de la carrera no cumple con el formato requerido");
    }

    /**
     * Listar las carreras de una asignatura ordenadas por anio y nombre.
     * @param int $idAsignatura Identificador de la asignatura.
     * @return array Arreglo de dos posiciones (codigo, mensaje).
     */
    public static function listarCarrerasDeAsignatura($idAsignatura) {
        if ($idAsignatura > 0) {
            $consulta = "SELECT c.*, p.anio FROM plan p "
                    . "INNER JOIN carrera c ON c.id = p.idCarrera "
                    . "WHERE p.idAsignatura = {$idAsignatura} "
                    . "ORDER BY p.anio, c.nombreLargo ";
            return Conexion::getInstancia()->seleccionar($consulta);
        }
        return array(0, "No se pudo hacer referencia a la asignatura");
    }

    /**
     * @see vw_informe Consulta cuando modulo es CARRERAS.
     */
    public static function listarInformesCarrera(): array {
        $consulta = "SELECT * FROM vw_informe WHERE modulo = 'CARRERAS'";
        return Conexion::getInstancia()->seleccionar($consulta);
    }

    /**
     * Listar un resumen limitado de carreras. Selecciona el id, nombre corto,
     * nombre largo y cantidad de asignaturas asociadas para una de las carreras 
     * segun el limite establecido.
     * @param int $limite Limite maximo de carreras a seleccionar (LIMIT).
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public static function listarResumenCarreras($limite) {
        if ($limite > 0) {
            $consulta = "SELECT * FROM vw_carrera ORDER BY id DESC LIMIT {$limite}";
            return Conexion::getInstancia()->seleccionar($consulta);
        }
        return array(0, "No se estableció un limite válido");
    }

}
