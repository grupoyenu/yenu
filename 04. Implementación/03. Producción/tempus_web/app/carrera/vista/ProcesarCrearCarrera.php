<?php

/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\carrera\controlador\ControladorCarrera;
use app\principal\controlador\ControladorHTML;
use app\principal\modelo\AutoCargador;

AutoCargador::cargarModulos();

session_start();

$exito = FALSE;
if (isset($_POST['codigo']) && isset($_POST['nombre'])) {
    /* SE RECIBE LA INFORMACION DESDE EL FORMULARIO  */
    $id = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $controlador = new ControladorCarrera();
    $creacion = $controlador->crear($id, $nombre);
    $codigo = $creacion[0];
    $mensaje = "{$nombre}: {$creacion[1]}";
    $exito = ($codigo == 2) ? TRUE : FALSE;
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion($codigo, $mensaje);
} else {
    /* NO SE RECIBE LA INFORMACION DESDE EL FORMULARIO  */
    $mensaje = "No se obtuvo la información desde el formulario";
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'resultado' => $resultado);
echo json_encode($json);
