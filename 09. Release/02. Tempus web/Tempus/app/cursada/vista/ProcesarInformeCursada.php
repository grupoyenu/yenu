<?php

/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\cursada\controlador\ControladorCursada;
use app\principal\controlador\ControladorHTML;
use app\principal\modelo\AutoCargador;

AutoCargador::cargarModulos();

/* INICIALIZA LA SESION PARA GUARDAR LOG */

session_start();

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
    $resultado = $controlador->buscarParaInforme($carrera, $asignatura, $dia, $modificada, $operadorDesde, $desde, $operadorHasta, $hasta);
    if ($resultado[0] == 2) {
        $filas = "";
        $cursadas = $resultado[1];
        foreach ($cursadas as $cursada) {
            $idPlan = $cursada['idPlan'];
            $codigoCarrera = str_pad($cursada['codigoCarrera'], 3, "0", STR_PAD_LEFT);
            $anio = $cursada['anio'];
            $nombreCortoCarrera = $cursada['nombreCortoCarrera'];
            $nombreLargoCarrera = $cursada['nombreLargoCarrera'];
            $nombreCortoAsignatura = $cursada['nombreCortoAsignatura'];
            $nombreLargoAsignatura = $cursada['nombreLargoAsignatura'];

            /* DATOS DE LA CLASE PARA DIA LUNES */
            $horaInicioLunes = ($cursada['horaInicioLunes']) ? substr($cursada['horaInicioLunes'], 0, 5) : "";
            $horaFinLunes = ($cursada['horaFinLunes']) ? substr($cursada['horaFinLunes'], 0, 5) : "";
            $sectorAulaLunes = $cursada['sectorAulaLunes'];
            $nombreAulaLunes = $cursada['nombreAulaLunes'];
            $fechaEdicionLunes = isset($cursada['fechaEdicionLunes']) ? date_format(date_create($cursada['fechaEdicionLunes']), 'd/m/Y H:m') : "";
            $lunes = "$horaInicioLunes $horaFinLunes $sectorAulaLunes $nombreAulaLunes";

            /* DATOS DE LA CLASE PARA DIA MARTES */
            $horaInicioMartes = ($cursada['horaInicioMartes']) ? substr($cursada['horaInicioMartes'], 0, 5) : "";
            $horaFinMartes = ($cursada['horaFinMartes']) ? substr($cursada['horaFinMartes'], 0, 5) : "";
            $sectorAulaMartes = $cursada['sectorAulaMartes'];
            $nombreAulaMartes = $cursada['nombreAulaMartes'];
            $fechaEdicionMartes = isset($cursada['fechaEdicionMartes']) ? date_format(date_create($cursada['fechaEdicionMartes']), 'd/m/Y H:m') : "";
            $martes = "$horaInicioMartes $horaFinMartes $sectorAulaMartes $nombreAulaMartes";

            /* DATOS DE LA CLASE PARA DIA MIERCOLES */
            $horaInicioMiercoles = ($cursada['horaInicioMiercoles']) ? substr($cursada['horaInicioMiercoles'], 0, 5) : "";
            $horaFinMiercoles = ($cursada['horaFinMiercoles']) ? substr($cursada['horaFinMiercoles'], 0, 5) : "";
            $sectorAulaMiercoles = $cursada['sectorAulaMiercoles'];
            $nombreAulaMiercoles = $cursada['nombreAulaMiercoles'];
            $fechaEdicionMiercoles = isset($cursada['fechaEdicionMiercoles']) ? date_format(date_create($cursada['fechaEdicionMiercoles']), 'd/m/Y H:m') : "";
            $miercoles = "$horaInicioMiercoles $horaFinMiercoles $sectorAulaMiercoles $nombreAulaMiercoles";

            /* DATOS DE LA CLASE PARA DIA JUEVES */
            $horaInicioJueves = ($cursada['horaInicioJueves']) ? substr($cursada['horaInicioJueves'], 0, 5) : "";
            $horaFinJueves = ($cursada['horaFinJueves']) ? substr($cursada['horaFinJueves'], 0, 5) : "";
            $sectorAulaJueves = $cursada['sectorAulaJueves'];
            $nombreAulaJueves = $cursada['nombreAulaJueves'];
            $fechaEdicionJueves = isset($cursada['fechaEdicionJueves']) ? date_format(date_create($cursada['fechaEdicionJueves']), 'd/m/Y H:m') : "";
            $jueves = "$horaInicioJueves $horaFinJueves $sectorAulaJueves $nombreAulaJueves";

            /* DATOS DE LA CLASE PARA DIA VIERNES */
            $horaInicioViernes = ($cursada['horaInicioViernes']) ? substr($cursada['horaInicioViernes'], 0, 5) : "";
            $horaFinViernes = ($cursada['horaFinViernes']) ? substr($cursada['horaFinViernes'], 0, 5) : "";
            $sectorAulaViernes = $cursada['sectorAulaViernes'];
            $nombreAulaViernes = $cursada['nombreAulaViernes'];
            $fechaEdicionViernes = isset($cursada['fechaEdicionViernes']) ? date_format(date_create($cursada['fechaEdicionViernes']), 'd/m/Y H:m') : "";
            $viernes = "$horaInicioViernes $horaFinViernes $sectorAulaViernes $nombreAulaViernes";

            /* DATOS DE LA CLASE PARA DIA SABADO */
            $horaInicioSabado = ($cursada['horaInicioSabado']) ? substr($cursada['horaInicioSabado'], 0, 5) : "";
            $horaFinSabado = ($cursada['horaFinSabado']) ? substr($cursada['horaFinSabado'], 0, 5) : "";
            $sectorAulaSabado = $cursada['sectorAulaSabado'];
            $nombreAulaSabado = $cursada['nombreAulaSabado'];
            $fechaEdicionSabado = isset($cursada['fechaEdicionSabado']) ? date_format(date_create($cursada['fechaEdicionSabado']), 'd/m/Y H:m') : "";
            $sabado = "$horaInicioSabado $horaFinSabado $sectorAulaSabado $nombreAulaSabado";

            $filas .= "
                <tr>
                    <td class='align-middle col_codigo_carrera' style='display: none;'>{$codigoCarrera}</td>
                    <td class='align-middle col_nombre_largo_carrera' class='align-middle'>{$nombreLargoCarrera}</td>
                    <td class='align-middle col_nombre_largo_asignatura'>{$nombreLargoAsignatura}</td>
                    <td class='align-middle col_dia_lunes'>{$lunes}</td>
                    <td class='align-middle col_dia_martes'>{$martes}</td>
                    <td class='align-middle col_dia_miercoles'>{$miercoles}</td>
                    <td class='align-middle col_dia_jueves'>{$jueves}</td>
                    <td class='align-middle col_dia_viernes'>{$viernes}</td> 
                    <td class='align-middle col_dia_sabado'>{$sabado}</td>
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
