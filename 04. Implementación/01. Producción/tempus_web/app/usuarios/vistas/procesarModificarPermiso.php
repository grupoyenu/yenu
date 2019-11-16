<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();

$exito = FALSE;
if (isset($_POST['idPermiso'])) {
    $id = $_POST['idPermiso'];
    $nombre = $_POST['nombre'];
    $controlador = new ControladorPermisos();
    $modificacion = $controlador->modificar($id, $nombre);
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
