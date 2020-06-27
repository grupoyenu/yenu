<?php

include_once '../../app/principal/modelo/Constantes.php';
include_once '../../app/principal/modelo/AutoCargador.php';

use app\principal\modelo\AutoCargador as Cargador;
use app\docente\modelo\Docente as Docente;

Cargador::cargarModulos();

$docente = new Docente(NULL, "Osiris Sofia");
$resultado = $docente->crear();

echo "<br>RESULTADO {$resultado[0]}: {$resultado[1]}";
if ($resultado[0] == 2) {
    echo "<br>DATOS:{$docente->getId()} : {$docente->getNombre()}";
} 