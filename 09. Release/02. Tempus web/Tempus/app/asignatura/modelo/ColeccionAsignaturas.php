<?php

namespace app\asignatura\modelo;

use app\principal\modelo\Conexion;
use app\principal\modelo\Log;

/**
 * Description of Asignaturas
 * 
 * paquete: asignaturas.
 * namespace: modelos.
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
class ColeccionAsignaturas {

    public static function borrarAsignaturas() {
        Log::guardar("INF", "COLECCION ASIGNATURAS --> BORRAR ASIGNATURAS NO ASOCIADAS");
        $consulta = "DELETE FROM asignatura WHERE id NOT IN "
                . "(SELECT DISTINCT idAsignatura FROM Plan)";
        return Conexion::getInstancia()->borrar($consulta);
    }

    /**
     * Buscar asignaturas por su nombre ordenadas por nombre.
     * @param string $nombreAsignatura Nombre de la asignatura o parte del nombre.
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public static function buscarPorNombre($nombreAsignatura) {
        $expresion = "/^[a-záéíóúñü0-9,. ]{0,60}$/";
        if (preg_match($expresion, mb_strtolower($nombreAsignatura))) {
            $consulta = "SELECT * FROM vw_asignatura "
                    . "WHERE nombreLargo LIKE '%{$nombreAsignatura}%' "
                    . "ORDER BY nombreLargo";
            return Conexion::getInstancia()->seleccionar($consulta);
        }
        return array(0, "El nombre no cumple con el formato requerido");
    }

    /**
     * Buscar asignaturas por su nombre y carrera ordernadas por nombre.
     * @param string $codigoCarrera Codigo de la carrera.
     * @param string $nombreAsignatura Nombre de la asignatura o parte del nombre.
     * @param bool $pertenece True si la asignatura pertenece a la carrera o false.
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public static function buscarPorCarrera($codigoCarrera, $nombreAsignatura, $pertenece) {
        $expresion = "/^[a-záéíóúñü0-9,. ]{0,60}$/";
        if (($codigoCarrera > 0) && preg_match($expresion, mb_strtolower($nombreAsignatura))) {
            $condicion = ($pertenece) ? "IN" : "NOT IN";
            $consulta = "SELECT * FROM asignatura "
                    . "WHERE nombreLargo LIKE '%{$nombreAsignatura}%' AND "
                    . "id {$condicion} (SELECT idAsignatura FROM vw_plan "
                    . "WHERE idCarrera = '{$codigoCarrera}')";
            return Conexion::getInstancia()->seleccionar($consulta);
        }
        return array(0, "Los datos recibidos no cumplen con el formato requerido");
    }

    /**
     * Listar las asignaturas de una carrera ordenadas por anio y nombre.
     * @param type $codigoCarrera Codigo de la carrera.
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public static function listarAsignaturasDeCarrera($codigoCarrera) {
        if ($codigoCarrera > 0) {
            $consulta = "SELECT a.*, p.anio FROM plan p "
                    . "INNER JOIN asignatura a ON a.id = p.idAsignatura "
                    . "WHERE p.idCarrera = {$codigoCarrera} "
                    . "ORDER BY p.anio, a.nombreLargo";
            return Conexion::getInstancia()->seleccionar($consulta);
        }
        return array(0, "El código de carrera no cumple con el formato requerido");
    }

    /**
     * Listar resumen limitado de asignaturas. Selecciona el identificador, nombre
     * y cantidad de carreras para cada una de las asignaturas segun el limite.
     * @param int Limite maximo de asignaturas a seleccionar.
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public static function listarResumenAsignaturas($limite) {
        if ($limite > 0) {
            $consulta = "SELECT * FROM vw_asignatura ORDER BY id DESC LIMIT {$limite}";
            return Conexion::getInstancia()->seleccionar($consulta);
        }
        return array(0, "No se estableció un limite válido");
    }

    /**
     * @see vw_informe Consulta cuando modulo es ASIGNATURAS.
     */
    public static function listarInformesAsignatura(): array {
        $consulta = "SELECT * FROM vw_informe WHERE modulo = 'ASIGNATURAS'";
        return Conexion::getInstancia()->seleccionar($consulta);
    }

}
