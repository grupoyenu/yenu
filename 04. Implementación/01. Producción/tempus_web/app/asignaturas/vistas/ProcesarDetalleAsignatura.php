<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$html = "";
if (isset($_POST['id'])) {
    $idAsignatura = $_POST['id'];
    $asignatura = new Asignatura();
    $asignatura->setIdAsignatura($idAsignatura);
    $obtener = $asignatura->obtener();
    if ($obtener == 2) {
        $carreras = $asignatura->getCarreras();
        $html = '
        <div class="table-responsive">
            <table id="tablaDetalleAsignatura" class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Año</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($carreras as $carrera) {
            $html .= '
                <tr> 
                    <td class="align-middle">' . str_pad($carrera['idcarrera'], 3, "0", STR_PAD_LEFT) . '</td> 
                    <td class="align-middle">' . $carrera['nombre'] . '</td>
                    <td class="align-middle">' . $carrera['anio'] . '°</td>
                </tr>';
        }
        $html = $html . '
                </tbody>
            </table>
        </div>';
    } else {
        $class = ($obtener == 0) ? 'class="alert alert-danger text-center"' : 'class="alert alert-warning text-center"';
        $html = '<div ' . $class . ' role="alert">' . $asignatura->getDescripcion() . '</div>';
    }
} else {
    $html = '<div class="alert alert-danger text-center" role="alert">No se obtuvo la información del formulario</div>';
}

echo $html;


