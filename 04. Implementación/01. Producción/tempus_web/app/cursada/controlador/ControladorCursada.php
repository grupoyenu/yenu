<?php

namespace app\cursada\controlador;

use app\cursada\modelo\ColeccionClases as Cursadas;
use app\principal\modelo\Conexion;
use app\principal\modelo\Log;

/**
 *  Controlador de Cursada. Esta clase se comunica con los modelos del modulo
 * de cursadas para invocar sus metodos y otorgar los resultados a las vistas 
 * que correspondan. Ademas, se encarga de almacenar las actividades que se llevan
 * a cabo en el Log cuando se realiza una operacion que implica actualizar 
 * informacion en la base de datos.
 * 
 * @package app\cursada\controlador
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 * 
 * @version 1.0
 * 
 */
class ControladorCursada {

    public function buscarPorCarreraAsignatura($nombreCarrera, $nombreAsignatura) {
        return Cursadas::buscarPorCarreraAsignatura($nombreCarrera, $nombreAsignatura);
    }

    /**
     * 
     * @see Conexion::getInstancia->iniciarTransaccion
     * @see Conexion::getInstancia->finalizarTransaccion
     * @see Cursadas::importarCursada
     * @see Log::guardar
     */
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

    /**
     * @see Cursadas::listarResumenCursadas
     */
    public function listarResumenCursadas($limite) {
        return Cursadas::listarResumenCursadas($limite);
    }

}
