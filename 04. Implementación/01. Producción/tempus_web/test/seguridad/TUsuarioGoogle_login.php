<?php

include_once '../../app/principal/modelo/Constantes.php';
include_once '../../app/principal/modelo/AutoCargador.php';

use app\principal\modelo\AutoCargador as Cargador;
use app\seguridad\modelo\UsuarioGoogle;

Cargador::cargarModulos();

$usuario = new UsuarioGoogle(NULL, 'e.m.a-13@hotmail.com');
$resultado = $usuario->login();

echo "<br>RESULTADO {$resultado[0]} : {$resultado[1]}";
if ($resultado[0] == 2) {
    $rol = $usuario->getRol();
    $permisos = $rol->getPermisos();
    echo "<br> DATOS: " . $usuario->getId();
    echo " " . $usuario->getEmail();
    echo " " . $usuario->getNombre();
    echo " " . $usuario->getMetodo();
    echo " " . $usuario->getEstado();
    echo "<br>" . $rol->getId() . " " . $rol->getNombre();
    foreach ($permisos as $permiso) {
        echo "<br>" . $permiso['id'] . " " . $permiso['nombre'];
    }
}