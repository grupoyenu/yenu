<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
$html = "";

if (isset($_POST['nombre'])) {
    $controlador = new ControladorPermisos();
    $nombre = $_POST['nombre'];
    $rows = $controlador->buscar($nombre);
    if (!empty($rows)) {
        $html = '
            <form id="fmBuscarPermiso" id="fmBuscarPermiso" method="POST">
                <div class="table-responsive mb-4 mt-4">
                    <table id="tablaBuscarPermisos" class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Nombre</th>
                                <th>Roles</th>
                                <th class="text-center">Operaciones</th>
                            </tr>
                        </thead>
                        <tbody>';
        foreach ($rows as $permiso) {
            $cantidad = ($permiso['cantidad']) ? $permiso['cantidad'] : 0;
            $html .= '
                <tr> 
                    <td class="align-middle">' . $permiso['nombre'] . '</td> 
                    <td class="align-middle">' . $cantidad . '</td>
                    <td class="text-center">
                        <div class="btn-group btn-group-sm" role="group">
                            <a class="btn btn-outline-warning editarPermiso" name="' . $permiso['idpermiso'] . '"><img src="./lib/img/edit.svg"/></a>
                            <a class="btn btn-outline-info detallePermiso" name="' . $permiso['idpermiso'] . '"><img src="./lib/img/search.svg"/></a>
                            <a class="btn btn-outline-danger borrarPermiso" name="' . $permiso['idpermiso'] . '"><img src="./lib/img/trash-2.svg"/></a>
                        </div>
                    </td>   
                </tr>';
        }
        $html .= '
                    </tbody>
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
        <div class="card-body">' . $html . '</div>
     </div>';
