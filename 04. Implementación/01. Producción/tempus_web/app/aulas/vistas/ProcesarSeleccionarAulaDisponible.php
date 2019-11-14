<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$arreglo = array();

if (isset($_POST['dia']) && isset($_POST['desde']) && isset($_POST['hasta']) && isset($_POST['nombre'])) {
    $dia = $_POST['dia'];
    $desde = $_POST['desde'];
    $hasta = $_POST['hasta'];
    $nombre = $_POST['nombre'];
    $controlador = new ControladorAula();
    $aulas = $controlador->listarAulasDisponibles($dia, $desde, $hasta, $nombre);
    if (gettype($aulas) == "object") {
        while ($aula = $aulas->fetch_assoc()) {
            $arreglo[] = array('id' => $aula["idaula"], 'text' => $aula["sector"] . " - " . $aula["nombre"]);
        }
    } else {
        $arreglo[] = array('id' => "NO", 'text' => "Sin resultados");
    }
}

echo json_encode($arreglo);


