<?php

/**
 * Se utiliza para cargar los options en los select con el plugin SELECT2. El objetivo
 * es que se muestren solo las carreras que tienen asignaturas sin cursada creada.
 * Al momento de crear una cursada, se busca solo en estas carreras.
 */
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$arreglo = array();

if (isset($_POST['nombre'])) {
    $controlador = new ControladorCarreras();
    $nombre = $_POST['nombre'];
    $carreras = $controlador->listarSinMesa($nombre);
    if (gettype($carreras) == "object") {
        while ($carrera = $carreras->fetch_assoc()) {
            $arreglo[] = array('id' => $carrera["codigo"], 'text' => utf8_encode($carrera["nombre"]));
        }
    } else {
        $arreglo[] = array('id' => "NO", 'text' => "Sin resultados");
    }
}

// SE DEVUELVE EL ARREGLO CON FORMATO JSON.
echo json_encode($arreglo);
