<?php

/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\asignatura\controlador\ControladorAsignatura;
use app\principal\modelo\AutoCargador;
use app\principal\modelo\Log;

AutoCargador::cargarModulos();

$arreglo = array();
if (isset($_POST['codigoCarrera']) && isset($_POST['nombre'])) {
    $codigo = $_POST['codigoCarrera'];
    $nombre = $_POST['nombre'];
    $controlador = new ControladorAsignatura();
    $resultado = $controlador->buscarPorCarrera($codigo, $nombre, FALSE);
    if ($resultado[0] == 2) {
        $asignaturas = $resultado[1];
        foreach ($asignaturas as $asignatura) {
            $id = $asignatura["id"];
            $nombre = $asignatura["nombreLargo"];
            $arreglo[] = array('id' => $id, 'text' => $nombre);
        }
    }
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION */

echo json_encode($arreglo);
