<?php

include_once '../../app/principal/modelo/Constantes.php';
include_once '../../app/principal/modelo/AutoCargador.php';

use app\principal\modelo\AutoCargador as Cargador;
use app\asignatura\modelo\Asignatura as Asignatura;

Cargador::cargarModulos();

$asignatura = new Asignatura(3);
$resultado = $asignatura->obtenerPorIdentificador();

echo "<br>RESULTADO {$resultado[0]} : {$resultado[1]}";
if ($resultado[0] == 2) {
    echo "<br> DATOS: " . $asignatura->getId() . " " . $asignatura->getNombreCorto() . " " . $asignatura->getNombreLargo();
}