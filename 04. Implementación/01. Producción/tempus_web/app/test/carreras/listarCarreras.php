<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$carrera = new Carrera();
$carreras = $carrera->listar();

foreach ($carreras as $carrera) {
    echo "<br>" . $carrera["codigo"] . " " . $carrera["nombre"] . "<br>";
}