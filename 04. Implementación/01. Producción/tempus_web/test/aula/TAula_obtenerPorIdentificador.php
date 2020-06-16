<?php

include_once '../../app/principal/modelo/Constantes.php';
include_once '../../app/principal/modelo/AutoCargador.php';

use app\principal\modelo\AutoCargador as Cargador;
use app\aula\modelo\Aula as Aula;

Cargador::cargarModulos();

$id = 1;
$aula = new Aula($id);
$resultado = $aula->obtenerPorIdentificador();

echo '<br> RESULTADO ' . (int) $resultado[0] . " " . $resultado[1];
if ($resultado[0] == 2) {
    echo "<br>DATOS: " . $aula->getId();
    echo " " . $aula->getSector();
    echo " " . $aula->getNombre();
} 
