<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$exito = false;
if (isset($_POST['idClase']) && isset($_POST['desde']) && isset($_POST['hasta']) && isset($_POST['aula'])) {
    $controlador = new ControladorCursada();
    $idClase = $_POST['idClase'];
    $desde = $_POST['desde'];
    $hasta = $_POST['hasta'];
    $aula = $_POST['aula'];
    $modificacion = $controlador->modificarClase($idClase, $desde, $hasta, $aula);
    $mensaje = $controlador->getDescripcion();
    $exito = ($modificacion == 2) ? true : false;
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion($modificacion, $mensaje);
} else {
    $mensaje = "No se recibió la información desde el formulario";
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'resultado' => $resultado);
echo json_encode($json);


