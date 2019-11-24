<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
$exito = FALSE;
if (isset($_POST['nombre']) && isset($_POST['permisos'])) {
    $nombre = $_POST['nombre'];
    $permisos = $_POST['permisos'];
    $controlador = new ControladorRoles();
    $creacion = $controlador->crear($nombre, $permisos);
    $exito = ($creacion == 2) ? true : false;
    $mensaje = $controlador->getDescripcion();
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion($creacion, $mensaje);
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'resultado' => $resultado);
echo json_encode($json);

