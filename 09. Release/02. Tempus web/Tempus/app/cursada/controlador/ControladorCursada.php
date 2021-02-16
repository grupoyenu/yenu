<?php

namespace app\cursada\controlador;

use app\cursada\modelo\Cursada;
use app\cursada\modelo\ColeccionClases as Cursadas;
use app\principal\modelo\Conexion;
use app\principal\modelo\Log;

/**
 * Controlador de Cursada. Esta clase se comunica con los modelos del modulo
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
class ControladorCursada
{

    public function borrar(Cursada $cursada)
    {
        Log::guardar("INF", "CONTROLADOR CURSADAS --> BORRAR " . str_repeat("*", 60));
        if (Conexion::getInstancia()->iniciarTransaccion()) {
            $resultado = $cursada->borrar();
            $confirmar = ($resultado[0] == 2) ? TRUE : FALSE;
            Conexion::getInstancia()->finalizarTransaccion($confirmar);
            return $resultado;
        }
        Log::guardar("ERR", "CONTROLADOR CURSADAS --> BORRAR NO INICIADA");
        return array(0, "No se pudo inicializar la transacción para operar");
    }

    /**
     * Realiza la busqueda de horarios de cursada a partir del nombre de carrera
     * y nombre de asignatura.
     * @see Cursadas::buscarPorCarreraAsignatura
     * @param string $nombreCarrera Nombre o parte del nombre de la carrera.
     * @param string $nombreAsignatura Nombre o parte del nombre de la asignatura.
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public function buscarPorCarreraAsignatura($nombreCarrera, $nombreAsignatura)
    {
        return Cursadas::buscarPorCarreraAsignatura($nombreCarrera, $nombreAsignatura);
    }

    public function buscarParaInforme($carrera, $asignatura, $dia, $modificada, $opDesde, $desde, $opHasta, $hasta)
    {
        return Cursadas::buscarParaInforme($carrera, $asignatura, $dia, $modificada, $opDesde, $desde, $opHasta, $hasta);
    }

    /**
     * Realiza la carga masica de horarios de cursada a partir de la informacion
     * obtenida del archivo ingresado.
     * @see Conexion::getInstancia->iniciarTransaccion
     * @see Conexion::getInstancia->finalizarTransaccion
     * @see Cursadas::importarCursada
     * @see Log::guardar
     * @param array Horarios de cursada.
     * @return array Arreglo de dos posiciones (codigo, mensaje).
     */
    public function importar($cursadas)
    {
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


    public function listarInformesCursada()
    {
        return Cursadas::listarInformesCursada();
    }

    /**
     * Realiza la busqueda de un conjunto limitado de horarios de cursada.
     * @see Cursadas::listarResumenCursadas
     * @param int $limite Limite maximo de registros a seleccionar.
     * @return array Arreglo de dos posiciones (codigo, mensaje).
     */
    public function listarResumenCursadas($limite)
    {
        return Cursadas::listarResumenCursadas($limite);
    }
}
