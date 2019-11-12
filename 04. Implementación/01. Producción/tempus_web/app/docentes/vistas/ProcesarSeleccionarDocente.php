<?php

/**
 * Se utiliza para cargar los options en los select con el plugin SELECT2.
 */
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$controlador = new ControladorDocentes();
$arreglo = array();

if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    $docentes = $controlador->buscar($nombre);
} else {
    $docentes = $controlador->listarUltimosCreados();
}

if (gettype($docentes) == "object") {
    while ($docente = $docentes->fetch_assoc()) {
        $arreglo[] = array('id' => $docente["iddocente"], 'text' => $docente["nombre"]);
    }
} else {
    $arreglo[] = array('id' => "NO", 'text' => "Sin resultados");
}
echo json_encode($arreglo);
