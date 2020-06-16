<?php

/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\seguridad\controlador\ControladorRol;
use app\principal\controlador\ControladorHTML;
use app\principal\modelo\AutoCargador;

AutoCargador::cargarModulos();

/* INICIALIZA LA SESION PARA GUARDAR EL LOG */

session_start();

/* INICIO DEL CODIGO PROPIO DEL ARCHIVO */

$controlador = new ControladorRol();
if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $datos = ($nombre) ? "'{$nombre}'" : "TODOS";
    $filtro = "Resultado de la búsqueda: " . $datos;
    $resultado = $controlador->buscarPorNombre($nombre);
    $_SESSION['BUSROL'] = array($nombre, $datos);
} else {
    if (isset($_SESSION['BUSROL'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BUSROL'];
        $nombre = $parametros[0];
        $filtro = "Última búsqueda realizada: " . $parametros[1];
        $resultado = $controlador->buscarPorNombre($nombre);
        $_SESSION['BUSROL'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $resultado = $controlador->listarResumenRoles(10);
        $filtro = "Resumen de roles";
        $_SESSION['BUSROL'] = NULL;
    }
}

$html = "";
if ($resultado[0] == 2) {
    $roles = $resultado[1];
    $filas = "";
    foreach ($roles as $rol) {
        $id = $rol['id'];
        $nombre = $rol['nombre'];
        $totalUsuarios = $rol['usuarios'];
        $totalPermisos = $rol['permisos'];
        $operaciones = '';
        if ($totalUsuarios == 0) {
            $operaciones = "
                <button class='btn btn-outline-danger borrar' 
                    name='{$id}' title='Borrar ($nombre)'>
                    <i class='fas fa-trash'></i>
                </button>";
        }
        $filas .= "
            <tr> 
                <td class='align-middle'>{$nombre}</td>
                <td class='align-middle text-center'>{$totalUsuarios}</td>
                <td class='align-middle text-center'>{$totalPermisos}</td>
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>
                         <button class='btn btn-outline-warning editar' 
                                name='{$id}' title='Editar ($nombre)'>
                                <i class='far fa-edit'></i>
                        </button>
                        {$operaciones}
                    </div>
                </td>
            </tr>";
    }
    $html = '
        <div class="table-responsive mt-4 mb-4">
            <table id="tablaBuscarRoles" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th title="Nombre del rol">Nombre</th>
                        <th title="Cantidad de usuarios asociados">Usuarios asociados</th>
                        <th title="Cantidad de permisos asociados">Permisos asociados</th>
                        <th title="Operaciones disponibles" class="text-center">Operaciones</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $codigo = $resultado[0];
    $mensaje = $resultado[1];
    $html = ControladorHTML::mostrarAlertaResultadoBusqueda($codigo, $mensaje);
}

echo ControladorHTML::mostrarCardResultadoBusqueda($filtro, $html);
