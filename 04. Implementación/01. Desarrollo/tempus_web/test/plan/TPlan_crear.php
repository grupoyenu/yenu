<?php

include_once '../../app/principal/modelo/Constantes.php';
include_once '../../app/principal/modelo/AutoCargador.php';

use app\asignatura\modelo\Asignatura as Asignatura;
use app\carrera\modelo\Carrera as Carrera;
use app\principal\modelo\AutoCargador as Cargador;
use app\plan\modelo\Plan as Plan;

Cargador::cargarModulos();

$nombreLargo = "LABORATORIO DE PROGRAMACION";
$asignatura = new Asignatura(NULL, $nombreLargo, $nombreLargo);

$nombre = "Licenciatura en trabajo social";
$carrera = new Carrera('001', $nombre, $nombre);

$cursada = new Plan(NULL, $asignatura, $carrera, NULL, NULL, 1, NULL, 'observacion');
$resultado = $cursada->crear();
echo $resultado[0] . " " . $resultado[1];

