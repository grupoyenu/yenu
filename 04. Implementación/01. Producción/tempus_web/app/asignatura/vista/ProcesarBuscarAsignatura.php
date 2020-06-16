<?php

/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\asignatura\controlador\ControladorAsignatura;
use app\principal\controlador\ControladorHTML;
use app\principal\modelo\AutoCargador;

AutoCargador::cargarModulos();

session_start();

$controlador = new ControladorAsignatura();
if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $datos = ($nombre) ? "'{$nombre}'" : "TODAS";
    $filtro = "Resultado de la búsqueda: " . $datos;
    $resultado = $controlador->buscarPorNombre($nombre);
    $_SESSION['BUSASI'] = array($nombre, $datos);
} else {
    if (isset($_SESSION['BUSASI'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BUSASI'];
        $nombre = $parametros[0];
        $filtro = "Última búsqueda realizada: " . $parametros[1];
        $resultado = $controlador->buscarPorNombre($nombre);
        $_SESSION['BUSASI'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $limite = 10;
        $resultado = $controlador->listarResumenAsignaturas($limite);
        $filtro = "Resumen de asignaturas";
        $_SESSION['BUSASI'] = NULL;
    }
}
$html = "";
if ($resultado[0] == 2) {
    $asignaturas = $resultado[1];
    $filas = "";
    foreach ($asignaturas as $asignatura) {
        $id = $asignatura['id'];
        $nombreCorto = $asignatura['nombreCorto'];
        $nombreLargo = $asignatura['nombreLargo'];
        $carreras = $asignatura['carreras'];
        if ($carreras == 0) {
            $operaciones = "";
        } else {
            $operaciones = "
                <button class='btn btn-outline-info detalle' 
                    name='{$id}' title='Ver detalle ($nombreCorto - $nombreLargo)'><i class='fas fa-eye'></i>
                </button>";
        }
        $filas .= "
            <tr>
                <td class='align-middle'>{$nombreCorto}</td> 
                <td class='align-middle'>{$nombreLargo}</td> 
                <td class='align-middle'>{$carreras}</td> 
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>{$operaciones}</div>
                </td> 
            </tr>";
    }
    $html = '
        <div class="table-responsive mt-4 mb-4">
            <table id="tablaBuscarAsignaturas" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th title="Nombre corto">Nombre corto</th>
                        <th title="Nombre largo">Nombre largo</th>
                        <th title="Cantidad de carreras asociadas">Carreras</th>
                        <th title="Operaciones disponibles"class="text-center">Operaciones</th>
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
