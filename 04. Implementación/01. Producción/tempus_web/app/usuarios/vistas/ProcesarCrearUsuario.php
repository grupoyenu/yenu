<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
$exito = FALSE;
if (isset($_POST['nombre'])) {
    
    $nombre = $_POST['nombre'];
    $correo = $_POST['nombre'];
    $rol = $_POST['nombre'];
    $estado = $_POST['nombre'];
    $metodo = $_POST['nombre'];
    $clave = $_POST['nombre'];
    
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'resultado' => $resultado);
echo json_encode($json);
