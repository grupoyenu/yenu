<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

if (isset($_POST['idLlamado'])) {
    $idLlamado = $_POST['idLlamado'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $aula = $_POST['aula'];
    $controlador = new ControladorLlamados();
    $modificacion = $controlador->modificar($id, $fecha, $hora, $aula);
    $mensaje = $controlador->getDescripcion();
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion($modificacion, $mensaje);
} else {
    $mensaje = "No se recibió la información desde el formulario";
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}

echo $resultado;