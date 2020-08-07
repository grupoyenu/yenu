<?php

namespace app\cursada\modelo;

use app\asignatura\modelo\Asignatura;
use app\aula\modelo\Aula;
use app\carrera\modelo\Carrera;
use app\cursada\modelo\Clase;
use app\plan\modelo\Plan;
use app\plan\modelo\ColeccionPlanes as Planes;
use app\principal\modelo\Conexion;
use app\principal\modelo\Log;

/**
 *
 * @package app\cursada\ColeccionClases.
 *  
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
class ColeccionClases {

    /**
     * Borrar todas los registros de clases. Luego de eliminar todas las clases 
     * se reinicia el auto incrementador de la clave primaria.
     * @uses Clases::reiniciarAutoIncrementador Reinicia auto incrementador a 1.
     */
    private static function borrarClases() {
        Log::guardar("INF", "COLECCION CLASES --> BORRAR");
        $consulta = "DELETE FROM clase";
        $resultado = Conexion::getInstancia()->borrar($consulta);
        if (($resultado[0] == 2) || ($resultado[0] == 1 && $resultado[2] == 0)) {
            return ColeccionClases::reiniciarAutoIncrementador();
        }
        return $resultado;
    }

    /**
     * Buscar clases a partir del nombre de una carrera y nombre de una
     * asignatura.
     * @see vw_cursada Vista de cursadas.
     * @param string $nombreCarrera Nombre de la carrera o parte del nombre (LIKE).
     * @param string $nombreAsignatura Nombre de la asignatura o parte del nombre (LIKE).
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public static function buscarPorCarreraAsignatura($nombreCarrera, $nombreAsignatura) {
        $consulta = "SELECT * FROM vw_cursada "
                . "WHERE nombreLargoCarrera LIKE '%{$nombreCarrera}%' AND "
                . "nombreLargoAsignatura LIKE '%{$nombreAsignatura}%'";
        return Conexion::getInstancia()->seleccionar($consulta);
    }

    public static function importarCursada($cursadas) {
        Log::guardar("INF", "COLECCION CLASES --> IMPORTAR CURSADA");
        $resultado = ColeccionClases::borrarClases();
        if ($resultado[0] == 2) {
            $errores = ColeccionClases::importar($cursadas);
            $totalErrores = count($errores);
            $totalCursadas = count($cursadas);
            if ($totalErrores == $totalCursadas) {
                return array(1, "No se crearon horarios de cursada ({$totalErrores} errores sobre {$totalCursadas} cursadas)");
            }
            $limpiar = Planes::quitarCarrerasAsignaturas();
            return ($limpiar[0] == 2) ? array(2, $errores) : array(1, "No se crearon horarios de cursada");
        }
        return $resultado;
    }

    private static function importar($cursadas) {
        Log::guardar("INF", "COLECCION CLASES --> IMPORTAR");
        $errores = array();
        $contador = 1;
        foreach ($cursadas as $datos) {
            $numeroRegistro = str_pad($contador, 6, "0", STR_PAD_LEFT);
            Log::guardar("INF", "{$numeroRegistro} " . str_repeat("-", 45));
            $carrera = new Carrera($datos[0], $datos[1], $datos[1]);
            $asignatura = new Asignatura(NULL, $datos[2], $datos[2]);
            $cursada = new Cursada();
            $posicion = 4;
            $diaSemana = 1;
            while ($posicion < 28) {
                if ($datos[$posicion]) {
                    $aula = new Aula(NULL, $datos[$posicion + 3], $datos[$posicion + 2]);
                    $clase = new Clase(NULL, $aula, NULL, $diaSemana, $datos[$posicion], $datos[$posicion + 1]);
                    $cursada->agregarClase($clase);
                }
                $posicion = $posicion + 4;
                $diaSemana++;
            }
            $plan = new Plan(NULL, $asignatura, $carrera, $cursada, NULL, $datos[3]);
            $resultadoPlan = $plan->crear();
            $resultadoCursada = $plan->crearCursada();
            if (($resultadoPlan[0] != 2) || ($resultadoCursada[0] != 2)) {
                $tipo = ($resultadoCursada[0] == 0) ? "ERR" : "WAR";
                $mensaje = implode(",", $datos);
                Log::guardar($tipo, "{$numeroRegistro} {$resultadoPlan[0]} {$resultadoCursada[1]} ({$mensaje})");
                $errores [] = $datos;
            }
            $contador++;
        }
        return $errores;
    }

    public function buscarParaInforme($carrera, $asignatura, $dia, $modificada, $opDesde, $desde, $opHasta, $hasta) {
        $consulta = "SELECT * FROM vista_cursadas WHERE "
                . "nombreLargoCarrera LIKE '%{$carrera}%' AND "
                . "nombreLargoAsignatura LIKE '%{$asignatura}%' AND";
        $consulta .= ($dia != "NO") ? "horaInicio{$dia} IS NOT NULL AND " : "";
        $consulta .= ($desde != "NO") ? "(desde1 {$opDesde} '{$desde}' OR desde2 {$opDesde} '{$desde}' OR desde3 {$opDesde} '{$desde}' OR desde4 {$opDesde} '{$desde}' OR desde5 {$opDesde} '{$desde}' OR desde6 {$opDesde} '{$desde}') AND " : "";
        $consulta .= ($hasta != "NO") ? "(hasta1 {$opHasta} '{$hasta}' OR hasta2 {$opHasta} '{$hasta}' OR hasta3 {$opHasta} '{$hasta}' OR hasta4 {$opHasta} '{$hasta}' OR hasta5 {$opHasta} '{$hasta}' OR hasta6 {$opHasta} '{$hasta}') AND " : "";
        $consulta .= ($modificada == "SI") ?
                "(fechaEdicionLunes IS NOT NULL OR fechaEdicionMartes IS NOT NULL OR fechaEdicionMiercoles IS NOT NULL OR fechaEdicionJueves IS NOT NULL OR fechaEdicionViernes IS NOT NULL OR fechaEdicionSabado IS NOT NULL)" :
                "(fechaEdicionLunes IS NULL AND fechaEdicionMartes IS NULL AND fechaEdicionMiercoles IS NULL AND fechaEdicionJueves IS NULL AND fechaEdicionViernes IS NULL AND fechaEdicionSabado IS NULL)";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

    /**
     * @see vw_informe Consulta cuando modulo es CURSADAS.
     */
    public static function listarInformesCursada(): array {
        $consulta = "SELECT * FROM vw_informe WHERE modulo = 'CURSADAS'";
        return Conexion::getInstancia()->seleccionar($consulta);
    }

    /**
     * Realiza la busqueda de las ultimos horarios de cursada que se han creado.
     * El objetivo es brindar resultados previos cuando se hace la busqueda de 
     * mesas de examen.
     * @param int $limite Cantidad maxima de mesas de examen.
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public static function listarResumenCursadas($limite) {
        if ($limite > 0) {
            $consulta = "SELECT * FROM vw_cursada ORDER BY idPlan LIMIT {$limite}";
            return Conexion::getInstancia()->seleccionar($consulta);
        }
        return array(0, "No se estableció un limite valido");
    }

    public static function listarClasesAula($idAula) {
        if ($idAula > 0) {
            $consulta = "SELECT car.id idCarrera, car.nombreCorto nombreCortoCarrera, "
                    . "car.nombreLargo nombreLargoCarrera, asi.nombreCorto nombreCortoAsignatura, "
                    . "asi.nombreLargo nombreLargoAsignatura, cla.diaSemana, "
                    . "cla.horaInicio, cla.horaFin, cla.fechaEdicion "
                    . "FROM clase cla INNER JOIN plan pla on pla.id = cla.idPlan "
                    . "INNER JOIN carrera car on car.id = pla.idCarrera "
                    . "INNER JOIN asignatura asi on asi.id = pla.idAsignatura "
                    . "WHERE idAula = {$idAula} ORDER BY diaSemana, horaInicio, horaFin";
            return Conexion::getInstancia()->seleccionar($consulta);
        }
        return array(0, "No se pudo hacer referencia al aula");
    }

    /**
     * Reiniciar el auto incrementador de la clave primaria.
     */
    private function reiniciarAutoIncrementador() {
        Log::guardar("INF", "COLECCION CLASES --> REINICIAR AUTOINCREMENTADOR");
        $consulta = "ALTER TABLE clase AUTO_INCREMENT = 1";
        return Conexion::getInstancia()->modificar($consulta);
    }

}
