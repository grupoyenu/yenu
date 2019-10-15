<?php

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
                <thead class="thead-dark">
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

echo $html;
