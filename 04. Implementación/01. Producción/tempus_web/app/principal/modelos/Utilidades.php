<?php

/**
 * Esta clase contiene metodos de utilidad para diferentes clases. Se puede
 * utilizar para validar cadenas de texto entre otras operaciones.
 * 
 * @author Oyarzo Mariela.
 * @author Quiroga Sandra.
 * @author M�rquez Emanuel.
 * */
class Utilidades {

    static function formatoAnio($anio) {
        if ($anio) {
            return null;
        }
        return "style='background-color: #c50000; color: white;' title='Se debe indicar un año'";
    }

    /**
     * Controla el formato del c�digo de una carrera. El c�digo de carrera
     * tiene una longitud de 1 a 3 digitos. El mismo no puede ser nulo ni
     * vac�o.
     * @var string $codigo Codigo de la carrera.
     * @return string Null si es correcto, mensaje en caso contrario.
     * @author M�rquez Emanuel.
     * */
    static function formatoCodigoCarrera($codigo) {
        if ($codigo) {
            $expresion = "/^[0-9]{1,3}$/";
            return preg_match($expresion, $codigo) ? NULL : "style='background-color: #c50000; color: white;' title='No cumple el formato [0-9]{1,3}'";
        }
        return "style='background-color: #c50000; color: white;' title='Se debe indicar un código de carrera'";
    }

    /**
     * Verifica que una cadena cumpla con el formato de fecha DD/MM/AAAA. Para 
     * ello controla la longitud de la cadena y el formato. Las cadenas vac�as 
     * y nulas no cumplen con el formato.
     * @param string $fecha Cadena con la fecha.
     * @return string Null si es correcta, mensaje en caso contrario.
     * @author M�rquez Emanuel.
     * @see DateTime.
     * */
    static function formatoFechaNoObligatorio($fecha) {
        if ($fecha) {
            if (strlen($fecha) != 10) {
                return "style='background-color: #c50000; color: white;' title='No cumple el formato DD/MM/AAAA'";
            }
            $date = DateTime::createFromFormat('d/m/Y', $fecha);
            if (($date !== false) && ($date) && ($date->format('d/m/Y') == $fecha)) {
                return null;
            }
            return "style='background-color: #c50000; color: white;' title='No cumple con el formato DD/MM/AAAA'";
        }
        return NULL;
    }

    static function formatoFechaObligatorio($fecha) {
        if ($fecha) {
            if (strlen($fecha) != 10) {
                return "style='background-color: #c50000; color: white;' title='No cumple el formato DD/MM/AAAA'";
            }
            $date = DateTime::createFromFormat('d/m/Y', $fecha);
            if (($date !== false) && ($date) && ($date->format('d/m/Y') == $fecha)) {
                return null;
            }
            return "style='background-color: #c50000; color: white;' title='No cumple con el formato DD/MM/AAAA'";
        }
        return "style='background-color: #c50000; color: white;' title='Se debe indicar una fecha'";
    }

    /**
     * Verifica que una cadena cumpla con el formato de hora HH:MM. Para ello
     * controla la longitud de la cadena y el formato. Las cadenas vac�as y 
     * nulas no cumplen con el formato.
     * @param string $hora Cadena con la hora.
     * @return string Devuelve un mensaje indicando un error o null si es correcto.
     * @author M�rquez Emanuel.
     * @see ereg().
     * */
    static function formatoHora($hora) {
        if ($hora) {
            $expresion = "/^(1[0-9]|2[0-3]):[0-5][0-9]$/";
            return (preg_match($expresion, $hora)) ? NULL : "style='background-color: #c50000; color: white;' title='No cumple el formato HH:MM'";
        }
        return "style='background-color: #c50000; color: white;' title='Se debe indicar un horario'";
    }

    static function formatoNombreAula($nombre) {
        if ($nombre) {
            $expresion = "/^[A-Za-zÁÉÍÓÚÑáéíóúñ0123456789 ]{1,40}$/";
            return (preg_match($expresion, $nombre)) ? NULL : "style='background-color: #c50000; color: white;' title='No cumple el formato [A-Za-z ]{1,40}'";
        }
        return "style='background-color: #c50000; color: white;' title='Se debe indicar un nombre de aula'";
    }

    /**
     * Controla el formato del nombre de una asignatura. El nombre de asignatura
     * tiene un rango de 5 a 255 car�cteres. Ademas, puede contener espacio en
     * blanco, letras con y sin acento, y n�meros.
     * @param string $nombre Nombre de la asignatura.
     * @return string Null si es correcto, mensaje en caso contrario.
     * @author M�rquez Emanuel.
     * */
    static function formatoNombreAsignatura($nombre) {
        if ($nombre) {
            if (!ctype_digit($nombre)) {
                $expresion = "/^[A-Za-zÁÉÍÓÚÑáéíóúñ0123456789,. ]{5,255}$/";
                return preg_match($expresion, $nombre) ? NULL : "style='background-color: #c50000; color: white;' title='No cumple el formato [A-Za-z0-9,. ]{5,255}'";
            }
            return "style='background-color: #c50000; color: white;' title='El nombre de asignatura está completamente compuesto de números'";
        }
        return "style='background-color: #c50000; color: white;' title='Se debe indicar un nombre de asignatura'";
    }

    /**
     * Controla el formato del nombre de una carrera. El nombre de carrera
     * tiene un rango de 10 a 255 car�cteres. Ademas, puede contener espacio en
     * blanco y letras con y sin acento.
     * @param string $nombre Nombre de la carrera.
     * @return string Null si es correcto, mensaje en caso contrario.
     * @author M�rquez Emanuel.
     * */
    static function formatoNombreCarrera($nombre) {
        if ($nombre) {
            $expresion = "/^[A-Za-zÁÉÍÓÚÑáéíóúñ. ]{10,255}$/";
            return preg_match($expresion, $nombre) ? NULL : "style='background-color: #c50000; color: white;' title='No cumple el formato [A-Za-z. ]{10,255}'";
        }
        return "style='background-color: #c50000; color: white;' title='Se debe indicar un nombre de carrera'";
    }

    /**
     * Controla el formato del nombre de un docente. El nombre de docente puede
     * contener letras, espacios, acentos, puntos y comas. La longitud minima de
     * cadena es de 3 caracteres y la maxima de 255.
     * @param string $nombre Nombre del docente.
     * @return string Null si es correcto, mensaje en caso contrario.
     * @author M�rquez Emanuel.
     * */
    static function formatoNombreDocenteObligatorio($nombre) {
        if ($nombre) {
            $expresion = "/^[A-Za-zÁÉÍÓÚÑáéíóúñ,. ]{4,255}$/";
            return preg_match($expresion, $nombre) ? NULL : "style='background-color: #c50000; color: white;' title='No cumple el formato [A-Za-z,. ]{4,255}'";
        }
        return "style='background-color: #c50000; color: white;' title='Se debe indicar un nombre de docente'";
    }

    static function formatoNombreDocenteNoObligatorio($nombre) {
        if ($nombre) {
            $expresion = "/^[A-Za-zÁÉÍÓÚÑáéíóúñ,. ]{4,255}$/";
            return preg_match($expresion, $nombre) ? NULL : "style='background-color: #c50000; color: white;' title='No cumple el formato [A-Za-z,. ]{4,255}'";
        }
        return NULL;
    }

    static function formatoNombreSector($sector) {
        if ($sector) {
            $expresion = "/^[A-Za-z]$/";
            return (preg_match($expresion, $sector)) ? NULL : "style='background-color: #c50000; color: white;' title='No cumple el formato [A-Za-z]'";
        }
        return "style='background-color: #c50000; color: white;' title='Se debe indicar un nombre de sector'";
    }

    /**
     * Valida la repeticion de docentes dentro del tribunal.
     * @param string $presidente Nombre del presidente.
     * @param string $vocal1 Nombre del vocal 1.
     * @param string $vocal2 Nombre del vocal 2.
     * @param string $suplente Nombre del suplente.
     * @return string NULL si es correcto, mensaje en caso contrario.
     * */
    static function validarTribunal($presidente, $vocal1, $vocal2, $suplente) {
        $mensaje = ($presidente == $vocal1) ? "style='background-color: #c50000; color: white;' title='El docente que es presidente tambien es vocal primero'" : NULL;
        if ($vocal2 && !$mensaje) {
            $mensaje = ($presidente == $vocal2) ? "style='background-color: #c50000; color: white;' title='El docente que es presidente tambien es vocal segundo'" : $mensaje;
            $mensaje = ($vocal1 == $vocal2) ? "style='background-color: #c50000; color: white;' title='El docente que es vocal primero tambien es vocal segundo'" : $mensaje;
            if ($suplente && !$mensaje) {
                $mensaje = ($presidente == $suplente) ? "style='background-color: #c50000; color: white;' title='El docente que es presidente tambien es suplente'" : $mensaje;
                $mensaje = ($vocal1 == $suplente) ? "style='background-color: #c50000; color: white;' title='El docente que es vocal primero tambien es suplente'" : $mensaje;
                $mensaje = ($vocal2 == $suplente) ? "style='background-color: #c50000; color: white;' title='El docente que es vocal segundo tambien es suplente'" : $mensaje;
            }
        }
        return $mensaje;
    }

    /**
     * Controla que en un arreglo no haya mesas de examen duplicadas. Se busca
     * dentro del arreglo que no se repita el par Asignatura-Carrera.
     * @param array $mesas Recibe el arreglo de mesas.
     * @param string $asignatura Recibe el nombre de la asignatura.
     * @param string $carrera Recibe el codigo de la carrera.
     * @return string NULL si no hay duplicadas, mensaje en caso contrario.
     * */
    static function mesasDuplicadas($mesas, $asignatura, $carrera) {
        $posicion = 0;
        $tamanio = count($mesas);
        while ($posicion < $tamanio) {
            $mesa = $mesas[$posicion];
            if (in_array($asignatura, $mesa) && in_array($carrera, $mesa)) {
                return "style='background-color: #c50000; color: white;' title='La mesa de examen ya se encuentra cargada'";
            }
            ++$posicion;
        }
        return NULL;
    }

    /**
     * Controla que en un arreglo no haya cursadas duplicadas. Se controla que
     * no exista una cursada para la misma asignatura en la misma carrera. Para
     * ello, se busca primero el nombre de la asignatura, si existe se busca la
     * carrera para ver coincidencias.
     * @param Cursada[] $cursadas Recibe el arreglo de cursadas.
     * @param string $asignatura Recibe el nombre de la asignatura.
     * @param integer $codigo Recibe el codigo de la carrera.
     * @return string Null si no hay duplicadas, mensaje en caso contrario.
     * @author M�rquez Emanuel.
     * */
    static function cursadasDuplicadas($cursadas, $asignatura, $codigo) {
        $mensaje = null;
        $posicion = 0;
        $encontrado = false;
        $tamanio = count($cursadas);
        while (($posicion < $tamanio) && !$encontrado) {
            $cursada = $cursadas[$posicion];
            if ($cursada->getPlan()->getAsignatura()->getNombre() == $asignatura) {
                if ($cursada->getPlan()->getCarrera()->getCodigo() == $codigo) {
                    $mensaje = "La cursada ya se encuentra cargada";
                    $encontrado = true;
                }
            }
            ++$posicion;
        }
        return $mensaje;
    }

    /**
     * Realiza la conversion de una cadena de texto a formato Camel Case.
     * @param string $texto Cadena de texto en cualquier formato.
     * @return string Devuelve la cadena en formato Camel Case. 
     * */
    static function convertirCamelCase($texto) {
        if ($texto) {
            /* Convierta la cadena completa a minuscula */
            $texto = strtolower($texto);
            /* Coloca cada letra inicial de palabra en mayuscula */
            $texto = ucwords($texto);
        }
        return $texto;
    }

    /**
     * Devuelve el nombre de un dia a partir del numero de la semana donde
     * 0 es lunes y 6 es sabado.
     * @param integer $dia Recibe el dia 0, 1, 2, 3, 4, 5 o 6.
     * @return string Nombre del dia.
     * */
    static function nombreDeDia($dia) {
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
                return "Sabado";
        }
        return "";
    }

    static function validarArchivoCursadas() {
        if (isset($_FILES['fileCursadas'])) {
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
        return "No se recibió el archivo de cursadas";
    }

    static function validarArchivoMesas() {
        if (isset($_FILES['fileMesas'])) {
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
        return "No se recibió el archivo de mesas de examen";
    }

}
