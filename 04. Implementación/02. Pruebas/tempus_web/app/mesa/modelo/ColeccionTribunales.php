<?php

namespace app\mesa\modelo;

use app\principal\modelo\Conexion;
use app\principal\modelo\Log;
use app\docente\modelo\ColeccionDocentes as Docentes;

/**
 * 
 * paquete: mesas.
 * namespace: modelos.
 */
class ColeccionTribunales {

    /**
     * @uses element Description
     */
    public static function borrarTribunales() {
        Log::guardar("INF", "COLECCION TRIBUNALES --> BORRAR TRIBUNALES");
        $consulta = "DELETE FROM tribunal";
        $resultado = Conexion::getInstancia()->borrar($consulta);
        if (($resultado[0] == 2) || ($resultado[0] == 1 && $resultado[2] == 0)) {
            $alter = ColeccionTribunales::reiniciarAutoIncrementador();
            return ($alter[0] == 2) ? Docentes::borrarDocentes() : $alter;
        }
        return $resultado;
    }

    public static function borrarTribunalesSinMesaExamen() {
        $consulta = "DELETE TRI FROM tribunal TRI JOIN (SELECT idtribunal FROM tribunal "
                . "WHERE idtribunal NOT IN (SELECT DISTINCT idtribunal FROM mesa_examen)) "
                . "CAN ON CAN.idtribunal = TRI.idtribunal";
        return Conexion::getInstancia()->borrar($consulta);
    }

    private static function reiniciarAutoIncrementador() {
        Log::guardar("INF", "COLECCION TRIBUNALES --> REINICIAR AUTOINCREMENTADOR");
        $consulta = "ALTER TABLE tribunal AUTO_INCREMENT = 1";
        $resultado = Conexion::getInstancia()->modificar($consulta);
        return $resultado;
    }

}
