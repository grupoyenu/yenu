<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
$exito = FALSE;
if (isset($_POST['carrera']) && isset($_POST['asignatura']) && isset($_POST['cbClases'])) {
    $controlador = new ControladorCursada();
    $idAsignatura = $_POST['asignatura'];
    $idCarrera = $_POST['carrera'];
    $clases = array();
    foreach ($_POST['cbClases'] as $dia) {
        $horaInicio = $_POST['horaInicio' . $dia];
        $horaFin = $_POST['horaFin' . $dia];
        $aula = $_POST['aula' . $dia];
        $clase = new Clase(NULL, $dia, $horaInicio, $horaFin, $aula);
        $clases[] = $clase;
    }
    $creacion = $controlador->crear($idCarrera, $idAsignatura, $clases);
    $mensaje = $controlador->getDescripcion();
    $exito = ($creacion == 2) ? TRUE : FALSE;
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion($creacion, $mensaje);
} else {

    $mensaje = "No se obtuvo la información desde el formulario";
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'resultado' => $resultado);
echo json_encode($json);
