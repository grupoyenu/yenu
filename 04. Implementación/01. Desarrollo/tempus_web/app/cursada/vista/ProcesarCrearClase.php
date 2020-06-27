<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
$exito = false;
if (isset($_POST['codigo']) && isset($_POST['idAsignatura']) && isset($_POST['dia']) && isset($_POST['desde']) && isset($_POST['hasta']) && isset($_POST['aula'])) {
    $controlador = new ControladorCursada();
    $codigo = $_POST['codigo'];
    $idAsignatura = $_POST['idAsignatura'];
    $dia = $_POST['dia'];
    $desde = $_POST['desde'];
    $hasta = $_POST['hasta'];
    $aula = $_POST['aula'];
    $clase = new Clase(NULL, $dia, $desde, $hasta, $aula);
    $clases[] = $clase;
    $creacion = $controlador->crear($codigo, $idAsignatura, $clases);
    $mensaje = $controlador->getDescripcion();
    $exito = ($creacion == 2) ? true : false;
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion($creacion, $mensaje);
} else {
    $mensaje = "No se recibió la información desde el formulario";
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'resultado' => $resultado);
echo json_encode($json);
