<?php

include_once '../../app/principal/modelo/Constantes.php';
include_once '../../app/principal/modelo/AutoCargador.php';

use app\principal\modelo\AutoCargador as Cargador;
use app\seguridad\modelo\Rol as Rol;

Cargador::cargarModulos();

$permisos = array();

$permisos[] = 1;
$permisos[] = 2;
$permisos[] = 3;

$rol = new Rol(NULL, "ADMINISTRADOR", $permisos);
$resultado = $rol->crear();

echo "<br>RESULTADO {$resultado[0]} : {$resultado[1]}";
if ($resultado[0] == 2) {
    echo "<br> DATOS: " . $rol->getId() . " " . $rol->getNombre();
}