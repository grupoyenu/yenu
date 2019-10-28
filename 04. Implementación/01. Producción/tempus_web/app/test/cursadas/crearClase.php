<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();


$dia = 5;
$horaInicio = "12:00";
$horaFin = "14:00";
$aula = 21;

$clase = new Clase(NULL, $dia, $horaInicio, $horaFin, $aula);

$resultado = $clase->crear();


echo $resultado . " " . $clase->getId();
