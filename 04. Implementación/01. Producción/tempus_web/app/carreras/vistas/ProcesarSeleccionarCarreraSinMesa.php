<?php

/**
 * Se utiliza para cargar los options en los select con el plugin SELECT2. El objetivo
 * es que se muestren solo las carreras que tienen asignaturas sin cursada creada.
 * Al momento de crear una cursada, se busca solo en estas carreras.
 */
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$controlador = new ControladorCarreras();
$arreglo = array();

if (isset($_POST['nombre'])) {
    // SE ESCRIBIO EL NOMBRE O PARTE DEL NOMBRE DE LA CARRERA QUE SE BUSCA.
    $nombre = $_POST['nombre'];
    $carreras = $controlador->listarSinMesa($nombre);
} else {
    // NO SE ESCRIBIO EL NOMBRE DE NINGUNA CARRERA. SE BUSCAN POR DEFECTO.
    $nombre = "a";
    $carreras = $controlador->listarSinMesa($nombre);
}

if (gettype($carreras) == "object") {
    // SE EJECUTO LA CONSULTA CORRECTAMENTE. SE PROCESAN LOS RESULTADOS.
    while ($carrera = $carrera->fetch_assoc()) {
        $nombre = str_pad($carrera['codigo'], 3, "0", STR_PAD_LEFT) . ": " . $carrera["nombre"];
        $arreglo[] = array('id' => $carrera["codigo"], 'text' => $nombre);
    }
} else {
    // NO SE EJECUTO LA CONSULTA. SE INDICA QUE NO HAY RESULTADOS PARA MOSTRAR.
    $arreglo[] = array('id' => "NO", 'text' => "Sin resultados");
}

// SE DEVUELVE EL ARREGLO CON FORMATO JSON.
echo json_encode($arreglo);
