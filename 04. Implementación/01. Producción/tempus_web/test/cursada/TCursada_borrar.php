<?php

include_once '../../app/principal/modelo/Constantes.php';
include_once '../../app/principal/modelo/AutoCargador.php';

use app\principal\modelo\AutoCargador as Cargador;
use app\cursada\modelo\Cursada;
use app\cursada\modelo\Clase;

Cargador::cargarModulos();

$cursada = new Cursada();
$ids = array(2, 4);

foreach ($ids as $id) {
    $clase = new Clase($id);
    $obtener = $clase->obtenerPorIdentificador();
    if ($obtener[0] == 2) {
        $cursada->agregarClase($clase);
    }
}

$resultado = $cursada->borrar();
echo "<br> $resultado[0] : $resultado[1]";
