<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

if (isset($_POST['idLlamado'])) {
    $nro = $_POST['numeroLlamado'];
    $idLlamado = $_POST['idLlamado' . $nro];
    $fecha = $_POST['fecha' . $nro];
    $hora = $_POST['hora' . $nro];
    $aula = $_POST['aula' . $nro];
    $controlador = new ControladorLlamados();
    $modificacion = $controlador->modificar($id, $fecha, $hora, $aula);
    $mensaje = $controlador->getDescripcion();
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion($modificacion, $mensaje);
} else {
    $mensaje = "No se recibió la información desde el formulario";
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}

echo $resultado;
