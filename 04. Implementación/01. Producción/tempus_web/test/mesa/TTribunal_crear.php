<?php

include_once '../../app/principal/modelo/Constantes.php';
include_once '../../app/principal/modelo/AutoCargador.php';

use app\docente\modelo\Docente as Docente;
use app\mesa\modelo\Tribunal as Tribunal;
use app\principal\modelo\AutoCargador as Cargador;

Cargador::cargarModulos();

$presidente = new Docente(NULL, 'Presidente Dos');
$vocal1 = new Docente(null, 'VocalUno Dos');
$vocal2 = new Docente(null, 'VocalDos Dos');
$suplente = new Docente(null, 'Suplente Dos');

$tribunal = new Tribunal(NULL);
echo "<br> Agregado presidente : " . $tribunal->agregarDocente($presidente);
echo "<br> Agregado vocal 1 : " . $tribunal->agregarDocente($vocal1);
echo "<br> Agregado vocal 2 : " . $tribunal->agregarDocente($vocal2);
echo "<br> Agregado suplente : " . $tribunal->agregarDocente(NULL);
$resultado = $tribunal->crear();

echo "<br>RESULTADO $resultado[0]: $resultado[1]";
if ($resultado[0] == 2) {
    echo "<br> DATOS: " . $tribunal->getId();
    foreach ($tribunal->getDocentes() as $docente) {
        echo "<br>{$docente->getId()} : {$docente->getNombre()}";
    }
}

