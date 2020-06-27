<?php

namespace app\docente\modelo;

use app\principal\modelo\Conexion;
use app\principal\modelo\Log;

/**
 * 
 * @package app\docente\modelo.
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
class ColeccionDocentes {

    public static function borrarDocentes() {
        Log::guardar("INF", "COLECCION DOCENTES --> BORRAR DOCENTES");
        $consulta = "DELETE FROM docente";
        $resultado = Conexion::getInstancia()->borrar($consulta);
        if (($resultado[0] == 2) || ($resultado[0] == 1 && $resultado[2] == 0)) {
            return ColeccionDocentes::reiniciarAutoIncrementador();
        }
        return $resultado;
    }

    /**
     * Seleccionar docente por su nombre.
     * @param string $nombreDocente Nombre del docente o parte del nombre.
     * @return array Arreglo de dos posiciones (codigo, mensaje).
     */
    public static function seleccionar($nombreDocente) {
        $consulta = "SELECT * FROM docente "
                . "WHERE nombre LIKE '%{$nombreDocente}%' ORDER BY nombre";

        return Conexion::getInstancia()->seleccionar($consulta);
    }

    private static function reiniciarAutoIncrementador() {
        Log::guardar("INF", "COLECCION DOCENTES --> REINICIAR AUTOINCREMENTADOR");
        $consulta = "ALTER TABLE docente AUTO_INCREMENT = 1";
        $resultado = Conexion::getInstancia()->modificar($consulta);
        ;
        return $resultado;
    }

}
