<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

if (isset($_POST['numeroLlamado'])) {
    $nro = $_POST['numeroLlamado'];
    $idLlamado = $_POST['idLlamado' . $nro];
    $fecha = $_POST['fecha' . $nro];
    $hora = $_POST['hora' . $nro];
    $aula = isset($_POST['aula' . $nro]) ? $_POST['aula' . $nro] : NULL;
    $controlador = new ControladorLlamados();
    $modificacion = $controlador->modificar($idLlamado, $fecha, $hora, $aula);
    $mensaje = $controlador->getDescripcion();
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion($modificacion, $mensaje);
} else {
    $mensaje = "No se recibió la información desde el formulario";
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}

echo $resultado;
