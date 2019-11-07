<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$controlador = new ControladorCarreras();
$arreglo = array();
if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    $carreras = $controlador->buscar($nombre);
    if (gettype($carreras) == "object") {
        while ($carrera = $carreras->fetch_assoc()) {
            $arreglo[] = array('id' => $carrera["codigo"], 'text' => $carrera["nombre"]);
        }
    } else {
        $arreglo[] = array('id' => "NO", 'text' => "Sin resultados");
    }
} else {
    $arreglo[] = array('id' => "0", 'text' => "ERROR 2");
}

echo json_encode($arreglo);

