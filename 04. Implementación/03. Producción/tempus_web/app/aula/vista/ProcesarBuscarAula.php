<?php

/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\aula\controlador\ControladorAula;
use app\principal\controlador\ControladorHTML;
use app\principal\modelo\AutoCargador;

AutoCargador::cargarModulos();

session_start();

$controlador = new ControladorAula();
if ($_POST['peticion']) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $sector = $_POST['sector'];
    $nombre = $_POST['nombre'];
    $datos = ($sector) ? "'{$sector}', " : "TODOS, ";
    $datos .= ($nombre) ? "'{$nombre}'" : "TODOS";
    $filtro = "Resultado de la búsqueda: " . $datos;
    $resultado = $controlador->buscarPorSectorNombre($sector, $nombre);
    $_SESSION['BUSAUL'] = array($sector, $nombre, $datos);
} else {
    if (isset($_SESSION['BUSAUL'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BUSAUL'];
        $sector = $parametros[0];
        $nombre = $parametros[1];
        $filtro = "Última búsqueda realizada: " . $parametros[2];
        $resultado = $controlador->buscarPorSectorNombre($sector, $nombre);
        $_SESSION['BUSAUL'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $limite = 10;
        $resultado = $controlador->listarResumenAulas($limite);
        $filtro = "Resumen de aulas";
        $_SESSION['BUSAUL'] = NULL;
    }
}
$html = "";
if ($resultado[0] == 2) {
    $aulas = $resultado[1];
    $filas = "";
    foreach ($aulas as $aula) {
        $sector = $aula['sector'];
        $nombre = $aula['nombre'];
        $totalClases = $aula['clases'];
        $totalLlamados = $aula['llamados'];
        if ($totalClases == 0 && $totalLlamados == 0) {
            $operaciones = "
                <button class='btn btn-outline-danger borrar' 
                        name='{$aula['id']}' 
                        title='Borrar ($sector - $nombre)'>
                        <i class='fas fa-trash'></i>
                </button>
                <button class='btn btn-outline-warning editar' 
                        name='{$aula['id']}' 
                        title='Editar ($sector - $nombre)'>
                        <i class='far fa-edit'></i>
                </button>";
        } else {
            $operaciones = "
                <button class='btn btn-outline-info detalle' 
                        name='{$aula['id']}' 
                        title='Ver detalle ($sector - $nombre)'>
                        <i class='fas fa-eye'></i>
                </button>
                <button class='btn btn-outline-warning editar' 
                        name='{$aula['id']}' 
                        title='Editar ($sector - $nombre)'>
                        <i class='far fa-edit'></i>
                </button>";
        }
        $filas .= "
            <tr>
                <td class='align-middle'>{$sector}</td>
                <td class='align-middle'>{$nombre}</td>
                <td class='align-middle'>{$totalClases}</td>
                <td class='align-middle'>{$totalLlamados}</td>   
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>{$operaciones}</div>
                </td>
            </tr>";
    }
    $html = '
        <div class="table-responsive mt-4 mb-4">
            <table id="tablaBuscarAulas" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th title="Nombre del sector">Sector</th>
                        <th title="Nombre del aula">Nombre</th>
                        <th title="Cantidad total de clases asociadas">Total de clases</th>
                        <th title="Cantidad total de llamados asociados">Total de llamados</th>
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
