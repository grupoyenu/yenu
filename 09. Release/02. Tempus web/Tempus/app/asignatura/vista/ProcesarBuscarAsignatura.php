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
if ($_POST['peticion'] || !isset($_SESSION['BUSCAR_ASIGNATURA'])) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $datos = ($nombre) ? "'{$nombre}'" : "TODAS";
    $filtro = "Resultado de la búsqueda: " . $datos;
    $resultado = $controlador->buscarPorNombre($nombre);
    $_SESSION['BUSCAR_ASIGNATURA'] = array($nombre, $datos);
} else {
    if (isset($_SESSION['BUSCAR_ASIGNATURA'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BUSCAR_ASIGNATURA'];
        $nombre = $parametros[0];
        $filtro = "Última búsqueda realizada: " . $parametros[1];
        $resultado = $controlador->buscarPorNombre($nombre);
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
        $fechaCreacion = date_format(date_create($asignatura['fechaCreacion']), 'd/m/Y ');
        $carreras = $asignatura['carreras'];
        $filas .= "
            <tr>
                <td class='align-middle'>{$nombreCorto}</td> 
                <td class='align-middle'>{$nombreLargo}</td> 
                <td class='align-middle'>{$fechaCreacion}</td> 
                <td class='align-middle'>{$carreras}</td> 
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>    
                        <button class='btn btn-outline-info detalle' 
                            name='{$id}' title='Detalle: $nombreCorto - $nombreLargo'><i class='fas fa-eye'></i>
                        </button>
                    </div>
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
                        <th title="Fecha de creación">Creación</th>
                        <th title="Cantidad total de carreras asociadas">Total de carreras</th>
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
