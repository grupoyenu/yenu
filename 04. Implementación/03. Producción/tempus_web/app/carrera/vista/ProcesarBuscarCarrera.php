<?php

/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\carrera\controlador\ControladorCarrera;
use app\principal\controlador\ControladorHTML;
use app\principal\modelo\AutoCargador;

AutoCargador::cargarModulos();

/* INICIALIZA LA SESION */

session_start();

$controlador = new ControladorCarrera();
if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $datos = ($nombre) ? "'{$nombre}'" : "TODAS";
    $filtro = "Resultado de la búsqueda: " . $datos;
    $resultado = $controlador->buscarPorNombre($nombre);
    $_SESSION['BUSCAR'] = array($nombre, $datos);
} else {
    if (isset($_SESSION['BUSCAR'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BUSCAR'];
        $nombre = $parametros[0];
        $filtro = "Última búsqueda realizada: " . $parametros[1];
        $resultado = $controlador->buscarPorNombre($nombre);
        $_SESSION['BUSCAR'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $limite = 10;
        $resultado = $controlador->listarResumenCarreras($limite);
        $filtro = "Últimas carreras creadas";
        $_SESSION['BUSCAR'] = NULL;
    }
}
$html = "";
if ($resultado[0] == 2) {
    $carreras = $resultado[1];
    $filas = "";
    foreach ($carreras as $carrera) {
        $codigo = str_pad($carrera['id'], 3, "0", STR_PAD_LEFT);
        $nombreCorto = $carrera['nombreCorto'];
        $nombreLargo = $carrera['nombreLargo'];
        $asignaturas = $carrera['asignaturas'];
        if ($asignaturas == 0) {
            $operaciones = "
                <button class='btn btn-outline-success agregar' 
                        name='{$codigo}'
                        title='Agregar asignatura ($nombreCorto - $nombreLargo)'>
                        <i class='fas fa-plus-circle'></i>
                </button>";
        } else {
            $operaciones = "
                <button class='btn btn-outline-info detalle' 
                        name='{$codigo}' 
                        title='Ver detalle ($nombreCorto - $nombreLargo)'>
                        <i class='fas fa-eye'></i>
                </button>
                <button class='btn btn-outline-success agregar' 
                        name='{$codigo}' 
                        title='Agregar asignatura ($nombreCorto - $nombreLargo)'>
                        <i class='fas fa-plus-circle'></i>
                </button>";
        }
        $filas .= " 
            <tr> 
                <td class='align-middle'>{$codigo}</td> 
                <td class='align-middle'>{$nombreCorto}</td> 
                <td class='align-middle'>{$nombreLargo}</td> 
                <td class='align-middle'>{$asignaturas}</td>
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>{$operaciones}</div>
                </td>   
            </tr>";
    }
    $html = '
        <div class="table-responsive mt-4 mb-4">
            <table id="tablaBuscarCarreras" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th title="Código">Código</th>
                        <th title="Nombre corto">Nombre corto</th>
                        <th title="Nombre largo">Nombre largo</th>
                        <th title="Cantidad total de asignaturas asociadas">Total de asignaturas</th>
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
