<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$html = "";
if (isset($_POST['nombre'])) {
    $controlador = new ControladorCarreras();
    $nombre = $_POST['nombre'];
    $rows = $controlador->buscar($nombre);
    if (!empty($rows)) {
        $html = '
        <form id="fmBuscarCarrera" id="fmBuscarCarrera" method="POST" action="carrera_agregar">
            <input type="hidden" id="codigo" name="codigo">
            <div class="table-responsive mb-4 mt-4">
                <table id="tablaBuscarCarreras" class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                    <thead class="thead-dark">
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Asignaturas</th>
                            <th class="text-center">Operaciones</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($rows as $carrera) {
            $codigo = str_pad($carrera['codigo'], 3, "0", STR_PAD_LEFT);
            $html .= '
                <tr> 
                    <td class="align-middle">' . $codigo . '</td> 
                    <td class="align-middle">' . $carrera['nombre'] . '</td> 
                    <td class="align-middle">' . $carrera['cantidad'] . '</td>
                    <td class="text-center">
                        <div class="btn-group btn-group-sm" role="group">
                            <a class="btn btn-outline-success agregarAsignatura" name="' . $carrera['codigo'] . '"><img src="./lib/img/plus-circle.svg"/></a>
                            <a class="btn btn-outline-info detalleCarrera" name="' . $carrera['codigo'] . '"><img src="./lib/img/search.svg"/></a>
                        </div>
                    </td>   
                </tr>';
        }
        $html .= '  </tbody>
                </table>
            </div>
        </form>';
    } else {
        $class = (is_null($rows)) ? 'class="alert alert-danger text-center"' : 'class="alert alert-warning text-center"';
        $html = '<div ' . $class . ' role="alert">' . $controlador->getDescripcion() . '</div>';
    }
} else {
    $html = '<div class="alert alert-danger text-center" role="alert">No se obtuvo la información del formulario</div>';
}

echo '<div class="card text-center">
        <div class="card-header text-left">Resultado de la búsqueda</div>
        <div class="card-body"> ' . $html . '</div>
     </div>';
