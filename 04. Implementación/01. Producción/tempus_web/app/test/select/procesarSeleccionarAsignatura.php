<?php

/**
 * Se utiliza para cargar los options en los select con el plugin SELECT2.
 */

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();


$arreglo = array();
if (isset($_POST['codigo']) && isset($_POST['nombre'])) {
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $arreglo[] = array('id' => $codigo, 'text' => $codigo . ": " . $nombre);
} else {
    $arreglo[] = array('id' => "NO", 'text' => "ERROR 2");
}

echo json_encode($arreglo);
