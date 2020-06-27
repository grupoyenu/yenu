<?php

/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\plan\controlador\ControladorPlan;
use app\plan\modelo\Plan;
use app\principal\controlador\ControladorHTML;
use app\principal\modelo\AutoCargador;

AutoCargador::cargarModulos();

/* INICIALIZA LA SESION PARA GUARDAR EL LOG */
session_start();

if (isset($_POST['modalIdPlan'])) {
    $idPlan = $_POST['modalIdPlan'];
    $plan = new Plan($idPlan);
    $datos = $plan->obtenerPorIdentificador();
    if ($datos[0] == 2) {
        $controlador = new ControladorPlan();
        $asignatura = $plan->getAsignatura();
        $eliminacion = $controlador->borrarCursada($plan);
        $codigo = $eliminacion[0];
        $mensaje = "{$asignatura->getNombreLargo()}: {$eliminacion[1]}";
        $resultado = ControladorHTML::mostrarAlertaResultadoOperacion($codigo, $mensaje);
    } else {
        $codigo = $datos[0];
        $mensaje = $datos[1];
        $resultado = ControladorHTML::mostrarAlertaResultadoOperacion($codigo, $mensaje);
    }
} else {
    $mensaje = "No se recibió la información desde el formulario";
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}

echo $resultado;
