<?php

include_once '../../app/principal/modelo/Constantes.php';
include_once '../../app/principal/modelo/AutoCargador.php';

use app\principal\modelo\AutoCargador as Cargador;
use app\plan\modelo\Plan;

Cargador::cargarModulos();

$plan = new Plan(5);
$resultado = $plan->obtenerCursada();

echo "<br> $resultado[0] : $resultado[1]";
if ($resultado[0] == 2) {
    $cursada = $plan->getCursada();
    $clases = $cursada->getClases();
    foreach ($clases as $clase) {
        $aula = $clase->getAula();
        echo "<br><br> Identificador:" . $clase->getId();
        echo "<br> Dia de la semana:" . $clase->getDiaSemana();
        echo "<br> Horario de inicio:" . $clase->getHoraInicio();
        echo "<br> Horario de fin:" . $clase->getHoraFin();
        echo "<br> Aula: " . $aula->getSector() . " " . $aula->getNombre();
        echo "<br> Fecha edicion: " . $clase->getFechaEdicion();
    }
}

