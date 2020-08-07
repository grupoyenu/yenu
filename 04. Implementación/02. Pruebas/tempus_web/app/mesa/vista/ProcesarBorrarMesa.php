<?php

/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\plan\modelo\Plan;
use app\plan\controlador\ControladorPlan;
use app\principal\controlador\ControladorHTML;
use app\principal\modelo\AutoCargador;

AutoCargador::cargarModulos();

/* INICIALIZA LA SESION PARA GUARDAR LOG */

session_start();

if (isset($_POST['modalIdPlan'])) {
    $idPlan = $_POST['modalIdPlan'];
    $plan = new Plan($idPlan);
    $obtenerPlan = $plan->obtenerPorIdentificador();
    if ($obtenerPlan[0] == 2) {
        $obtenerMesa = $plan->obtenerMesaExamen();
        if ($obtenerMesa[0] == 2) {
            $asignatura = $plan->getAsignatura();
            $mesaExamen = $plan->getMesa();
            $controlador = new ControladorPlan();
            $eliminacion = $controlador->borrarMesaExamen($plan, $mesaExamen);
            $codigo = $eliminacion[0];
            $mensaje = "{$asignatura->getNombreLargo()}: {$eliminacion[1]}";
            $exito = ($codigo == 2) ? TRUE : FALSE;
            $resultado = ControladorHTML::mostrarAlertaResultadoOperacion($codigo, $mensaje);
        } else {
            $codigo = $obtenerMesa[0];
            $mensaje = $obtenerMesa[1];
            $resultado = ControladorHTML::mostrarAlertaResultadoOperacion($codigo, $mensaje);
        }
    } else {
        $codigo = $obtenerPlan[0];
        $mensaje = $obtenerPlan[1];
        $resultado = ControladorHTML::mostrarAlertaResultadoOperacion($codigo, $mensaje);
    }
} else {
    $mensaje = "No se recibió la información desde el formulario";
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}

echo $resultado;
