<?php

namespace app\cursada\controlador;

use app\cursada\modelo\ColeccionClases as Cursadas;
use app\principal\modelo\Conexion;
use app\principal\modelo\Log;

/**
 * 
 * @package app\cursada\controlador
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
class ControladorCursada {

    public function buscarPorCarreraAsignatura($nombreCarrera, $nombreAsignatura) {
        return Cursadas::buscarPorCarreraAsignatura($nombreCarrera, $nombreAsignatura);
    }

    public function importar($cursadas) {
        Log::guardar("INF", "CONTROLADOR CURSADAS --> IMPORTAR " . str_repeat("*", 60));
        if (Conexion::getInstancia()->iniciarTransaccion()) {
            $resultado = Cursadas::importarCursada($cursadas);
            $confirmar = ($resultado[0] == 2) ? TRUE : FALSE;
            Conexion::getInstancia()->finalizarTransaccion($confirmar);
            return $resultado;
        }
        Log::guardar("ERR", "CONTROLADOR CURSADAS --> IMPORTAR NO INICIADA");
        return array(0, "No se pudo inicializar la transacción para operar");
    }

    public function listarResumenCursadas($limite) {
        return Cursadas::listarResumenCursadas($limite);
    }

}
