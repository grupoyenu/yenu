<?php

/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\mesa\controlador\ControladorMesa;
use app\principal\controlador\ControladorHTML;
use app\principal\modelo\AutoCargador;

AutoCargador::cargarModulos();

/* INICIALIZA LA SESION PARA GUARDAR LOG */

session_start();

/* INICIA EL CODIGO PROPIO DEL ARCHIVO */

if (isset($_POST['carrera']) && isset($_POST['asignatura'])) {
    $carrera = $_POST['carrera'];
    $asignatura = $_POST['asignatura'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $docente = $_POST['docente'];
    $modificada = $_POST['modificada'];

    $controlador = new ControladorMesa();
    $cantidad = $controlador->obtenerNumeroDeLlamados();
    if ($cantidad > 0) {
        $informe = $controlador->buscarParaInforme($carrera, $asignatura, $fecha, $hora, $docente, $modificada);
        if ($informe[0] == 2) {
            $mesasExamen = $informe[1];
            $filas = "";
            if ($cantidad == 1) {
                /* SE ARMA LA TABLA PARA UN SOLO LLAMADO */
                foreach ($mesasExamen as $mesa) {
                    $codigoCarrera = str_pad($mesa['codigoCarrera'], 3, "0", STR_PAD_LEFT);
                    $nombreCortoCarrera = $mesa['nombreCortoCarrera'];
                    $nombreLargoCarrera = $mesa['nombreLargoCarrera'];
                    $nombreCortoAsignatura = $mesa['nombreCortoAsignatura'];
                    $nombreLargoAsignatura = $mesa['nombreLargoAsignatura'];
                    $sectorAula = $mesa['sectorAulaPrimerLlamado'];
                    $nombreAula = $mesa['nombreAulaPrimerLlamado'];
                    $estadoLlamado = $mesa['estadoPrimerLlamado'];
                    $fechaLlamado = date_format(date_create($mesa['fechaPrimerLlamado']), 'd/m/Y');
                    $fechaEdicionLlamado = isset($mesa['fechaEdicionPrimerLlamado']) ? date_format(date_create($mesa['fechaEdicionPrimerLlamado']), 'd/m/Y H:m') : "";
                    $horaLlamado = substr($mesa['horaPrimerLlamado'], 0, 5);
                    $nombrePresidente = $mesa['nombrePresidente'];
                    $nombreVocal1 = $mesa['nombreVocalPrimero'];
                    $nombreVocal2 = $mesa['nombreVocalSegundo'];
                    $nombreSuplente = $mesa['nombreSuplente'];
                    $fechaCreacion = date_format(date_create($mesa['fechaCreacionMesaExamen']), 'd/m/Y');
                    $observacion = $mesa['observacionMesaExamen'];
                    $filas .= "
                        <tr>
                            <td style='display: none;'>{$codigoCarrera}</td>
                            <td style='display: none;'>{$nombreCortoCarrera}</td>
                            <td class='align-middle'>{$nombreLargoCarrera}</td>
                            <td style='display: none;'>{$nombreCortoAsignatura}</td>
                            <td class='align-middle'>{$nombreLargoAsignatura}</td>
                            <td class='align-middle'>{$nombrePresidente}</td>
                            <td class='align-middle'>{$nombreVocal1}</td>
                            <td class='align-middle'>{$nombreVocal2}</td>
                            <td class='align-middle'>{$nombreSuplente}</td>
                            <td class='align-middle'>{$fechaLlamado}</td>
                            <td class='align-middle'>{$horaLlamado}</td>
                            <td style='display: none;'>{$sectorAula}</td>
                            <td style='display: none;'>{$nombreAula}</td>
                            <td style='display: none;'>{$estadoLlamado}</td>
                            <td style='display: none;'>{$fechaEdicionLlamado}</td>
                            <td style='display: none;'>{$fechaCreacion}</td>
                            <td style='display: none;'>{$observacion}</td>
                        </tr>";
                }
                $cuerpo = '
                    <div class="table-responsive mt-4">
                        <table id="tablaInformeMesas" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="display: none;">Código de carrera</th>
                                    <th style="display: none;">Nombre corto de carrera</th>
                                    <th>Carrera</th>
                                    <th style="display: none;">Nombre corto de asignatura</th>
                                    <th>Asignatura</th>
                                    <th>Presidente</th>
                                    <th>Vocal 1</th>
                                    <th>Vocal 2</th>
                                    <th>Suplente</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th style="display: none;">Nombre sector</th>
                                    <th style="display: none;">Nombre aula</th>
                                    <th style="display: none;">Estado del llamado</th>
                                    <th style="display: none;">Fecha edicion del llamado</th>
                                    <th style="display: none;">Fecha creacion mesa</th>
                                    <th style="display: none;">Observacion</th>
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
                        <td class='align-middle'>" . utf8_encode($mesa['nombreCarrera']) . "</td>
                        <td class='align-middle'>" . utf8_encode($mesa['nombreAsignatura']) . "</td>
                        <td class='align-middle'>" . utf8_encode($mesa['nombrePresidente']) . "</td>
                        <td class='align-middle'>" . utf8_encode($mesa['nombreVocalPri']) . "</td>
                        <td class='align-middle'>" . utf8_encode($mesa['nombreVocalSeg']) . "</td>
                        <td class='align-middle'>" . utf8_encode($mesa['nombreSuplente']) . "</td>
                        <td class='align-middle'>{$fechaPrimero}</td>
                        <td style='display: none;'>{$horaPrimero}</td>
                        <td style='display: none;'>{$mesa['sectorPri']}</td>
                        <td style='display: none;'>" . utf8_encode($mesa['aulaPri']) . "</td>
                        <td style='display: none;'>{$edicionPrimero}</td>
                        <td class='align-middle'>{$fechaSegundo}</td>
                        <td style='display: none;'>{$horaSegundo}</td>
                        <td style='display: none;'>{$mesa['sectorSeg']}</td>
                        <td style='display: none;'>" . utf8_encode($mesa['aulaSeg']) . "</td>
                        <td style='display: none;'>{$edicionSegundo}</td>
                    </tr>";
                }
                $cuerpo = '
                <div class="table-responsive mt-4">
                    <table id="tablaInformeMesas" class="table table-bordered table-hover">
                        <thead>
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
            /* NO SE ENCONTRARON RESULTADO U OCURRIO UN ERROR AL CONSULTAR INFORME */
            $codigo = $informe[0];
            $mensaje = $informe[1];
            $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion($codigo, $mensaje);
        }
    } else {
        /* NO HAY CARGADAS MESAS DE EXAMEN U OCURRIO UN ERROR AL CONSULTAR NRO LLAMADOS */
        $codigo = ($cantidad == -1) ? 0 : 1;
        $mensaje = ($cantidad == -1) ? "No se pudo consultar la cantidad de llamados" : "No hay mesas cargadas";
        $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion($cantidad, $controlador->getDescripcion());
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}

$titulo = "Resultado de la búsqueda";
$resultado = ControladorHTML::mostrarCardResultadoBusqueda($titulo, $cuerpo);
echo $resultado;
