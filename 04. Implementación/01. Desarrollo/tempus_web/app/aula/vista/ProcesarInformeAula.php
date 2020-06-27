<?php

/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\aula\controlador\ControladorAula;
use app\principal\controlador\ControladorHTML;
use app\principal\modelo\AutoCargador;

AutoCargador::cargarModulos();

if (isset($_POST['modulo'])) {
    $controlador = new ControladorAula();
    $modulo = $_POST['modulo'];
    if ($modulo == "CUR") {
        $disponible = $_POST['disponibleCursada'];
        $dia = $_POST['dia'];
        $horaInicio = $_POST['desde'];
        $horaFin = $_POST['hasta'];
        $resultado = $controlador->buscarParaInformeCursada($disponible, $dia, $horaInicio, $horaFin);
    } else {
        $disponible = $_POST['disponibleMesa'];
        $fecha = $_POST['fecha'];
        $hora = $_POST['horaMesa'];
        $resultado = $controlador->buscarParaInformeMesa($disponible, $fecha, $hora);
    }
    if ($resultado[0] == 2) {
        $aulas = $resultado[1];
        $filas = "";
        foreach ($aulas as $aula) {
            $sector = $aula['sector'];
            $nombre = $aula['nombre'];
            $filas .= "
            <tr>
                <td class='align-middle'>{$sector}</td>
                <td class='align-middle'>{$nombre}</td>
            </tr>";
        }
        $cuerpo = '
            <div class="table-responsive mt-4">
                <table id="tablaInformeAulas" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th title="Nombre del sector">Sector</th>
                            <th title="Nombre del aula">Nombre</th>
                        </tr>
                    </thead>
                    <tbody>' . $filas . '</tbody>
                </table>
            </div>';
    } else {
        $codigo = $resultado[0];
        $mensaje = $resultado[1];
        $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion($codigo, $mensaje);
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}

$titulo = "Resultado de la búsqueda";
$resultado = ControladorHTML::mostrarCardResultadoBusqueda($titulo, $cuerpo);
echo $resultado;

