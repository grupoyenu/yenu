<?php

namespace app\mesa\controlador;

use app\mesa\modelo\MesaExamen;
use app\mesa\modelo\ColeccionLlamados as Llamados;
use app\mesa\modelo\ColeccionMesasExamen as Mesas;
use app\principal\modelo\Conexion;
use app\principal\modelo\Log;

/**
 * Controlador de Mesa. Esta clase se comunica con los modelos del modulo
 * de mesas de examen para invocar sus metodos y otorgar los resultados a las vistas 
 * que correspondan. Ademas, se encarga de almacenar las actividades que se llevan
 * a cabo en el Log cuando se realiza una operacion que implica actualizar 
 * informacion en la base de datos.
 * 
 * @package app\plan\controlador
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 * 
 * @version 1.0
 * 
 */
class ControladorMesa {

    /**
     * Realiza la busqueda de mesas de examen para presentar en el informe.
     * @see Mesas::buscarParaInforme
     * @param string $nombreCarrera Nombre de la carrera.
     * @param string $nombreAsignatura Nombre de la asignatura.
     * @param string $fecha Fecha de las mesas de examen.
     * @param string $hora Hora de las mesas de examen.
     * @param string $nombreDocente Nombre del docente.
     * @param string $modificada Si la mesa de examen fue modificada o no.
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public function buscarParaInforme($nombreCarrera, $nombreAsignatura, $fecha, $hora, $nombreDocente, $modificada) {
        return Mesas::buscarParaInforme($nombreCarrera, $nombreAsignatura, $fecha, $hora, $nombreDocente, $modificada);
    }

    /**
     * Realiza la busqueda de mesas de examen a partir del nombre de la carrera
     * y nombre de la asignatura.
     * @see Mesas::buscarPorCarreraAsignatura
     * @param string $nombreCarrera Nombre o parte del nombre de la carrera.
     * @param string $nombreAsignatura Nombre o parte del nombre de la asignatura.
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public function buscarPorCarreraAsignatura($nombreCarrera, $nombreAsignatura) {
        return Mesas::buscarPorCarreraAsignatura($nombreCarrera, $nombreAsignatura);
    }

    /**
     * Realiza la carga de mesas de examen a partir del archivo ingresado.
     * @see Conexion::getInstancia()->iniciarTransaccion
     * @see Conexion::getInstancia()->finalizarTransaccion
     * @see Log::guardar
     * @see Mesas::importarMesasExamen
     * @param array $mesasExamen Arreglo con las mesas de examen.
     * @param int $numeroLlamados Cantidad de llamados para el turno de examen.
     * @return array Arrglo de dos posiciones (codigo, mensaje).
     */
    public function importar($mesasExamen, $numeroLlamados) {
        Log::guardar("INF", "CONTROLADOR MESA DE EXAMEN --> IMPORTAR " . str_repeat("*", 60));
        if (Conexion::getInstancia()->iniciarTransaccion()) {
            $resultado = Mesas::importarMesasExamen($mesasExamen, $numeroLlamados);
            $confirmar = ($resultado[0] == 2) ? TRUE : FALSE;
            Conexion::getInstancia()->finalizarTransaccion($confirmar);
            return $resultado;
        }
        Log::guardar("ERR", "CONTROLADOR MESA DE EXAMEN --> IMPORTAR NO INICIADA");
        return array(0, "No se pudo inicializar la transacción para operar");
    }

    /**
     * Realiza la busqueda de todas las fechas de examen.
     * @see Llamados::listarFechasExamen
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public function listarFechasExamen() {
        return Llamados::listarFechasExamen();
    }

    /**
     * Lista informes del modulo de mesas de examen.
     * @see  Mesas::listarInformesMesaExamen
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public function listarInformesMesaExamen() {
        return Mesas::listarInformesMesaExamen();
    }

    /**
     * Realiza la busqueda limitada de mesas de examen.
     * @see Mesas::listarResumenMesasExamen
     * @param int $limite Limite maximo de mesas de examen.
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public function listarResumenMesasExamen($limite) {
        return Mesas::listarResumenMesasExamen($limite);
    }

    /**
     * Realiza la modificacion de una determinada mesa de examen.
     * @see Conexion::getInstancia()->iniciarTransaccion
     * @see Conexion::getInstancia()->finalizarTransaccion
     * @see Log::guardar
     * @see Mesa::modificar
     * @param MesaExamen $mesa Mesa de examen a modificar.
     * @return array Arreglo de dos posiciones (codigo, mensaje).
     */
    public function modificar(MesaExamen $mesa) {
        Log::guardar("INF", "CONTROLADOR MESA DE EXAMEN --> MODIFICAR ***");
        if (Conexion::getInstancia()->iniciarTransaccion()) {
            $resultado = $mesa->modificar();
            $confirmar = ($resultado[0] == 2) ? TRUE : FALSE;
            $mensaje = ($resultado[0] == 2) ? "EDITADA" : "NO EDITADA";
            Conexion::getInstancia()->finalizarTransaccion($confirmar);
            Log::guardar("INF", "CONTROLADOR MESA DE EXAMEN --> {$mensaje}");
            return $resultado;
        }
        Log::guardar("ERR", "CONTROLADOR MESA DE EXAMEN --> MODIFICACION NO INICIADA");
        return array(0, "No se pudo inicializar la transacción para operar");
    }

    /**
     * Obtiene la cantidad de llamados que se encuentran cargados para el turno
     * de examen.
     * @see Llamados::obtenerNumeroDeLlamados
     * @return array Arreglo de dos posiciones (codigo, mensaje).
     */
    public function obtenerNumeroDeLlamados() {
        return Llamados::obtenerNumeroDeLlamados();
    }

}
