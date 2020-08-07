<?php

/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\docente\controlador\ControladorDocente;
use app\principal\modelo\AutoCargador;

AutoCargador::cargarModulos();

$arreglo = array();
if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    $controlador = new ControladorDocente();
    $resultado = $controlador->seleccionar($nombre);
    if ($resultado[0] == 2) {
        $docentes = $resultado[1];
        foreach ($docentes as $docente) {
            $id = $docente['id'];
            $nombre = $docente['nombre'];
            $arreglo[] = array('id' => $id, 'text' => $nombre);
        }
    }
}

echo json_encode($arreglo);
