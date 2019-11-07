<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$asignaturas = array();

$asignaturas[] = "Materia 1";
$asignaturas[] = "Analisis";
$asignaturas[] = "Materia 2";
$asignaturas[] = "Materia 2";

foreach ($asignaturas as $asignatura) {
    $materia = new Asignatura(NULL, $asignatura);
    $creacion = $materia->crear();
    if ($creacion == 2) {
        echo "<br>" . $materia->getDescripcion() . " " . $materia->getIdAsignatura();
    } else {
        echo "<br>" . $materia->getDescripcion() . " " . $creacion;
    }
}
