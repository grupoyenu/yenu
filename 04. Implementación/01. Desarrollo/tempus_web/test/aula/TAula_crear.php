<?php

include_once '../../app/principal/modelo/Constantes.php';
include_once '../../app/principal/modelo/AutoCargador.php';

use app\principal\modelo\AutoCargador as Cargador;
use app\aula\modelo\Aula as Aula;

Cargador::cargarModulos();

$id = NULL;
$sector = 'B';
$nombre = '11';
$aula = new Aula($id, $nombre, $sector);
$resultado = $aula->crear();

echo '<br> [' . (int) $resultado[0] . "] " . $resultado[1] . "<br>";
if ($resultado[0] > 0) {
    echo '<br>DATOS ' . $aula->getId();
    echo ' ' . $aula->getSector();
    echo ' ' . $aula->getNombre();
}