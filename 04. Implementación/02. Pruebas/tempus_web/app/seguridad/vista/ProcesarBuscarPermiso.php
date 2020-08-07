<?php

/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\seguridad\controlador\ControladorPermiso;
use app\principal\controlador\ControladorHTML;
use app\principal\modelo\AutoCargador;

AutoCargador::cargarModulos();

/* INICIALIZA LA SESION PARA GUARDAR EL LOG */

session_start();

/* INICIO DEL CODIGO PROPIO DEL ARCHIVO */

$controlador = new ControladorPermiso();
if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $datos = ($nombre) ? "'{$nombre}'" : "TODOS";
    $filtro = "Resultado de la búsqueda: " . $datos;
    $resultado = $controlador->buscarPorNombre($nombre);
    $_SESSION['BUSPER'] = array($nombre, $datos);
} else {
    if (isset($_SESSION['BUSPER'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BUSPER'];
        $nombre = $parametros[0];
        $filtro = "Última búsqueda realizada: " . $parametros[1];
        $resultado = $controlador->buscarPorNombre($nombre);
        $_SESSION['BUSPER'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $resultado = $controlador->listarResumenPermisos(10);
        $filtro = "Resumen de permisos";
        $_SESSION['BUSPER'] = NULL;
    }
}
$html = "";
if ($resultado[0] == 2) {
    $permisos = $resultado[1];
    $filas = "";
    foreach ($permisos as $permiso) {
        $id = $permiso['id'];
        $nombre = $permiso['nombre'];
        $totalRoles = $permiso['roles'];
        $operaciones = '';
        if ($totalRoles == 0) {
            $operaciones = "
                <button class='btn btn-outline-danger borrar' 
                        name='{$id}' title='Dar de baja ($nombre)'>
                        <i class='fas fa-trash'></i>
                </button>";
        }
        $filas .= "
            <tr> 
                <td class='align-middle'>{$nombre}</td>
                <td class='align-middle text-center'>{$totalRoles}</td>
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
            <table id="tablaBuscarPermisos" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th title="Nombre del permiso">Nombre</th>
                        <th title="Cantidad total de roles asociados">Total de roles asociados</th>
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
