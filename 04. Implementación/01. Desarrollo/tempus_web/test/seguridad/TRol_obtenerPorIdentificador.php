<?php

include_once '../../app/principal/modelo/Constantes.php';
include_once '../../app/principal/modelo/AutoCargador.php';

use app\principal\modelo\AutoCargador as Cargador;
use app\seguridad\modelo\Rol as Rol;

Cargador::cargarModulos();

$rol = new Rol(1);
$resultado = $rol->obtenerPorIdentificador();

echo "<br>RESULTADO {$resultado[0]} : {$resultado[1]}";
if ($resultado[0] == 2) {
    $permisos = $rol->getPermisos();
    echo "<br> DATOS: " . $rol->getId() . " " . $rol->getNombre();
    foreach ($permisos as $permiso) {
        echo "<br>" . $permiso['id'] . " " . $permiso['nombre'];
    }
}
