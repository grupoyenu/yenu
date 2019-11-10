<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();

$exito = FALSE;
if (isset($_POST['idAula'])) {
    $id = $_POST['idAula'];
    $sector = $_POST['sector'];
    $nombre = $_POST['nombre'];
    $controlador = new ControladorAula();
    $modificacion = $controlador->modificar($id, $sector, $nombre);
    $mensaje = $controlador->getDescripcion();
    $exito = ($modificacion == 2) ? TRUE : FALSE;
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion($modificacion, $mensaje);
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'resultado' => $resultado);
echo json_encode($json);
