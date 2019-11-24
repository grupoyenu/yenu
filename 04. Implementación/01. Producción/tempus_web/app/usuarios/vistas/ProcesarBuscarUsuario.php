<?php

require_once './app/principal/modelos/Constantes.php';
require_once './app/principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$controlador = new ControladorUsuarios();
if (isset($_POST['btnBuscarUsuario'])) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $datos = ($nombre) ? "'{$nombre}'" : "TODOS";
    $filtro = "Resultado de la búsqueda: " . $datos;
    $usuarios = $controlador->buscar($nombre);
    $_SESSION['BUSUSU'] = array($nombre, $datos);
} else {
    if (isset($_SESSION['BUSUSU'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BUSUSU'];
        $nombre = $parametros[0];
        $filtro = "Última búsqueda realizada: " . $parametros[1];
        $usuarios = $controlador->buscar($nombre);
        $_SESSION['BUSUSU'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $usuarios = $controlador->listarUltimosCreados();
        $filtro = "Últimos usuarios creados y en estado activo";
        $_SESSION['BUSUSU'] = NULL;
    }
}

$html = "";
if (gettype($usuarios) == "object") {
    $filas = "";
    while ($usuario = $usuarios->fetch_assoc()) {
        if ($usuario['estado'] == "Activo") {
            $operaciones = "<button class='btn btn-outline-warning editar' 
                                    name='{$usuario['idUsuario']}' title='Editar'><i class='far fa-edit'></i>
                            </button>
                            <button class='btn btn-outline-danger borrar' 
                                    name='{$usuario['idUsuario']}' title='Borrar'><i class='fas fa-trash'></i>
                            </button>";
        } else {
            $operaciones = "<button class='btn btn-outline-danger borrar' 
                                    name='{$usuario['idUsuario']}' title='Borrar'><i class='fas fa-trash'></i>
                            </button>";
        }
        $filas .= "
            <tr> 
                <td class='align-middle'>" . utf8_encode($usuario['nombreUsuario']) . "</td>
                <td class='align-middle'>{$usuario['email']}</td>
                <td class='align-middle'>{$usuario['metodo']}</td>
                <td class='align-middle'>{$usuario['estado']}</td>
                <td class='align-middle'>{$usuario['nombreRol']}</td>
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>{$operaciones}</div>
                </td>
            </tr>";
        $html = '
            <div class="table-responsive mt-4">
                <table id="tablaBuscarRoles" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th title="Nombre del usuario">Nombre</th>
                            <th title="Correo electrónico">Email</th>
                            <th title="Método de acceso">Método</th>
                            <th title="Estado actual">Estado</th>
                            <th title="Nombre del rol">Rol</th>
                            <th title="Operaciones disponibles" class="text-center">Operaciones</th>
                        </tr>
                    </thead>
                    <tbody>' . $filas . '</tbody>
                </table>
            </div>';
    }
} else {
    $html = ControladorHTML::mostrarAlertaResultadoBusqueda($usuarios, $controlador->getDescripcion());
}

echo ControladorHTML::mostrarCardResultadoBusqueda($filtro, $html);
