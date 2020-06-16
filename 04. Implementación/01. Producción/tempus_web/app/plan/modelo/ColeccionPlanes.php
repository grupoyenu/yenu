<?php

namespace app\plan\modelo;

use app\asignatura\modelo\ColeccionAsignaturas as Asignaturas;
use app\carrera\modelo\ColeccionCarreras as Carreras;
use app\principal\modelo\Conexion;
use app\principal\modelo\Log;

/**
 * 
 * @package app\plan\modelo.
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
class ColeccionPlanes {

    public static function buscarPlanSinCursada($nombreAsignatura) {
        $expresion = "/^[a-záéíóúñü0-9,. ]{0,60}$/";
        if (preg_match($expresion, mb_strtolower($nombreAsignatura))) {
            $consulta = "SELECT idPlan, nombreLargoAsignatura, nombreLargoCarrera "
                    . "FROM vw_plan WHERE cursada = 'No' COLLATE utf8mb4_unicode_ci AND "
                    . "nombreLargoAsignatura LIKE '%{$nombreAsignatura}%'";
            return Conexion::getInstancia()->seleccionar($consulta);
        }
        return array(0, "El nombre no cumple con el formato requerido");
    }

    public static function buscarPlanSinMesaExamen($nombreAsignatura) {
        $expresion = "/^[a-záéíóúñü0-9,. ]{0,60}$/";
        if (preg_match($expresion, mb_strtolower($nombreAsignatura))) {
            $consulta = "SELECT idPlan, nombreLargoAsignatura, nombreLargoCarrera "
                    . "FROM vw_plan WHERE mesaExamen = 'No' COLLATE utf8mb4_unicode_ci AND "
                    . "nombreLargoAsignatura LIKE '%{$nombreAsignatura}%'";
            return Conexion::getInstancia()->seleccionar($consulta);
        }
        return array(0, "El nombre no cumple con el formato requerido");
    }

    public static function quitarMesasExamen() {
        Log::guardar("INF", "COLECCION PLANES --> QUITAR MESAS DE EXAMEN");
        $consulta = "UPDATE plan SET idMesaExamen = NULL";
        $resultado = Conexion::getInstancia()->modificar($consulta);
        if (($resultado[0] == 2) || ($resultado[0] == 1 && $resultado[2] == 0)) {
            
        }
        return $resultado;
    }

    private static function borrarPlanes() {
        Log::guardar("INF", "COLECCION PLANES --> BORRAR PLANES");
        $consulta = "DELETE FROM plan WHERE idMesaExamen IS NULL AND "
                . "id NOT IN (SELECT DISTINCT idPlan FROM clase)";
        $resultado = Conexion::getInstancia()->borrar($consulta);

        return $resultado;
    }

    public static function quitarCarrerasAsignaturas() {
        Log::guardar("INF", "COLECCION PLANES --> QUITAR CARRERAS Y ASIGNATURAS");
        $respla = ColeccionPlanes::borrarPlanes();
        if (($respla[0] == 0) || (($respla[0] == 1 && $respla[2] != 0))) {
            return $respla;
        }
        $rescar = Carreras::borrarCarreras();
        if (($rescar[0] == 2) || ($rescar[0] == 1 && $rescar[2] == 0)) {
            $resasi = Asignaturas::borrarAsignaturas();
            if (($resasi[0] == 2) || ($resasi[0] == 1 && $resasi[2] == 0)) {
                return array(2, "Se quitaron los datos no asociados");
            }
            return $resasi;
        }
        return $rescar;
    }

}
