<?php

require_once './app/principal/modelos/Constantes.php';
require_once './app/principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$controlador = new ControladorPermisos();

if (isset($_POST['btnBuscarPermiso'])) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $datos = ($nombre) ? "'{$nombre}'" : "TODOS";
    $filtro = "Resultado de la búsqueda: " . $datos;
    $permisos = $controlador->buscar($nombre);
    $_SESSION['BUSPER'] = array($nombre, $datos);
} else {
    if (isset($_SESSION['BUSPER'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BUSPER'];
        $nombre = $parametros[0];
        $filtro = "Última búsqueda realizada: " . $parametros[1];
        $permisos = $controlador->buscar($nombre);
        $_SESSION['BUSPER'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $permisos = $controlador->listarUltimosCreados();
        $filtro = "Últimos permisos creados";
        $_SESSION['BUSPER'] = NULL;
    }
}
$html = "";
if (gettype($permisos) == "object") {
    $filas = "";
    while ($permiso = $permisos->fetch_assoc()) {
        if ($permiso['cantidad'] > 0) {
            $operaciones = "<button class='btn btn-outline-warning editar' 
                                    name='{$permiso['idpermiso']}' title='Editar'><i class='far fa-edit'></i>
                            </button>";
        } else {
            $operaciones = "<button class='btn btn-outline-warning editar' 
                                    name='{$permiso['idpermiso']}' title='Editar'><i class='far fa-edit'></i>
                            </button>
                            <button class='btn btn-outline-danger borrar' 
                                    name='{$permiso['idpermiso']}' title='Dar de baja'><i class='fas fa-trash'></i>
                            </button>";
        }
        $filas .= "
            <tr> 
                <td class='align-middle'>{$permiso['nombre']}</td>
                <td class='align-middle text-center'>{$permiso['cantidad']}</td>
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>{$operaciones}</div>
                </td>
            </tr>";
    }
    $html = '
        <div class="table-responsive mt-4">
            <table id="tablaBuscarPermisos" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th title="Nombre del permiso">Nombre</th>
                        <th title="Cantidad de roles asociados">Roles asociados</th>
                        <th title="Operaciones disponibles" class="text-center">Operaciones</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $html = ControladorHTML::mostrarAlertaResultadoBusqueda($permisos, $controlador->getDescripcion());
}

echo ControladorHTML::mostrarCardResultadoBusqueda($filtro, $html);
