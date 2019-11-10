<?php

/* AUTOLOAD PARA INCLUIR LOS ARCHIVO NECESARIOS */

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$exito = false;
if (isset($_POST['sector'])) {
    /* SE RECIBE LA INFORMACION DESDE EL FORMULARIO  */
    $sector = $_POST['sector'];
    $nombre = $_POST['nombre'];
    $controladorAula = new ControladorAula();
    $creacion = $controladorAula->crear($sector, $nombre);
    $exito = ($creacion == 2) ? true : false;
    $mensaje = $controladorAula->getDescripcion();
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion($creacion, $mensaje);
} else {
    /* NO SE RECIBE LA INFORMACION DESDE EL FORMULARIO  */
    $mensaje = "No se obtuvo la información desde el formulario";
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'resultado' => $resultado);
echo json_encode($json);
