<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
$exito = FALSE;
if (isset($_POST['nombre'])) {
    $controlador = new ControladorUsuarios();
    $nombre = $_POST['nombre'];
    $email = $_POST['correo'];
    $rol = $_POST['rol'];
    $estado = $_POST['estado'];
    $metodo = $_POST['metodo'];
    $clave = isset($_POST['clave']) ? $_POST['clave'] : "";
    $creacion = $controlador->crear($nombre, $email, $rol, $estado, $metodo, $clave);
    $mensaje = $controlador->getDescripcion();
    $exito = ($creacion == 2) ? true : false;
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion($creacion, $mensaje);
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'resultado' => $resultado);
echo json_encode($json);
