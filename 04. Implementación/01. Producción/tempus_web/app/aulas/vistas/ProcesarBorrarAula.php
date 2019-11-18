<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

if (isset($_POST['modalIdAula'])) {
    $idAula = $_POST['modalIdAula'];
    $controlador = new ControladorAula();
    $eliminacion = $controlador->borrar($idAula);
    $mensaje = $controlador->getDescripcion();
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion($eliminacion, $mensaje);
} else {
    $mensaje = "No se recibió la información desde el formulario";
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}

echo $resultado;
