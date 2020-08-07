<?php

namespace app\plan\controlador;

use app\plan\modelo\Plan;
use app\cursada\modelo\Cursada;
use app\mesa\modelo\MesaExamen;
use app\plan\modelo\ColeccionPlanes as Planes;
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
class ControladorPlan {

    public function borrarCursada(Plan $plan) {
        Log::guardar("INF", "CONTROLADOR PLAN --> BORRAR CURSADA ***");
        if (Conexion::getInstancia()->iniciarTransaccion()) {
            $cursada = new Cursada($plan->getId());
            $resultado = $cursada->borrarCursada();
            $confirmar = ($resultado[0] == 2) ? TRUE : FALSE;
            $mensaje = ($resultado[0] == 2) ? "CURSADA ELIMINADA" : "CURSADA NO ELIMINADA";
            Conexion::getInstancia()->finalizarTransaccion($confirmar);
            Log::guardar("INF", "CONTROLADOR PLAN --> {$mensaje}");
            return $resultado;
        }
        Log::guardar("ERR", "CONTROLADOR PLAN --> ELIMINACION DE CURSADA ***");
        return array(0, "No se pudo inicializar la transacción para operar");
    }

    /**
     * Borrar mesa de examen y actualizar plan.
     */
    public function borrarMesaExamen(Plan $plan, MesaExamen $mesaExamen) {
        Log::guardar("INF", "CONTROLADOR PLAN --> BORRAR MESA DE EXAMEN ***");
        if (Conexion::getInstancia()->iniciarTransaccion()) {
            $plan->setMesa($mesaExamen);
            $resultado = $plan->quitarMesaExamen();
            $confirmar = ($resultado[0] == 2) ? TRUE : FALSE;
            $mensaje = ($resultado[0] == 2) ? "MESA ELIMINADA" : "MESA NO ELIMINADA";
            Conexion::getInstancia()->finalizarTransaccion($confirmar);
            Log::guardar("INF", "CONTROLADOR PLAN --> {$mensaje}");
            return $resultado;
        }
        Log::guardar("ERR", "CONTROLADOR PLAN --> ELIMINACION DE MESA NO INICIADA ***");
        return array(0, "No se pudo inicializar la transacción para operar");
    }

    public function buscarPlanSinCursada($nombreAsignatura) {
        return Planes::buscarPlanSinCursada($nombreAsignatura);
    }

    public function buscarPlanSinMesaExamen($nombreAsignatura) {
        return Planes::buscarPlanSinMesaExamen($nombreAsignatura);
    }

    /**
     * Crear nuevo plan.
     */
    public function crear($asignatura, $carrera, $cursada, $mesa, $anio) {
        Log::guardar("INF", "CONTROLADOR PLAN --> CREAR ***");
        if (Conexion::getInstancia()->iniciarTransaccion()) {
            $plan = new Plan(NULL, $asignatura, $carrera, $cursada, $mesa, $anio);
            $resultado = $plan->crear();
            $confirmar = ($resultado[0] == 2) ? TRUE : FALSE;
            $mensaje = ($resultado[0] == 2) ? "CREADO" : "NO CREADO";
            Conexion::getInstancia()->finalizarTransaccion($confirmar);
            Log::guardar("INF", "CONTROLADOR PLAN --> {$mensaje}");
            return $resultado;
        }
        Log::guardar("ERR", "CONTROLADOR PLAN --> CREACION NO INICIADA ***");
        return array(0, "No se pudo inicializar la transacción para operar");
    }

    /**
     * Crear cursada y asociarla al plan.
     */
    public function crearCursada(Plan $plan, Cursada $cursada) {
        Log::guardar("INF", "CONTROLADOR PLAN --> CREAR CURSADA ***");
        if (Conexion::getInstancia()->iniciarTransaccion()) {
            $plan->setCursada($cursada);
            $resultado = $plan->crearCursada();
            $confirmar = ($resultado[0] == 2) ? TRUE : FALSE;
            $mensaje = ($resultado[0] == 2) ? "CREADA" : "NO CREADA";
            Conexion::getInstancia()->finalizarTransaccion($confirmar);
            Log::guardar("INF", "CONTROLADOR PLAN --> {$mensaje}");
            return $resultado;
        }
        Log::guardar("ERR", "CONTROLADOR PLAN --> CREACION CURSADA NO INICIADA ***");
        return array(0, "No se pudo inicializar la transacción para operar");
    }

    /**
     * Crear mesa de examen y asociarla al plan.
     */
    public function crearMesaExamen(Plan $plan, MesaExamen $mesaExamen) {
        Log::guardar("INF", "CONTROLADOR PLAN --> *** CREAR MESA DE EXAMEN ***");
        if (Conexion::getInstancia()->iniciarTransaccion()) {
            $plan->setMesa($mesaExamen);
            $resultado = $plan->asociarMesaExamen();
            $confirmar = ($resultado[0] == 2) ? TRUE : FALSE;
            Conexion::getInstancia()->finalizarTransaccion($confirmar);
            Log::guardar("INF", "CONTROLADOR PLAN --> CONFIRMA CREACION " . (int) $confirmar);
            return $resultado;
        }
        Log::guardar("ERR", "CONTROLADOR PLAN --> CREACION NO INICIADA");
        return array(0, "No se pudo inicializar la transacción para operar");
    }

    public function modificarCursada(Plan $plan, Cursada $cursada) {
        Log::guardar("INF", "CONTROLADOR PLAN --> MODIFICAR CURSADA ***");
        if (Conexion::getInstancia()->iniciarTransaccion()) {
            $cursada->setPlan($plan->getId());
            $resultado = $cursada->modificar();
            $confirmar = ($resultado[0] == 2) ? TRUE : FALSE;
            $mensaje = ($resultado[0] == 2) ? "MODIFICADA" : "NO MODIFICADA";
            Conexion::getInstancia()->finalizarTransaccion($confirmar);
            Log::guardar("INF", "CONTROLADOR PLAN --> {$mensaje}");
            return $resultado;
        }
        Log::guardar("ERR", "CONTROLADOR PLAN --> MODIFICACION CURSADA NO INICIADA ***");
        return array(0, "No se pudo inicializar la transacción para operar");
    }

}
