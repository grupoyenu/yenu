<?php

/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\seguridad\controlador\ControladorUsuario;
use app\principal\controlador\ControladorHTML;
use app\principal\modelo\AutoCargador;

AutoCargador::cargarModulos();

/* INICIALIZA LA SESION PARA GUARDAR EL LOG */

session_start();

/* INICIO DEL CODIGO PROPIO DEL ARCHIVO */

$controlador = new ControladorUsuario();
if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $datos = ($nombre) ? "'{$nombre}'" : "TODOS";
    $filtro = "Resultado de la búsqueda: " . $datos;
    $resultado = $controlador->buscarPorNombre($nombre);
    $_SESSION['BUSUSU'] = array($nombre, $datos);
} else {
    if (isset($_SESSION['BUSUSU'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BUSUSU'];
        $nombre = $parametros[0];
        $filtro = "Última búsqueda realizada: " . $parametros[1];
        $resultado = $controlador->buscarPorNombre($nombre);
        $_SESSION['BUSUSU'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $resultado = $controlador->listarResumenUsuarios(10);
        $filtro = "Resumen de usuarios";
        $_SESSION['BUSUSU'] = NULL;
    }
}

$html = "";
if ($resultado[0] == 2) {
    $usuarios = $resultado[1];
    $filas = "";
    foreach ($usuarios as $usuario) {
        $id = $usuario['id'];
        $nombre = $usuario['nombreUsuario'];
        $email = $usuario['email'];
        $metodo = $usuario['metodoLogin'];
        $estado = $usuario['estado'];
        $rol = $usuario['nombreRol'];
        if ($usuario['estado'] == "Activo") {
            $operaciones = "
                <button class='btn btn-outline-warning editar' 
                        name='{$id}' title='Editar ($nombre)'>
                        <i class='far fa-edit'></i>
                </button>";
        }
        $filas .= "
            <tr> 
                <td class='align-middle'>{$nombre}</td>
                <td class='align-middle'>{$email}</td>
                <td class='align-middle'>{$metodo}</td>
                <td class='align-middle'>{$estado}</td>
                <td class='align-middle'>{$rol}</td>
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>
                        {$operaciones}
                        <button class='btn btn-outline-danger borrar' 
                                name='{$id}' title='Borrar ($nombre)'>
                                <i class='fas fa-trash'></i>
                        </button>
                    </div>
                </td>
            </tr>";
        $html = '
            <div class="table-responsive mt-4 mb-4">
                <table id="tablaBuscarUsuarios" class="table table-bordered table-hover">
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
    $codigo = $resultado[0];
    $mensaje = $resultado[1];
    $html = ControladorHTML::mostrarAlertaResultadoBusqueda($codigo, $mensaje);
}

echo ControladorHTML::mostrarCardResultadoBusqueda($filtro, $html);
