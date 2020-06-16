<?php

include_once '../../app/principal/modelo/Constantes.php';
include_once '../../app/principal/modelo/AutoCargador.php';

use app\mesa\modelo\Llamado as Llamado;
use app\principal\modelo\AutoCargador as Cargador;

Cargador::cargarModulos();

$llamado = new Llamado(1);
$resultado = $llamado->borrar();

echo "<br>RESULTADO {$resultado[0]} : {$resultado[1]}";
