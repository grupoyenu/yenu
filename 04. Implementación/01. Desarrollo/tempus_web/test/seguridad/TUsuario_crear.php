<?php

include_once '../../app/principal/modelo/Constantes.php';
include_once '../../app/principal/modelo/AutoCargador.php';

use app\principal\modelo\AutoCargador as Cargador;
use app\seguridad\modelo\Usuario as Usuario;

Cargador::cargarModulos();

$usuario = new Usuario(NULL, 'marquez.emanuel.alberto@gmail.com', 'Marquez Emanuel', 'Google', 'Activo', 1);
$resultado = $usuario->crear();

echo "<br>RESULTADO {$resultado[0]} : {$resultado[1]}";
if ($resultado[0] == 2) {
    echo "<br> DATOS: " . $usuario->getId();
    echo " " . $usuario->getEmail();
    echo " " . $usuario->getNombre();
    echo " " . $usuario->getMetodo();
    echo " " . $usuario->getEstado();
}