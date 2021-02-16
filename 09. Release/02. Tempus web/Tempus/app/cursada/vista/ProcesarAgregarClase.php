<?php

/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\aula\modelo\Aula;
use app\cursada\modelo\Cursada;
use app\cursada\modelo\Clase;
use app\plan\controlador\ControladorPlan;
use app\plan\modelo\Plan;
use app\principal\controlador\ControladorHTML;
use app\principal\modelo\AutoCargador;

AutoCargador::cargarModulos();

/* INICIALIZA LA SESION PARA GUARDAR EL LOG */
session_start();

$exito = FALSE;
if (isset($_POST['plan']) && isset($_POST['cbClases'])) {
    $idPlan = $_POST['plan'];
    $plan = new Plan($idPlan);
    $datos = $plan->obtenerPorIdentificador();
    if ($datos[0] == 2) {
        $cursada = new Cursada();
        $agregada = TRUE;
        foreach ($_POST['cbClases'] as $dia) {
            $horaInicio = $_POST['horaInicio' . $dia];
            $horaFin = $_POST['horaFin' . $dia];
            $idAula = $_POST['aula' . $dia];
            $aula = new Aula($idAula);
            $clase = new Clase(NULL, $aula, $idPlan, $dia, $horaInicio, $horaFin);
            $cargada = $cursada->agregarClase($clase);
            $agregada = ($cargada) ? $agregada : FALSE;
        }
        if ($agregada) {
            $controlador = new ControladorPlan();
            $asignatura = $plan->getAsignatura();
            $creacion = $controlador->crearCursada($plan, $cursada);
            $codigo = $creacion[0];
            $mensaje = ($codigo == 2) ? "{$asignatura->getNombreLargo()}: Se agregaron clases correctamente" : "{$asignatura->getNombreLargo()}: {$creacion[1]}";
            $exito = ($codigo == 2) ? TRUE : FALSE;
            $resultado = ControladorHTML::mostrarAlertaResultadoOperacion($codigo, $mensaje);
        } else {
            $codigo = 1;
            $mensaje = "Una o más clases no se pudieron agregar a la cursada";
            $resultado = ControladorHTML::mostrarAlertaResultadoOperacion($codigo, $mensaje);
        }
    } else {
        $codigo = $datos[0];
        $mensaje = $datos[1];
        $resultado = ControladorHTML::mostrarAlertaResultadoOperacion($codigo, $mensaje);
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'resultado' => $resultado);
echo json_encode($json);
