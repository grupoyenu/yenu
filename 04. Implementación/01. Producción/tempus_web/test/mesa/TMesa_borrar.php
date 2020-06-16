<?php

include_once '../../app/principal/modelo/Constantes.php';
include_once '../../app/principal/modelo/AutoCargador.php';

use app\mesa\modelo\MesaExamen as MesaExamen;
use app\principal\modelo\AutoCargador as Cargador;

Cargador::cargarModulos();

$mesa = new MesaExamen(1);
$resultado = $mesa->obtenerPorIdentificador();

if ($resultado[0] == 2) {
    $borrar = $mesa->borrar();
    echo "<br>RESULTADO BORRAR {$borrar[0]} : {$borrar[1]}";
    
} else {
    echo "<br>RESULTADO {$resultado[0]} : {$resultado[1]}";
}

