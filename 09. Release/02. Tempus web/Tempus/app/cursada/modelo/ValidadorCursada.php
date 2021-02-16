<?php

namespace app\cursada\modelo;

use app\util\modelo\Util;

/**
 * 
 * @package app\cursada\modelo.
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
class ValidadorCursada {

    public static function validarArchivo(): array {
        $tamanio = $_FILES['fileCursadas']['size'];
        $nombre_temporal = $_FILES['fileCursadas']['tmp_name'];
        if ($tamanio > 0) {
            $cursadas = fopen($nombre_temporal, "r");
            if (!$cursadas) {
                return array(0, "El archivo seleccionado no se pudo abrir");
            }
            $fila = fgetcsv($cursadas, 2000, ";");
            $columnas = count($fila);
            if ($columnas != 28) {
                return array(1, "El archivo seleccionado tiene una cantidad de columnas inválidas ({$columnas} columnas)");
            }
            return array(2, "Archivo disponible para procesar");
        }
        return array(1, "El archivo seleccionado está vacío");
    }

    public static function validarRegistro($registro) {
        $errores = array();
        $errores[0] = ValidadorCursada::validarCodigoCarrera($registro[0]);
        $errores[1] = ValidadorCursada::validarNombreCarrera(utf8_encode($registro[1]));
        $errores[2] = ValidadorCursada::validarNombreAsignatura(utf8_encode($registro[2]));
        $errores[3] = ValidadorCursada::validarAnio($registro[3]);
        $errores[4] = ValidadorCursada::validarClase($registro[4], $registro[5], $registro[6], $registro[7]);
        $errores[5] = ValidadorCursada::validarClase($registro[8], $registro[9], $registro[10], $registro[11]);
        $errores[6] = ValidadorCursada::validarClase($registro[12], $registro[13], $registro[14], $registro[15]);
        $errores[7] = ValidadorCursada::validarClase($registro[16], $registro[17], $registro[18], $registro[19]);
        $errores[8] = ValidadorCursada::validarClase($registro[20], $registro[21], $registro[22], $registro[23]);
        $errores[9] = ValidadorCursada::validarClase($registro[24], $registro[25], $registro[26], $registro[27]);
        $errores[10] = ValidadorCursada::estadoRegistro($errores);
        return $errores;
    }

    /**
     * Valida el codigo de una carrera.
     * @param string $codigo Codigo de la carrera.
     * @return string Correcto o mensaje con detalle.
     */
    private static function validarCodigoCarrera($codigo) {
        if (Util::validarCarreraCodigo($codigo)) {
            return "Correcto";
        }
        return "Código de carrera: no cumple el formato [0-9]{1,3}";
    }

    /**
     * Valida el nombre de una carrera.
     * @param string $nombre Nombre de la carrera.
     * @return string Correcto o mensaje con detalle.
     */
    private static function validarNombreCarrera($nombre) {
        if (Util::validarCarreraNombre($nombre)) {
            return "Correcto";
        }
        return "Nombre de carrera: no cumple el formato [A-Za-z. ]{10,60}";
    }

    /**
     * Valida el nombre de una asignatura.
     * @param string $nombre Nombre de la asignatura.
     * @return string Correcto o mensaje con detalle.
     */
    private static function validarNombreAsignatura($nombre) {
        if (Util::validarAsignaturaNombre($nombre)) {
            return "Correcto";
        }
        return "Nombre de asignatura: No cumple el formato [A-Za-z0-9,. ]{5,60}'";
    }

    private static function validarAnio($anio) {
        if (Util::validarAnio($anio)) {
            return "Correcto";
        }
        return "Año: Debe ser entre 1 y 5";
    }

    private static function validarClase($horaInicio, $horaFin, $sector, $aula) {
        if ($horaFin || $horaInicio || $sector || $aula) {
            if (!Util::validarClaseHora($horaInicio)) {
                return "Hora de inicio: no cumple con el formato HH:MM";
            }
            if (!Util::validarClaseHora($horaFin)) {
                return "Hora de inicio: no cumple con el formato HH:MM";
            }
            if (!Util::validarAulaSector($sector)) {
                return "Nombre de sector: no cumple con el formato [A-Za-z]{1}";
            }
            if (!Util::validarAulaNombre($aula)) {
                return "Nombre de aula: no cumple con el formato [A-Za-z0-9 ]{1, 40}";
            }
        }
        return "Correcto";
    }

    private static function estadoRegistro($errores) {
        foreach ($errores as $columna) {
            if (($columna != "Correcta") && ($columna != "Correcto")) {
                return false;
            }
        }
        return true;
    }

}
