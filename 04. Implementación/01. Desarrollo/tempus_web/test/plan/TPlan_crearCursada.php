<?php

include_once '../../app/principal/modelo/Constantes.php';
include_once '../../app/principal/modelo/AutoCargador.php';

use app\principal\modelo\AutoCargador as Cargador;
use app\plan\controlador\ControladorPlan;
use app\cursada\modelo\Clase;
use app\aula\modelo\Aula;

Cargador::cargarModulos();

$clases = array();
$aula = new Aula(NULL, 'A', 'A');
$clases[] = new Clase(NULL, $aula, NULL, 1, '14:00', '16:00');
$clases[] = new Clase(NULL, $aula, NULL, 3, '16:00', '18:30');
$clases[] = new Clase(NULL, $aula, NULL, 5, '14:30', '16:00');

$controlador = new ControladorPlan();
$resultado = $controlador->crearCursada(1, $clases);

echo $resultado[0] . " " . $resultado[1];

