<?php

/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\seguridad\controlador\ControladorRol;
use app\principal\modelo\AutoCargador;

AutoCargador::cargarModulos();

$arreglo = array();
if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    $controlador = new ControladorRol();
    $resultado = $controlador->seleccionar($nombre);
    if ($resultado[0] == 2) {
        $roles = $resultado[1];
        foreach ($roles as $rol) {
            $id = $rol['id'];
            $nombre = $rol['nombre'];
            $arreglo[] = array('id' => $id, 'text' => $nombre);
        }
    }
}

echo json_encode($arreglo);
