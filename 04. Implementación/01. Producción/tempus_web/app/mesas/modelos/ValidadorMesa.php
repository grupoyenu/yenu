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
                return ($columnas != 28) ? "El archivo seleccionado tiene una cantidad de columnas inválidas (" . $columnas . " columnas)" : NULL;
            }
            return "El archivo seleccionado no se pudo abrir";
        }
        return "El archivo seleccionado está vacío";
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

}
