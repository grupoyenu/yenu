<?php

/**
 * Se utiliza para cargar los options en los select con el plugin SELECT2. El objetivo
 * es que se muestren solo las asignaturas que no tienen cursada creada.
 * Al momento de crear una cursada, se busca solo en estas asignaturas.
 */
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$controlador = new ControladorAsignaturas();
$arreglo = array();

if (isset($_POST['codigoCarrera']) && isset($_POST['nombre'])) {
    // SE ESCRIBIO EL CODIGO DE CARRERA Y NOMBRE DE LA ASIGNATURA QUE SE BUSCA.
    $nombre = $_POST['nombre'];
    $asignaturas = $controlador->listarSinMesa($codigo, $nombre);
} else {
    // NO SE ESCRIBIO EL NOMBRE DE NINGUNA CARRERA. SE BUSCAN POR DEFECTO.
    $nombre = "a";
    $asignaturas = $controlador->listarSinMesa($codigo, $nombre);
}

if (gettype($asignaturas) == "object") {
    // SE EJECUTO LA CONSULTA CORRECTAMENTE. SE PROCESAN LOS RESULTADOS.
    while ($asignatura = $asignaturas->fetch_assoc()) {
        $arreglo[] = array('id' => $asignatura["idasignatura"], 'text' => $asignatura["nombre"]);
    }
} else {
    // NO SE EJECUTO LA CONSULTA. SE INDICA QUE NO HAY RESULTADOS PARA MOSTRAR.
    $arreglo[] = array('id' => "NO", 'text' => "Sin resultados");
}

// SE DEVUELVE EL ARREGLO CON FORMATO JSON.
echo json_encode($arreglo);
