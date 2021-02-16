<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$html = "";
if (isset($_POST['id'])) {
    $idRol = $_POST['id'];
    $rol = new Rol();
    $rol->setIdRol($idRol);
    $obtener = $rol->obtener();
    if ($obtener == 2) {
        $permisos = $rol->getPermisos();
        $html = '
            <div class="form-row mb-4">
                <label for="nombre" class="col-sm-2 col-form-label text-left">Nombre:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           placeholder="Nombre del rol" value="' . $rol->getNombre() . '" readonly>
                </div>
            </div>
            <div class="form-row mb-4">
                <div class="table-responsive">
                    <table id="tablaDetalleRol" class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Nombre de permiso</th>
                            </tr>
                        </thead>
                        <tbody>';
        foreach ($permisos as $permiso) {
            $html .= '
                    <tr> 
                        <td class="align-middle">' . $permiso['nombre'] . '</td> 
                    </tr>';
        }
        $html = $html . '
                        </tbody>
                    </table>
                </div>
            </div>';
    } else {
        $class = ($obtener == 0) ? 'class="alert alert-danger text-center"' : 'class="alert alert-warning text-center"';
        $html = '<div ' . $class . ' role="alert">' . $rol->getDescripcion() . '</div>';
    }
} else {
    $html = '<div class="alert alert-danger text-center" role="alert">No se obtuvo la información del formulario</div>';
}

echo $html;
