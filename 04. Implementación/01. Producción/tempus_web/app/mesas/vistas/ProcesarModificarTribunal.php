<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

if (isset($_POST['idTribunal'])) {

    $idTribunal = $_POST['idTribunal'];
    $presidente = $_POST['presidente'];
    $vocal1 = $_POST['vocal1'];
    $vocal2 = $_POST['vocal2'];
    $suplente = $_POST['suplente'];
    $controlador = new ControladorTribunal();
    $modificacion = $controlador->modificar($id, $presidente, $vocal1, $vocal2, $suplente);
    $mensaje = $controlador->getDescripcion();
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion($modificacion, $mensaje);
    
} else {
    $mensaje = "No se recibió la información desde el formulario";
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}

echo $resultado;
