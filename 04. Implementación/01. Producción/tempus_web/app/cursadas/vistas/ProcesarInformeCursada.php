<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

if (isset($_POST['carrera']) && isset($_POST['asignatura'])) {
    $carrera = $_POST['carrera'];
    $asignatura = $_POST['asignatura'];
    $dia = $_POST['dia'];
    $operadorDesde = $_POST['operadorDesde'];
    $desde = $_POST['desde'];
    $operadorHasta = $_POST['operadorHasta'];
    $hasta = $_POST['hasta'];
    $modificada = $_POST['modificada'];
    $controlador = new ControladorCursada();
    $cursadas = $controlador->listarInforme($carrera, $asignatura, $dia, $modificada, $operadorDesde, $desde, $operadorHasta, $hasta);
    if (gettype($cursadas) == "object") {
        $filas = "";
        while ($cursada = $cursadas->fetch_assoc()) {
            $lunes = ($cursada['idClase1']) ? $cursada['desde1'] . " " . $cursada['hasta1'] . " " . $cursada['sector1'] . " " . $cursada['aula1'] : "";
            $martes = ($cursada['idClase2']) ? $cursada['desde2'] . " " . $cursada['hasta2'] . " " . $cursada['sector2'] . " " . $cursada['aula2'] : "";
            $miercoles = ($cursada['idClase3']) ? $cursada['desde3'] . " " . $cursada['hasta3'] . " " . $cursada['sector3'] . " " . $cursada['aula3'] : "";
            $jueves = ($cursada['idClase4']) ? $cursada['desde4'] . " " . $cursada['hasta4'] . " " . $cursada['sector4'] . " " . $cursada['aula4'] : "";
            $viernes = ($cursada['idClase5']) ? $cursada['desde5'] . " " . $cursada['hasta5'] . " " . $cursada['sector5'] . " " . $cursada['aula5'] : "";
            $sabado = ($cursada['idClase6']) ? $cursada['desde6'] . " " . $cursada['hasta6'] . " " . $cursada['sector6'] . " " . $cursada['aula6'] : "";
            $filas .= "
            <tr>
                <td style='display: none;' class='align-middle'>{$cursada['idCarrera']}</td>
                <td class='align-middle'>" . utf8_encode($cursada['nombreCarrera']) . "</td>
                <td class='align-middle'>" . utf8_encode($cursada['nombreAsignatura']) . "</td>
                <td class='align-middle'>{$lunes}</td>
                <td class='align-middle'>{$martes}</td>
                <td class='align-middle'>{$miercoles}</td>
                <td class='align-middle'>{$jueves}</td>
                <td class='align-middle'>{$viernes}</td>
                <td class='align-middle'>{$sabado}</td>
            </tr>";
        }
        $cuerpo = '
        <div class="table-responsive mt-4">
            <table id="tablaInformeCursadas" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th style="display: none;">Código carrera</th>
                        <th>Nombre carrera</th>
                        <th>Asignatura</th>
                        <th>Lunes</th>
                        <th>Martes</th>
                        <th>Miercoles</th>
                        <th>Jueves</th>
                        <th>Viernes</th>
                        <th>Sábado</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
    } else {
        $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion($cursadas, $controlador->getDescripcion());
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}

$titulo = "Resultado de la búsqueda";
$resultado = ControladorHTML::mostrarCardResultadoBusqueda($titulo, $cuerpo);
echo $resultado;
