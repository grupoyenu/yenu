<?php

include_once '../../app/principal/modelo/Constantes.php';
include_once '../../app/principal/modelo/AutoCargador.php';

use app\mesa\modelo\MesaExamen as MesaExamen;
use app\principal\modelo\AutoCargador as Cargador;

Cargador::cargarModulos();

$mesa = new MesaExamen(1);
$resultado = $mesa->obtenerPorIdentificador();

echo "<br>RESULTADO {$resultado[0]} : {$resultado[1]}";
if ($resultado[0] == 2) {
    $primero = $mesa->getPrimerLlamado();
    $segundo = $mesa->getSegundoLlamado();
    $tribunal = $mesa->getTribunal();
    $docentes = $tribunal->getDocentes();
    echo "<br>ID: " . $mesa->getId();
    echo "<br>Fecha creacion: " . $mesa->getFechaCreacion();
    echo "<br>Observacion: " . $mesa->getObservacion();

    if ($primero) {
        $aula = $primero->getAula();
        echo "<BR><BR> PID: " . $primero->getId();
        echo "<br> PEstado: " . $primero->getEstado();
        echo "<br> PFecha: " . $primero->getFecha();
        echo "<br> PHora: " . $primero->getHora();
        if ($aula) {
            echo "<br> PAula: " . $aula->getId() . " | " . $aula->getNombre() . " | " . $aula->getSector();
        }
    }

    if ($segundo) {
        $aula = $segundo->getAula();
        echo "<BR><BR> SID: " . $segundo->getId();
        echo "<br> SEstado: " . $segundo->getEstado();
        echo "<br> SFecha: " . $segundo->getFecha();
        echo "<br> SHora: " . $segundo->getHora();
        if ($aula) {
            echo "<br> SAula: " . $aula->getId() . " | " . $aula->getNombre() . " | " . $aula->getSector();
        }
    }

    echo "<BR><br>TID: " . $tribunal->getId();
    foreach ($docentes as $docente) {
        echo "<br>DOCENTE: {$docente->getId()} : {$docente->getNombre()}";
    }
}