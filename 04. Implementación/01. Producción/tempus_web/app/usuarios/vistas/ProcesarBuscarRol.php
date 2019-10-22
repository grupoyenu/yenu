<?php

require_once './app/principal/modelos/Constantes.php';
require_once './app/principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$controlador = new ControladorRoles();
if (isset($_POST['btnBuscarRol'])) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $datos = ($nombre) ? "'{$nombre}'" : "TODOS";
    $filtro = "Resultado de la búsqueda: " . $datos;
    $roles = $controlador->buscar($nombre);
    $_SESSION['BUSROL'] = array($nombre, $datos);
} else {
    if (isset($_SESSION['BUSROL'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BUSROL'];
        $nombre = $parametros[0];
        $filtro = "Última búsqueda realizada: " . $parametros[1];
        $roles = $controlador->buscar($nombre);
        $_SESSION['BUSROL'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $roles = $controlador->listarUltimosCreados();
        $filtro = "Últimos roles creados";
        $_SESSION['BUSROL'] = NULL;
    }
}

$html = "";
if (gettype($roles) == "object") {
    $filas = "";
    while ($rol = $roles->fetch_assoc()) {
        if ($rol['cantidad'] > 0) {
            $operaciones = "<button class='btn btn-outline-warning editar' 
                                    name='{$rol['idrol']}' title='Editar'><i class='far fa-edit'></i>
                            </button>";
        } else {
            $operaciones = "<button class='btn btn-outline-warning editar' 
                                    name='{$rol['idrol']}' title='Editar'><i class='far fa-edit'></i>
                            </button>
                            <button class='btn btn-outline-danger baja' 
                                    name='{$rol['idrol']}' title='Dar de baja'><i class='fas fa-trash'></i>
                            </button>";
        }
        $filas .= "
            <tr> 
                <td class='align-middle'>{$rol['nombre']}</td>
                <td class='align-middle text-center'>{$rol['cantidad']}</td>
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>{$operaciones}</div>
                </td>
            </tr>";
    }
    $html = '
        <div class="table-responsive mt-4">
            <table id="tablaBuscarRoles" class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th class="text-center">Operaciones</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $html = ControladorHTML::mostrarAlertaResultadoBusqueda($roles, $controlador->getDescripcion());
}

echo ControladorHTML::mostrarCardResultadoBusqueda($filtro, $html);