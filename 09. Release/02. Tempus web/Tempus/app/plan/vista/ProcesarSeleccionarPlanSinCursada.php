<?php

/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\plan\controlador\ControladorPlan;
use app\principal\modelo\AutoCargador;

AutoCargador::cargarModulos();

$arreglo = array();
$nombreAsignatura = isset($_POST['nombre']) ? $_POST['nombre'] : "";
$controlador = new ControladorPlan();
$resultado = $controlador->buscarPlanSinCursada($nombreAsignatura);
if ($resultado[0] == 2) {
    $planes = $resultado[1];
    foreach ($planes as $plan) {
        $id = $plan["idPlan"];
        $nombreAsignatura = $plan["nombreLargoAsignatura"];
        $nombreCarrera = $plan["nombreLargoCarrera"];
        $nombre = "{$nombreAsignatura} - {$nombreCarrera}";
        $arreglo[] = array('id' => $id, 'text' => $nombre);
    }
}

echo json_encode($arreglo);
