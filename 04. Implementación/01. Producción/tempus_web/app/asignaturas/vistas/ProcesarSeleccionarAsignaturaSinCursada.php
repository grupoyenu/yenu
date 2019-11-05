<?php

/*
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
$controlador = new ControladorAsignaturas();

$asignaturas = $controlador->listarAsignaturasSinCursadas();
$html = "";
if (gettype($asignaturas) == "object") {
    $filas = "";
    while ($asignatura = $asignaturas->fetch_assoc()) {
        $filas .= "
            <tr>
                <td class='align-middle text-center'>
                    <button class='btn btn-sm btn-outline-success seleccionarAsignatura' 
                            name='{$asignatura['idAsignatura']}' value='{$asignatura['idCarrera']}' 
                            title='Seleccionar'><i class='far fa-check-square'></i>
                    </button>
                </td>
                <td class='align-middle'>" . str_pad($asignatura['idCarrera'], 3, "0", STR_PAD_LEFT) . "</td> 
                <td class='align-middle'>" . utf8_encode($asignatura['nombreCarrera']) . "</td> 
                <td class='align-middle'>" . utf8_encode($asignatura['nombreAsignatura']) . "</td> 
            </tr>";
    }
    $html = '
        <div class="table-responsive">
            <table id="tablaSeleccionarAsignatura" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th>Código</th>
                        <th>Carrera</th>
                        <th>Asignatura</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $html = ControladorHTML::mostrarAlertaResultadoBusqueda($asignaturas, $controlador->getDescripcion());
}

echo $html;*/

/**
 * Se utiliza para cargar los options en los select con el plugin SELECT2. El objetivo
 * es que se muestren solo las asignaturas que no tienen mesa creada.
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
    $asignaturas = $controlador->listarSinCursada($codigo, $nombre);
} else {
    // NO SE ESCRIBIO EL NOMBRE DE NINGUNA CARRERA. SE BUSCAN POR DEFECTO.
    $nombre = "a";
    $asignaturas = $controlador->listarSinCursada($codigo, $nombre);
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


