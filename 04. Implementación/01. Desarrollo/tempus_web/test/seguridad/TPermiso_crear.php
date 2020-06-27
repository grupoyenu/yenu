<?php

include_once '../../app/principal/modelo/Constantes.php';
include_once '../../app/principal/modelo/AutoCargador.php';

use app\principal\modelo\AutoCargador as Cargador;
use app\seguridad\modelo\Permiso as Permiso;

Cargador::cargarModulos();

$permiso = new Permiso(NULL, "PERMISOS");
$resultado = $permiso->crear();

echo "<br>RESULTADO {$resultado[0]} : {$resultado[1]}";
if ($resultado[0] == 2) {
    echo "<br> DATOS: " . $permiso->getId() . " " . $permiso->getNombre();
}
