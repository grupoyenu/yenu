<?php

include_once '../../app/principal/modelo/Constantes.php';
include_once '../../app/principal/modelo/AutoCargador.php';

use app\principal\modelo\AutoCargador as Cargador;
use app\cursada\modelo\Clase;
use app\aula\modelo\Aula;

Cargador::cargarModulos();

$aula = new Aula(NULL, 'Laboratorio de prueba', 'A');
$plan = 4;
$diaSemana = 1;
$horaInicio = "17:00";
$horaFin = "19:00";
$clase = new Clase(NULL, $aula, $plan, $diaSemana, $horaInicio, $horaFin);
$resultado = $clase->crear();

echo "<br>RESULTADO {$resultado[0]}: {$resultado[1]}";
if ($resultado[0] == 2) {
    $aula = $clase->getAula();
    echo "<br> Identificador: " . $clase->getId();
    echo "<br> Dia: " . $clase->getDiaSemana("NRO") . " " . $clase->getDiaSemana("NRO");
    echo "<br> Inicio: " . $clase->getHoraInicio("HHMMSS") . " " . $clase->getHoraInicio("HHMM");
    echo "<br> Fin: " . $clase->getHoraFin("HHMMSS") . " " . $clase->getHoraFin("HHMM");
    if ($aula) {
        echo "<br> Aula Identificador: " . $aula->getId();
        echo "<br> Aula Sector: " . $aula->getSector();
        echo "<br> Aula Nombre: " . $aula->getNombre();
    }
    echo "<br> Edicion: " . $clase->getFechaEdicion();
} 

