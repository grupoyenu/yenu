<?php

/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\aula\controlador\ControladorAula;
use app\principal\controlador\ControladorHTML;
use app\principal\modelo\AutoCargador;

AutoCargador::cargarModulos();

$exito = false;
if (isset($_POST['sector'])) {
    /* SE RECIBE LA INFORMACION DESDE EL FORMULARIO  */
    $sector = $_POST['sector'];
    $nombre = $_POST['nombre'];
    $controlador = new ControladorAula();
    $creacion = $controlador->crear($sector, $nombre);
    $codigo = $creacion[0];
    $mensaje = "{$sector} - {$nombre}: {$creacion[1]}";
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
