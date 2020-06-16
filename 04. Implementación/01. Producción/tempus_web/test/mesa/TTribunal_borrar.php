<?php

include_once '../../app/principal/modelo/Constantes.php';
include_once '../../app/principal/modelo/AutoCargador.php';

use app\mesa\modelo\Tribunal as Tribunal;
use app\principal\modelo\AutoCargador as Cargador;

Cargador::cargarModulos();

$tribunal = new Tribunal(1);
$resultado = $tribunal->borrar();

echo "<br>RESULTADO {$resultado[0]} : {$resultado[1]}";

