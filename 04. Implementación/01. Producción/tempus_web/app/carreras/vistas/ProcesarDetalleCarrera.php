<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$html = "";
if (isset($_POST['id'])) {
    $codigo = $_POST['id'];
    $carrera = new Carrera();
    $carrera->setCodigo($codigo);
    $obtener = $carrera->obtener();
    if ($obtener == 2) {
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
    }
} else {
    $html = '<div class="alert alert-danger text-center" role="alert">No se obtuvo la información del formulario</div>';
}

echo $html;
