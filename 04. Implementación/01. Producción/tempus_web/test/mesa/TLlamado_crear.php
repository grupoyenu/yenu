<?php

include_once '../../app/principal/modelo/Constantes.php';
include_once '../../app/principal/modelo/AutoCargador.php';

use app\aula\modelo\Aula as Aula;
use app\mesa\modelo\Llamado as Llamado;
use app\principal\modelo\AutoCargador as Cargador;

Cargador::cargarModulos();

$aula = new Aula(NULL, '11', 'B');
$llamado = new Llamado(NULL, $aula, 'Activo', '2020-10-10', '10:00');
$resultado = $llamado->crear();

echo "<br>RESULTADO {$resultado[0]} : {$resultado[1]}";
if ($resultado[0] == 2) {
    $aula = $llamado->getAula();
    echo "<br> ID: " . $llamado->getId();
    echo "<br> Estado: " . $llamado->getEstado();
    echo "<br> Fecha: " . $llamado->getFecha();
    echo "<br> Hora: " . $llamado->getHora();
    if ($aula) {
        echo "<br> Aula: " . $aula->getId() . " | " . $aula->getNombre() . " | " . $aula->getSector();
    }
}
