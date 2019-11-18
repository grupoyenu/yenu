<?php
/**
 * Se utiliza para cargar los options en los select con el plugin SELECT2. El objetivo
 * es que se muestren solo las asignaturas que no tienen mesa creada.
 * Al momento de crear una cursada, se busca solo en estas asignaturas.
 */
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$arreglo = array();

if (isset($_POST['codigo']) && isset($_POST['nombre'])) {
    // SE ESCRIBIO EL CODIGO DE CARRERA Y NOMBRE DE LA ASIGNATURA QUE SE BUSCA.
    $controlador = new ControladorAsignaturas();
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $asignaturas = $controlador->listarSinCursada($codigo, $nombre);
    if (gettype($asignaturas) == "object") {
        while ($asignatura = $asignaturas->fetch_assoc()) {
            $arreglo[] = array('id' => $asignatura["idAsignatura"], 'text' => utf8_encode($asignatura["nombre"]));
        }
    } else {
        $arreglo[] = array('id' => "NO", 'text' => "Sin resultados");
    }
}

// SE DEVUELVE EL ARREGLO CON FORMATO JSON.
echo json_encode($arreglo);


