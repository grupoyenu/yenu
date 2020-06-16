<?php

namespace app\mesa\controlador;

use app\mesa\modelo\MesaExamen;
use app\mesa\modelo\ColeccionLlamados as Llamados;
use app\mesa\modelo\ColeccionMesasExamen as Mesas;
use app\principal\modelo\Conexion;
use app\principal\modelo\Log;

/**
 * 
 * @package app\plan\controlador
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
class ControladorMesa {

    public function buscarParaInforme($carrera, $asignatura, $fecha, $hora, $docente, $modificada) {
        return Mesas::buscarParaInforme($carrera, $asignatura, $fecha, $hora, $docente, $modificada);
    }

    public function buscarPorCarreraAsignatura($nombreCarrera, $nombreAsignatura) {
        return Mesas::buscarPorCarreraAsignatura($nombreCarrera, $nombreAsignatura);
    }

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

    public function listarFechasExamen() {
        return Llamados::listarFechasExamen();
    }

    public function listarInformesMesaExamen() {
        return Mesas::listarInformesMesaExamen();
    }

    public function listarResumenMesasExamen($limite) {
        return Mesas::listarResumenMesasExamen($limite);
    }

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

    public function obtenerNumeroDeLlamados() {
        return Llamados::obtenerNumeroDeLlamados();
    }

}
