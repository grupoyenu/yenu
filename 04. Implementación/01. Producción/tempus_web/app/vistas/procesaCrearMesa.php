<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../controladores/Autoload.php';
$autoload = new Autoload();
$autoload->autoloadProcesa();

$codigoCarrera = $_POST['codigoCarrera'];
$idAsignatura = $_POST['idAsignatura'];
$idPresidente = $_POST['idPresidente'];
$idVocal1 = $_POST['idVocal1'];
$fechaPrimero = $_POST['primerLlamado'];
$hora = $_POST['selectHora'];
$idAula = $_POST['idAula'];

$exito = false;

if ($codigoCarrera && $idAsignatura) {

    if ($idPresidente && $idVocal1) {
        
        $idVocal2 = $_POST['idVocal2'];
        $idSuplente = $_POST['idSuplente'];
        $nombreCarrera = $_POST['nombreCarrera'];
        $nombreAsignatura = $_POST['nombreAsignatura'];

        $asignatura = new Asignatura();
        $carrera = new Carrera();
        $plan = new Plan();
        $tribunal = new Tribunal();
        $presidente = new Docente();
        $vocal1 = new Docente();
        $vocal2 = null;
        $suplente = null;



        $mensaje = $codigoCarrera . "/" . $idAsignatura . "/" . $idPresidente . "/" . $idVocal1 . "/" . $idVocal2 . "/" . $idSuplente;
        $mensaje = $mensaje . "/" . $fechaPrimero . "/" . $hora . "/" . $idAula;

        $div = '<div class="alert alert-danger text-center" role="alert">' . $mensaje . '</div>';
    } else {
        $mensaje = "No se obtuvieron los datos del tribunal necesarios para la creación de la mesa";
        $div = '<div class="alert alert-danger text-center" role="alert">' . $mensaje . '</div>';
    }
} else {
    $mensaje = "No se obtuvieron los datos del plan necesarios para la creación de la mesa";
    $div = '<div class="alert alert-danger text-center" role="alert">' . $mensaje . '</div>';
}

$json[] = array('exito' => $exito, 'div' => $div);
echo json_encode($json);
