<?php

namespace app\util\modelo;

/**
 * Esta clase contiene metodos de utilidad para diferentes clases. Se puede
 * utilizar para validar cadenas de texto entre otras operaciones.
 * 
 * @author Oyarzo Mariela.
 * @author Quiroga Sandra.
 * @author Marquez Emanuel.
 *  */
class Util {

    /**
     * Realiza la conversion de una cadena de texto a formato Camel Case.
     * @param string $texto Cadena de texto en cualquier formato.
     * @return string Devuelve la cadena en formato Camel Case. 
     * @see mb_strtolower
     * @see ucwords
     * */
    public static function convertirCamelCase($texto) {
        if ($texto) {
            $minuscula = mb_strtolower($texto);
            $texto = ucwords($minuscula);
        }
        return $texto;
    }

    public static function obtenerIniciales($cadena) {
        $acronimo = '';
        foreach (explode(' ', trim($cadena)) as $palabra) {
            $acronimo .= (!isset($palabra[0])) ?: strtoupper($palabra[0]);
        }
        return $acronimo;
    }

    public static function obtenerNombreDia($dia) {
        switch ($dia) {
            case 1:
                return "Lunes";
            case 2:
                return "Martes";
            case 3:
                return "Miercoles";
            case 4:
                return "Jueves";
            case 5:
                return "Viernes";
            case 6:
                return "Sábado";
            case 7:
                return "Domingo";
            default:
                return NULL;
        }
    }

    public static function validarAnio($anio) {
        return (preg_match("/^[1-5]$/", $anio)) ? true : false;
    }

    /**
     * Validar el formato para el nombre de una asignatura.
     * @see preg_match
     * @see mb_strtolower
     * @param string $nombre Nombre a validar.
     * @return boolean True cuando cumple el formato y false en caso contrario.
     */
    public static function validarAsignaturaNombre($nombre) {
        if (!ctype_digit($nombre)) {
            $expresion = "/^[a-záéíóúñü0-9:,. ]{5,80}$/";
            return preg_match($expresion, mb_strtolower($nombre)) ? true : false;
        }
        return false;
    }

    /**
     * Validar el formato para el nombre de un aula.
     * @see preg_match
     * @see mb_strtolower
     * @param string $nombre Nombre del aula a validar.
     * @return boolean True cuando cumple el formato y false en caso contrario.
     */
    public static function validarAulaNombre($nombre) {
        $expresion = "/^[a-záéíóúñü0-9 ]{1,40}$/";
        return preg_match($expresion, mb_strtolower($nombre)) ? true : false;
    }

    /**
     * Validar el formato para el nombre del sector de un aula.
     * @see preg_match
     * @see mb_strtolower
     * @param string $sector Nombre del sector a validar.
     * @return boolean True cuando cumple el formato y false en caso contrario.
     */
    public static function validarAulaSector($sector) {
        $expresion = "/^[a-zñ]$/";
        return preg_match($expresion, mb_strtolower($sector)) ? true : false;
    }

    /**
     * Validar el formato para el codigo de una carrera.
     * @see preg_match
     * @param integer $codigo Numero de codigo a validar.
     * @return boolean True cuando cumple el formato y false en caso contrario.
     */
    public static function validarCarreraCodigo($codigo) {
        $expresion = "/^[0-9]{1,3}$/";
        return preg_match($expresion, $codigo) ? true : false;
    }

    /**
     * Validar el formato para el nombre de una carrera.
     * @see preg_match
     * @see mb_strtolower
     * @param integer $nombre Nombre de carrera a validar.
     * @return boolean True cuando cumple el formato y false en caso contrario.
     */
    public static function validarCarreraNombre($nombre) {
        $expresion = "/^[a-záéíóúñü:,. ]{10,160}$/";
        return preg_match($expresion, mb_strtolower($nombre)) ? true : false;
    }

    public static function validarClaseDia($dia) {
        return (($dia > 0) && ($dia < 7)) ? true : false;
    }

    public static function validarClaseHora($hora) {
        $expresion = "/^(0[6-9]|1[0-9]|2[0-4]):[0-5][0-9]$/";
        return preg_match($expresion, $hora) ? true : false;
    }

    /**
     * Validar el formato para el nombre de un docente.
     * @see preg_match
     * @see mb_strtolower
     * @param integer $nombre Nombre de docente a validar.
     * @return boolean True cuando cumple el formato y false en caso contrario.
     */
    public static function validarDocenteNombre($nombre) {
        $expresion = "/^[a-záéíóúñü,. ]{4,60}$/";
        return preg_match($expresion, mb_strtolower($nombre)) ? true : false;
    }

    public static function validarLlamadoHora($hora) {
        $expresion = "/^(0[6-9]|1[0-9]|2[0-3]):[0-5][0-9]$/";
        return (preg_match($expresion, $hora)) ? true : false;
    }

}
