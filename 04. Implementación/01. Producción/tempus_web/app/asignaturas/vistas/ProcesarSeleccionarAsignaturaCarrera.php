<?php

/**
 * Se utiliza para cargar los options en los select con el plugin SELECT2.
 */
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
$controlador = new ControladorAsignaturas();
$arreglo = array();

if (isset($_POST['codigoCarrera']) && isset($_POST['nombre'])) {
    $codigo = $_POST['codigoCarrera'];
    $nombre = $_POST['nombre'];
    $asignaturas = $controlador->buscarPorCarrera($codigo, $nombre, FALSE);
    if (gettype($asignaturas) == "object") {
        while ($asignatura = $asignaturas->fetch_assoc()) {
            $arreglo[] = array('id' => $asignatura["idasignatura"], 'text' => utf8_encode($asignatura["nombre"]));
        }
    } else {
        $arreglo[] = ($asignaturas == 1) ? array('id' => "_" . $nombre, 'text' => $nombre) : array('id' => "NO", 'text' => "Sin resultados");
    }
}

echo json_encode($arreglo);
