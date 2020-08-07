<?php

namespace app\mesa\modelo;

use app\principal\modelo\Conexion;
use app\principal\modelo\Log;

/**
 * 
 * paquete: mesas.
 * namespace: modelos.
 */
class ColeccionLlamados {

    public static function borrarLlamados() {
        Log::guardar("INF", "COLECCION LLAMADOS --> BORRAR LLAMADOS");
        $consulta = "DELETE FROM llamado";
        $resultado = Conexion::getInstancia()->borrar($consulta);
        if (($resultado[0] == 2) || ($resultado[0] == 1 && $resultado[2] == 0)) {
            return ColeccionLlamados::reiniciarAutoIncrementador();
        }
        return $resultado;
    }

    /**
     * Elimina de la base de datos a los llamados que no pertenecen a ninguna 
     * mesa de examen. El objetivo es quitar todos los llamados sin mesa asociada
     * cuando se realiza de la eliminacion de una mesa, dado que un llamado puede
     * estar asociado a mas de una mesa. Al quitar una mesa, solo se quita el 
     * llamado si no esta asociado a otra.
     * @return integer 0 cuando falla la operacion, 2 correcta.
     */
    public static function borrarLlamadosSinMesaExamen() {
        $consulta = "DELETE LLA FROM llamado LLA JOIN (SELECT idllamado FROM llamado "
                . "WHERE idllamado NOT IN (SELECT DISTINCT primero idllamado FROM mesa_examen "
                . "WHERE primero IS NOT NULL UNION SELECT DISTINCT segundo idllamado "
                . "FROM mesa_examen WHERE segundo IS NOT NULL)) CAN ON CAN.idllamado = LLA.idllamado";
        return Conexion::getInstancia()->borrar($consulta);
    }

    /**
     * Obtiene la cantidad de llamados que tiene el turno de mesa de examen. El
     * objetivo es conocer cuantos llamados tiene el turno que se cargo al importar
     * el archivo de mesas. Cuando existe al menos una mesa con dos llamados, se
     * devuelve 2. En caso contrario, se retorna 1.
     * @return integer 0 cuando falla la operacion, 1 o 2.
     */
    public static function obtenerNumeroDeLlamados() {
        $consulta = "SELECT COUNT(idSegundoLlamado) cantidad FROM mesa_examen WHERE idSegundoLlamado IS NOT NULL";
        $resultado = Conexion::getInstancia()->obtener($consulta);
        if (gettype($resultado[0]) == "array") {
            $fila = $resultado[0];
            return ($fila['cantidad'] > 0) ? 2 : 1;
        }
        return -1;
    }

    /**
     * Obtiene las distintas fechas de examen que se cargaron. El objetivo es 
     * listar todas las fechas de examen para mostrar en el momento de generar el
     * informe de mesas.
     * @return integer 0 cuando falla la consulta, 1 sin resultados o 2 correcta.
     */
    public static function listarFechasExamen() {
        $consulta = "SELECT DISTINCT fecha FROM llamado ORDER BY fecha";
        return Conexion::getInstancia()->seleccionar($consulta);
    }

    private static function reiniciarAutoIncrementador() {
        Log::guardar("INF", "COLECCION LLAMADOS --> REINICIAR AUTOINCREMENTADOR");
        $consulta = "ALTER TABLE llamado AUTO_INCREMENT = 1";
        $resultado = Conexion::getInstancia()->modificar($consulta);
        return $resultado;
    }

}
