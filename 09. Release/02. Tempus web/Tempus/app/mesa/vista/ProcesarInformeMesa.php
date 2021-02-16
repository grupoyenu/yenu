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
                foreach ($mesasExamen as $mesa) {
                    $codigoCarrera = str_pad($mesa['codigoCarrera'], 3, "0", STR_PAD_LEFT);
                    $nombreCortoCarrera = $mesa['nombreCortoCarrera'];
                    $nombreLargoCarrera = $mesa['nombreLargoCarrera'];
                    $nombreCortoAsignatura = $mesa['nombreCortoAsignatura'];
                    $nombreLargoAsignatura = $mesa['nombreLargoAsignatura'];
                    $nombrePresidente = $mesa['nombrePresidente'];
                    $nombreVocal1 = $mesa['nombreVocalPrimero'];
                    $nombreVocal2 = $mesa['nombreVocalSegundo'];
                    $nombreSuplente = $mesa['nombreSuplente'];

                    /* DATOS DEL PRIMER LLAMADO */
                    $sectorAulaPrimer = $mesa['sectorAulaPrimerLlamado'];
                    $nombreAulaPrimer = $mesa['nombreAulaPrimerLlamado'];
                    $estadoPrimerLlamado = $mesa['estadoPrimerLlamado'];
                    $fechaPrimerLlamado = $mesa['fechaPrimerLlamado'] ? date_format(date_create($mesa['fechaPrimerLlamado']), 'd/m/Y') : '';
                    $fechaEdicionPrimerLlamado = isset($mesa['fechaEdicionPrimerLlamado']) ? date_format(date_create($mesa['fechaEdicionPrimerLlamado']), 'd/m/Y H:m') : "";
                    $horaPrimerLlamado = substr($mesa['horaPrimerLlamado'], 0, 5);

                    /* DATOS DEL SEGUNDO LLAMADO */
                    $sectorAulaSegundo = $mesa['sectorAulaSegundoLlamado'];
                    $nombreAulaSegundo = $mesa['nombreAulaSegundoLlamado'];
                    $estadoSegundoLlamado = $mesa['estadoSegundoLlamado'];
                    $fechaSegundoLlamado = $mesa['fechaSegundoLlamado'] ? date_format(date_create($mesa['fechaSegundoLlamado']), 'd/m/Y') : '';
                    $fechaEdicionSegundoLlamado = isset($mesa['fechaEdicionSegundoLlamado']) ? date_format(date_create($mesa['fechaEdicionSegundoLlamado']), 'd/m/Y H:m') : "";
                    $horaSegundoLlamado = substr($mesa['horaSegundoLlamado'], 0, 5);

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
                            <td class='align-middle'>{$fechaPrimerLlamado}</td>
                            <td class='align-middle'>{$horaPrimerLlamado}</td>
                            <td style='display: none;'>{$sectorAulaPrimer}</td>
                            <td style='display: none;'>{$nombreAulaPrimer}</td>
                            <td style='display: none;'>{$estadoPrimerLlamado}</td>
                            <td style='display: none;'>{$fechaEdicionPrimerLlamado}</td>
                            <td class='align-middle'>{$fechaSegundoLlamado}</td>
                            <td class='align-middle'>{$horaSegundoLlamado}</td>
                            <td style='display: none;'>{$sectorAulaSegundo}</td>
                            <td style='display: none;'>{$nombreAulaSegundo}</td>
                            <td style='display: none;'>{$estadoSegundoLlamado}</td>
                            <td style='display: none;'>{$fechaEdicionSegundoLlamado}</td>
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
                                <th>Fecha 1°</th>
                                <th>Hora 1°</th>
                                <th style="display: none;">Nombre sector 1°</th>
                                <th style="display: none;">Nombre aula 1°</th>
                                <th style="display: none;">Estado 1°</th>
                                <th style="display: none;">Fecha edicion 1°</th>
                                <th>Fecha 2°</th>
                                <th>Hora 2°</th>
                                <th style="display: none;">Nombre sector 2°</th>
                                <th style="display: none;">Nombre aula 2°</th>
                                <th style="display: none;">Estado 2°</th>
                                <th style="display: none;">Fecha edicion 2°</th>
                                <th style="display: none;">Fecha creacion mesa</th>
                                <th style="display: none;">Observacion</th>
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
        $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion($codigo, $mensaje);
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}

$titulo = "Resultado de la búsqueda";
$resultado = ControladorHTML::mostrarCardResultadoBusqueda($titulo, $cuerpo);
echo $resultado;
