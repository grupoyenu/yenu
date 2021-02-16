<?php

namespace app\mesa\modelo;

use app\util\modelo\Util;
use DateTime;

/**
 * 
 * @package app\mesa\modelo.
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
class ValidadorMesa {

    public static function validarArchivo() {
        $tamanio = $_FILES['fileMesas']['size'];
        $nombre_temporal = $_FILES['fileMesas']['tmp_name'];
        if ($tamanio > 0) {
            $mesas = fopen($nombre_temporal, "r");
            if ($mesas) {
                $fila = fgetcsv($mesas, 2000, ";");
                $columnas = count($fila);
                return (($columnas < 9) || ($columnas > 10)) ? "El archivo seleccionado tiene una cantidad de columnas inválidas (" . $columnas . " columnas)" : NULL;
            }
            return "El archivo seleccionado no se pudo abrir";
        }
        return "El archivo seleccionado está vacío";
    }

    public static function validarRegistroUnLlamado($registro) {
        $errores = array();
        $errores[0] = ValidadorMesa::validarCodigoCarrera($registro[0]);
        $errores[1] = ValidadorMesa::validarNombreCarrera($registro[1]);
        $errores[2] = ValidadorMesa::validarNombreAsignatura($registro[2]);
        $errores[3] = ValidadorMesa::validarNombreDocenteObligatorio($registro[3]);
        $errores[4] = ValidadorMesa::validarNombreDocenteObligatorio($registro[4]);
        $errores[5] = ValidadorMesa::validarNombreDocenteNoObligatorio($registro[5]);
        $errores[6] = ValidadorMesa::validarNombreDocenteNoObligatorio($registro[6]);
        $errores[7] = ValidadorMesa::validarFormatoFechaObligatoria($registro[7]);
        $errores[8] = ValidadorMesa::validarFormatoHoraObligatoria($registro[8]);
        $errores[9] = ValidadorMesa::estadoRegistro($errores);
        return $errores;
    }

    static function validarRegistroDosLlamados($registro) {
        $errores = array();
        $errores[0] = ValidadorMesa::validarCodigoCarrera($registro[0]);
        $errores[1] = ValidadorMesa::validarNombreCarrera($registro[1]);
        $errores[2] = ValidadorMesa::validarNombreAsignatura($registro[2]);
        $errores[3] = ValidadorMesa::validarNombreDocenteObligatorio($registro[3]);
        $errores[4] = ValidadorMesa::validarNombreDocenteObligatorio($registro[4]);
        $errores[5] = ValidadorMesa::validarNombreDocenteNoObligatorio($registro[5]);
        $errores[6] = ValidadorMesa::validarNombreDocenteNoObligatorio($registro[6]);
        if ($registro[7] || $registro[8]) {
            $errores[7] = ($registro[7]) ? ValidadorMesa::validarFormatoFechaObligatoria($registro[7]) : "Correcta";
            $errores[8] = ($registro[8]) ? ValidadorMesa::validarFormatoFechaObligatoria($registro[8]) : "Correcta";
        } else {
            $errores[7] = "Llamado 1: se debe indicar al menos una fecha para la mesa";
            $errores[8] = "Llamado 2: se debe indicar al menos una fecha para la mesa";
        }
        $errores[9] = ValidadorMesa::validarFormatoHoraObligatoria($registro[9]);
        $errores[10] = ValidadorMesa::estadoRegistro($errores);
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
        if (Util::validarCarreraNombre(utf8_encode($nombre))) {
            return "Correcto";
        }
        return "Nombre de carrera: no cumple el formato [A-Za-z:,. ]{10,60}";
    }

    /**
     * Valida el nombre de una asignatura.
     * @param string $nombre Nombre de la asignatura.
     * @return string Correcto o mensaje con detalle.
     */
    private static function validarNombreAsignatura($nombre) {
        if (Util::validarAsignaturaNombre(utf8_encode($nombre))) {
            return "Correcto";
        }
        return "Nombre de asignatura: No cumple el formato [A-Za-z0-9:,. ]{5,80}'";
    }

    /**
     * Valida el nombre de un docente que ocupa un rol obligatorio.
     * @param string $nombre Nombre del docente.
     * @return string Correcto o mensaje con detalle.
     */
    private static function validarNombreDocenteObligatorio($nombre) {
        if ($nombre) {
            if (Util::validarDocenteNombre(utf8_encode($nombre))) {
                return "Correcto";
            }
            return "Nombre de docente: no cumple el formato [A-Za-z,. ]{4,60}";
        }
        return "Nombre de docente: es un campo obligatorio";
    }

    /**
     * Valida el nombre de un docente que ocupa un rol no obligatorio.
     * @param string $nombre Nombre del docente.
     * @return string Correcto o mensaje con detalle.
     */
    private static function validarNombreDocenteNoObligatorio($nombre) {
        if ($nombre) {
            if (Util::validarDocenteNombre(utf8_encode($nombre))) {
                return "Correcto";
            }
            return "Nombre de docente: no cumple el formato [A-Za-z,. ]{4,60}";
        }
        return "Correcto";
    }

    /**
     * Valida el formato de una fecha de caracter obligatoria.
     * @param string $fecha Fecha del llamado.
     * @return string Correcto o mensaje con detalle.
     */
    private static function validarFormatoFechaObligatoria($fecha) {
        if ($fecha) {
            if (!preg_match("/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/", $fecha)) {
                return "Fecha: no cumple el formato DD/MM/AAAA";
            }
            $date = DateTime::createFromFormat('d/m/Y', $fecha);
            if (($date !== false) && ($date) && ($date->format('d/m/Y') == $fecha)) {
                return "Correcta";
            }
            return "Fecha: no cumple con el formato DD/MM/AAAA";
        }
        return "Fecha: es un campo obligatorio";
    }

    private static function validarFormatoHoraObligatoria($hora) {
        if ($hora && Util::validarLlamadoHora($hora)) {
            return "Correcta";
        }
        return "Hora: no cumple el formato HH:MM'";
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
