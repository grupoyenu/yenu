<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$carrera = new Carrera();
$carrera->setCodigo(16);
$carrera->obtenerAsignaturas();
if ($carrera->getAsignaturas() != 1) {
    $asignaturas = $carrera->getAsignaturas();
    foreach ($asignaturas as $asignatura) {
        echo '<br>' . $asignatura["anio"] . " " . $asignatura["nombre"];
    }
}