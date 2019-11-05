<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ValidadorMesa {

    static function validarArchivo() {
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

    static function validarRegistroUnLlamado($registro) {
        $errores = array();
        $errores[0] = ValidadorMesa::validarCodigoCarrera($registro[0]);
        $errores[1] = ValidadorMesa::validarNombreCarrera($registro[1]);
        $errores[2] = ValidadorMesa::validarNombreAsignatura($registro[2]);
        $errores[3] = ValidadorMesa::validarNombreDocenteObligatorio($registro[3]);
        $errores[4] = ValidadorMesa::validarNombreDocenteObligatorio($registro[4]);
        $errores[5] = ValidadorMesa::validarNombreDocenteNoObligatorio($registro[5]);
        $errores[6] = ValidadorMesa::validarNombreDocenteNoObligatorio($registro[6]);
        $errores[7] = ValidadorMesa::validarFormatoFechaObligatoria($registro[7]);
        $errores[8] = ValidadorMesa::validarFormatoHora($registro[8]);
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
        $errores[9] = ValidadorMesa::validarFormatoHora($registro[9]);
        $errores[10] = ValidadorMesa::estadoRegistro($errores);
        return $errores;
    }

    static function validarCodigoCarrera($codigo) {
        return preg_match("/^[0-9]{1,3}$/", $codigo) ? "Correcto" : "Código de carrera: no cumple el formato [0-9]{1,3}";
    }

    static function validarNombreCarrera($nombre) {
        return preg_match("/^[A-Za-zÁÉÍÓÚÑáéíóúñ. ]{10,60}$/", $nombre) ? "Correcto" : "Nombre de carrera: no cumple el formato [A-Za-z. ]{10,60}";
    }

    static function validarNombreAsignatura($nombre) {
        if (!ctype_digit($nombre)) {
            return preg_match("/^[A-Za-zÁÉÍÓÚÑáéíóúñ0-9,. ]{5,60}$/", $nombre) ? "Correcto" : "Nombre de asignatura: No cumple el formato [A-Za-z0-9,. ]{5,60}'";
        }
        return "Nombre de asignatura: Está completamente compuesto de números";
    }

    static function validarNombreDocenteObligatorio($nombre) {
        if ($nombre) {
            return preg_match("/^[A-Za-zÁÉÍÓÚÑáéíóúñ,. ]{4,60}$/", $nombre) ? "Correcto" : "Nombre de docente: no cumple el formato [A-Za-z,. ]{4,60}";
        }
        return "Nombre de docente: es un campo obligatorio";
    }

    static function validarNombreDocenteNoObligatorio($nombre) {
        if ($nombre) {
            return preg_match("/^[A-Za-zÁÉÍÓÚÑáéíóúñ,. ]{4,60}$/", $nombre) ? "Correcto" : "Nombre de docente: no cumple el formato [A-Za-z,. ]{4,60}";
        }
        return "Correcto";
    }

    static function validarFormatoFechaObligatoria($fecha) {
        if ($fecha) {
            if (strlen($fecha) != 10) {
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

    static function validarFormatoHora($hora) {
        if ($hora) {
            return (preg_match("/^(1[0-9]|2[0-3]):[0-5][0-9]$/", $hora)) ? "Correcta" : "Hora: no cumple el formato HH:MM'";
        }
        return "Hora: es un campo obligatorio";
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
