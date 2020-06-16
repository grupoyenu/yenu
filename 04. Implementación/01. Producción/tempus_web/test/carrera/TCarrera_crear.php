<?php

include_once '../../app/principal/modelo/Constantes.php';
include_once '../../app/principal/modelo/AutoCargador.php';

use app\principal\modelo\AutoCargador as Cargador;
use app\carrera\modelo\Carrera as Carrera;

Cargador::cargarModulos();

$nombre = "Licenciatura en psicopedagogia";
$carrera = new Carrera("045", $nombre, $nombre);
$resultado = $carrera->crear();

echo "<br>RESULTADO {$resultado[0]} : {$resultado[1]}";
if ($resultado[0] == 2) {
    echo "<br> DATOS: " . $carrera->getId() . " " . $carrera->getNombreCorto() . " " . $carrera->getNombreLargo();
}
