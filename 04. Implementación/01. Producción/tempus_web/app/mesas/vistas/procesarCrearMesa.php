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
if (isset($_POST['cantidadLlamados'])) {
    $controlador = new ControladorMesa();
    $nroLlamados = $_POST['cantidadLlamados'];
    $carrera = $_POST['carrera'];
    $asignatura = $_POST['asignatura'];
    $presidente = $_POST['presidente'];
    $vocal1 = $_POST['vocal1'];
    $vocal2 = isset($_POST['vocal2']) ? $_POST['vocal2'] : NULL;
    $suplente = isset($_POST['suplente']) ? $_POST['suplente'] : NULL;
    $fecha1 = $_POST['fecha1'];
    $hora1 = $_POST['hora1'];
    $aula1 = isset($_POST['aula1']) ? $_POST['aula1'] : NULL;
    $tribunal = new Tribunal(NULL, $presidente, $vocal1, $vocal2, $suplente);
    $primero = new Llamado(NULL, $fecha1, $hora1, $aula1);
    $segundo = NULL;
    if ($nroLlamados == 2) {
        $fecha2 = $_POST['fecha2'];
        $hora2 = $_POST['hora2'];
        $aula2 = isset($_POST['aula2']) ? $_POST['aula2'] : NULL;
        $segundo = new Llamado(NULL, $fecha2, $hora2, $aula2);
    }
    $creacion = $controlador->crear($carrera, $asignatura, $tribunal, $primero, $segundo);
    $exito = ($creacion == 2) ? true : false;
    $mensaje = $controlador->getDescripcion();
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion($creacion, $mensaje);
} else {
    /* NO SE RECIBE LA INFORMACION DESDE EL FORMULARIO  */
    $mensaje = "No se obtuvo la información desde el formulario";
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'resultado' => $resultado);
echo json_encode($json);
