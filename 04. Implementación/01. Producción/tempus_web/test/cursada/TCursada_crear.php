<?php

include_once '../../app/principal/modelo/Constantes.php';
include_once '../../app/principal/modelo/AutoCargador.php';

use app\principal\modelo\AutoCargador as Cargador;
use app\cursada\modelo\Clase;
use app\cursada\modelo\Cursada;
use app\aula\modelo\Aula;

Cargador::cargarModulos();

$aula = new Aula(NULL, 'A', 'A');

$lunes = new Clase(NULL, $aula, NULL, 1, '14:00', '16:00');
$miercoles = new Clase(NULL, $aula, NULL, 3, '16:00', '18:30');
$viernes = new Clase(NULL, $aula, NULL, 5, '14:30', '16:00');
$cursada = new Cursada(6);

$cursada->agregarClase($lunes);

$resultado = $cursada->crear();
echo "<br> $resultado[0] : $resultado[1]";
