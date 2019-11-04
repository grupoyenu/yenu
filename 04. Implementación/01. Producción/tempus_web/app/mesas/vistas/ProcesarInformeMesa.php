<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

if (isset($_POST['carrera']) && isset($_POST['asignatura'])) {
    $carrera = $_POST['carrera'];
    $asignatura = $_POST['asignatura'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $modificada = $_POST['modificada'];
    $controlador = new ControladorMesa();

    $cantidad = $controlador->obtenerCantidadLlamados();
    if ($cantidad > 0) {
        $mesas = $controlador->listarInforme($carrera, $asignatura, $fecha, $hora, $modificada);
        if (gettype($mesas) == "resource") {

            if ($cantidad == 1) {
                // CARGA LA TABLA PARA UN SOLO LLAMADO EN EL TURNO DE MESA
                while ($mesa = $mesas->fetch_assoc()) {
                    $fechaLlamado = isset($mesa['fechaPri']) ? date_format(date_create($mesa['fechaPri']), 'd/m/Y') : "";
                    $hora = substr($mesa['horaPri'], 0, 5);
                    $fechaModificacion = isset($mesa['fechaModPri']) ? date_format(date_create($mesa['fechaModPri']), 'd/m/Y H:m') : "";
                    $filas .= "
                    <tr>
                        <td style='display: none;'>" . str_pad($mesa['codigoCarrera'], 3, "0", STR_PAD_LEFT) . "</td>
                        <td class='align-middle'>{$mesa['nombreCarrera']}</td>
                        <td class='align-middle'>{$mesa['nombreAsignatura']}</td>
                        <td class='align-middle'>{$mesa['nombrePresidente']}</td>
                        <td class='align-middle'>{$mesa['nombreVocalPri']}</td>
                        <td class='align-middle'>{$mesa['nombreVocalSeg']}</td>
                        <td class='align-middle'>{$mesa['nombreSuplente']}</td>
                        <td class='align-middle'>{$fechaLlamado}</td>
                        <td class='align-middle'>{$hora}</td>
                        <td style='display: none;'>{$mesa['sectorPri']}</td>
                        <td style='display: none;'>{$mesa['aulaPri']}</td>
                        <td style='display: none;'>{$fechaModificacion}</td>
                    </tr>";
                }
                $cuerpo = '
                <div class="table-responsive mt-4">
                    <table id="tablaInformeMesas" class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th style="display: none;">Código</th>
                                <th>Carrera</th>
                                <th>Asignatura</th>
                                <th>Presidente</th>
                                <th>Vocal 1</th>
                                <th>Vocal 2</th>
                                <th>Suplente</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th style="display: none;">Sector</th>
                                <th style="display: none;">Aula</th>
                                <th style="display: none;">Modificación</th>
                            </tr>
                        </thead>
                        <tbody>' . $filas . '</tbody>
                    </table>
                </div>';
            } else {
                while ($mesa = $mesas->fetch_assoc()) {
                    $fechaPrimero = isset($mesa['fechaPri']) ? date_format(date_create($mesa['fechaPri']), 'd/m/Y') : "";
                    $horaPrimero = substr($mesa['horaPri'], 0, 5);
                    $edicionPrimero = isset($mesa['fechaModPri']) ? date_format(date_create($mesa['fechaModPri']), 'd/m/Y H:m') : "";
                    $fechaSegundo = isset($mesa['fechaSeg']) ? date_format(date_create($mesa['fechaSeg']), 'd/m/Y') : "";
                    $horaSegundo = substr($mesa['horaSeg'], 0, 5);
                    $edicionSegundo = isset($mesa['fechaModSeg']) ? date_format(date_create($mesa['fechaModSeg']), 'd/m/Y H:m') : "";
                    $filas .= "
                    <tr>
                        <td style='display: none;'>" . str_pad($mesa['codigoCarrera'], 3, "0", STR_PAD_LEFT) . "</td>
                        <td class='align-middle'>{$mesa['nombreCarrera']}</td>
                        <td class='align-middle'>{$mesa['nombreAsignatura']}</td>
                        <td class='align-middle'>{$mesa['nombrePresidente']}</td>
                        <td class='align-middle'>{$mesa['nombreVocalPri']}</td>
                        <td class='align-middle'>{$mesa['nombreVocalSeg']}</td>
                        <td class='align-middle'>{$mesa['nombreSuplente']}</td>
                        <td class='align-middle'>{$fechaPrimero}</td>
                        <td style='display: none;'>{$horaPrimero}</td>
                        <td style='display: none;'>{$mesa['sectorPri']}</td>
                        <td style='display: none;'>{$mesa['aulaPri']}</td>
                        <td style='display: none;'>{$edicionPrimero}</td>
                        <td class='align-middle'>{$fechaSegundo}</td>
                        <td style='display: none;'>{$horaSegundo}</td>
                        <td style='display: none;'>{$mesa['sectorSeg']}</td>
                        <td style='display: none;'>{$mesa['aulaSeg']}</td>
                        <td style='display: none;'>{$edicionSegundo}</td>
                    </tr>";
                }
                $cuerpo = '
                <div class="table-responsive mt-4">
                    <table id="tablaBuscarMesas" class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th style="display: none;">Código</th>
                                <th>Carrera</th>
                                <th>Asignatura</th>
                                <th>Presidente</th>
                                <th>Vocal 1</th>
                                <th>Vocal 2</th>
                                <th>Suplente</th>
                                <th>Primero</th>
                                <th style="display: none;">Hora</th>
                                <th style="display: none;">Sector</th>
                                <th style="display: none;">Aula</th>
                                <th style="display: none;">Modificación</th>
                                <th>Segundo</th>
                                <th style="display: none;">Hora</th>
                                <th style="display: none;">Sector</th>
                                <th style="display: none;">Aula</th>
                                <th style="display: none;">Modificación</th>
                            </tr>
                        </thead>
                        <tbody>' . $filas . '</tbody>
                    </table>
                </div>';
            }
        } else {
            $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion($cantidad, $controlador->getDescripcion());
        }
    } else {
        $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion($cantidad, $controlador->getDescripcion());
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}

$titulo = "Resultado de la búsqueda";
$resultado = ControladorHTML::mostrarCardResultadoBusqueda($titulo, $contenido);
echo $resultado;
