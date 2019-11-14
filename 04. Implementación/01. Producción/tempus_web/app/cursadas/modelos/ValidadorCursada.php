<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ValidadorCursada {

    static function validarArchivo() {
        $tamanio = $_FILES['fileCursadas']['size'];
        $nombre_temporal = $_FILES['fileCursadas']['tmp_name'];
        if ($tamanio > 0) {
            $cursadas = fopen($nombre_temporal, "r");
            if ($cursadas) {
                $fila = fgetcsv($cursadas, 2000, ";");
                $columnas = count($fila);
                return ($columnas != 28) ? "El archivo seleccionado tiene una cantidad de columnas inválidas (" . $columnas . " columnas)" : NULL;
            }
            return "El archivo seleccionado no se pudo abrir";
        }
        return "El archivo seleccionado está vacío";
    }

    static function validarRegistro($registro) {
        $errores = array();
        $errores[0] = ValidadorCursada::validarCodigoCarrera($registro[0]);
        $errores[1] = ValidadorCursada::validarNombreCarrera(utf8_encode($registro[1]));
        $errores[2] = ValidadorCursada::validarNombreAsignatura(utf8_encode($registro[2]));
        $errores[3] = ValidadorCursada::validarAnio($registro[3]);
        $errores[4] = ValidadorCursada::validarClase($registro[4], $registro[5], $registro[6], utf8_encode($registro[7]));
        $errores[5] = ValidadorCursada::validarClase($registro[8], $registro[9], $registro[10], utf8_encode($registro[11]));
        $errores[6] = ValidadorCursada::validarClase($registro[12], $registro[13], $registro[14], utf8_encode($registro[15]));
        $errores[7] = ValidadorCursada::validarClase($registro[16], $registro[17], $registro[18], utf8_encode($registro[19]));
        $errores[8] = ValidadorCursada::validarClase($registro[20], $registro[21], $registro[22], utf8_encode($registro[23]));
        $errores[9] = ValidadorCursada::validarClase($registro[24], $registro[25], $registro[26], utf8_encode($registro[27]));
        $errores[10] = ValidadorCursada::estadoRegistro($errores);
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
            return preg_match("/^[A-Za-zÁÉÍÓÚÑüáéíóúñ0-9,. ]{5,60}$/", $nombre) ? "Correcto" : "Nombre de asignatura: No cumple el formato [A-Za-z0-9,. ]{5,60}'";
        }
        return "Nombre de asignatura: Está completamente compuesto de números";
    }

    static function validarAnio($anio) {
        return preg_match("/^[1-5]$/", $anio) ? "Correcto" : "Año: Debe ser entre 1 y 5";
    }

    static function validarClase($horaInicio, $horaFin, $sector, $aula) {
        if ($horaFin || $horaInicio || $sector || $aula) {
            if (!preg_match("/^(1[0-9]|2[0-3]):[0-5][0-9]$/", $horaInicio)) {
                return "Hora de inicio: no cumple con el formato HH:MM";
            }
            if (!preg_match("/^(1[0-9]|2[0-3]):[0-5][0-9]$/", $horaFin)) {
                return "Hora de inicio: no cumple con el formato HH:MM";
            }
            if (!preg_match("/^[A-Za-z]$/", $sector)) {
                return "Nombre de sector: no cumple con el formato [A-Za-z]{1}";
            }
            if (!preg_match("/^[A-Za-zÁÉÍÓÚÑáéíóúñ0-9 ]{1,40}$/", $aula)) {
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
