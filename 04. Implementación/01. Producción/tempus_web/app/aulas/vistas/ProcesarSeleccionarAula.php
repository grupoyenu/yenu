<?php

/**
 * Se utiliza para cargar los options en los select con el plugin SELECT2. Esta porcion
 * de codigo es utilizada en: formCrearMesa y formModificarMesa.
 */
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
$controlador = new ControladorAula();
$arreglo = array();

if (isset($_POST['nombre'])) {
    $campo = "nombre";
    $nombre = $_POST['nombre'];
    $aulas = $controlador->buscar($campo, $nombre);
} else {
    $aulas = $controlador->listarUltimasCreadas();
}

if (gettype($aulas) == "object") {
    while ($aula = $aulas->fetch_assoc()) {
        $arreglo[] = array('id' => $aula["idaula"], 'text' => $aula["sector"] . " - " . $aula["nombre"]);
    }
} else {
    $arreglo[] = array('id' => "NO", 'text' => "Sin resultados");
}
echo json_encode($arreglo);
