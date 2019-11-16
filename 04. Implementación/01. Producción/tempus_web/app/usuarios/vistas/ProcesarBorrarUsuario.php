<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

if (isset($_POST['modalIdUsuario']) && isset($_POST['modalMetodo'])) {
    $idUsuario = $_POST['modalIdUsuario'];
    $metodo = $_POST['modalMetodo'];
    $controlador = new ControladorUsuarios();
    $eliminacion = $controlador->borrar($idUsuario, $metodo);
    $mensaje = $controlador->getDescripcion();
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion($eliminacion, $mensaje);
} else {
    $mensaje = "No se recibió la información desde el formulario";
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}

echo $resultado;
