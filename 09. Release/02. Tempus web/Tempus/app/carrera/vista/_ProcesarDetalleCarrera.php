<?php

/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\carrera\modelo\Carrera;
use app\principal\controlador\ControladorHTML;
use app\principal\modelo\AutoCargador;

AutoCargador::cargarModulos();

$html = "";
if (isset($_POST['id'])) {
    $codigo = $_POST['id'];
    $carrera = new Carrera($codigo);
    $resultado = $carrera->obtener();
    if ($resultado[0] == 2) {
        $asignaturas = $carrera->getAsignaturas();
        $html = '
        <div class="table-responsive">
            <table id="tablaDetalleCarrera" class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Año</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($asignaturas as $asignatura) {
            $html .= '
                <tr> 
                    <td class="align-middle">' . $asignatura['nombre'] . '</td>
                    <td class="align-middle">' . $asignatura['anio'] . '°</td>
                </tr>';
        }
        $html .= '
                </tbody>
            </table>
        </div>';
    } else {
        $codigo = $resultado[0];
        $mensaje = $resultado[1];
        $html = ControladorHTML::mostrarAlertaResultadoOperacion($codigo, $mensaje);
    }
} else {
    $mensaje = "No se obtuvo la información del formulario";
    $html = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}

echo $html;
