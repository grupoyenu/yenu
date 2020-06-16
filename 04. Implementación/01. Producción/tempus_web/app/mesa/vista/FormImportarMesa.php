<?php
/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

include_once '../../principal/vista/header.php';
require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\mesa\modelo\ValidadorMesa;
use app\principal\modelo\AutoCargador;

AutoCargador::cargarModulos();

$boton = "";
if (isset($_FILES['fileMesas'])) {
    $mensaje = ValidadorMesa::validarArchivo();
    if (!$mensaje) {
        $nombre_temporal = $_FILES['fileMesas']['tmp_name'];
        $registros = fopen($nombre_temporal, "r");
        $fila = fgetcsv($registros, 2000, ";");
        $columnas = count($fila);
        rewind($registros);
        $sesionMesas = array();
        $nroLlamados = 1;
        $filas = "";
        if ($columnas == 9) {
            // SE PROCESA EL ARCHIVO PARA UN SOLO LLAMADO
            while (($registro = fgetcsv($registros, 2000, ";")) !== FALSE) {
                $errores = ValidadorMesa::validarRegistroUnLlamado($registro);
                $classCodigo = ($errores[0] == "Correcto") ? "" : "table-danger";
                $classCarrera = ($errores[1] == "Correcto") ? "" : "table-danger";
                $classAsignatura = ($errores[2] == "Correcto") ? "" : "table-danger";
                $classPresidente = ($errores[3] == "Correcto") ? "" : "table-danger";
                $classVocal1 = ($errores[4] == "Correcto") ? "" : "table-danger";
                $classVocal2 = ($errores[5] == "Correcto") ? "" : "table-danger";
                $classSuplente = ($errores[6] == "Correcto") ? "" : "table-danger";
                $classPrimero = ($errores[7] == "Correcta") ? "" : "table-danger";
                $classHora = ($errores[8] == "Correcta") ? "" : "table-danger";
                $estado = ($errores[9]) ? "Correcta" : "Incorrecta";
                if ($errores[9]) {
                    $sesionMesas[] = $registro;
                }
                $filas .= "
                <tr>
                    <td title='$errores[0]' class='{$classCodigo}'>$registro[0]</td>
                    <td title='$errores[1]' class='{$classCarrera}'>" . utf8_encode($registro[1]) . "</td>
                    <td title='$errores[2]' class='{$classAsignatura}'>" . utf8_encode($registro[2]) . "</td>
                    <td title='$errores[3]' class='{$classPresidente}'>" . utf8_encode($registro[3]) . "</td>
                    <td title='$errores[4]' class='{$classVocal1}'>" . utf8_encode($registro[4]) . "</td>
                    <td title='$errores[5]' class='{$classVocal2}'>" . utf8_encode($registro[5]) . "</td>
                    <td title='$errores[6]' class='{$classSuplente}'>" . utf8_encode($registro[6]) . "</td>
                    <td title='$errores[7]' class='{$classPrimero}'>$registro[7]</td>
                    <td title='$errores[8]' class='{$classHora}'>$registro[8]</td>
                    <td style='display: none;'>$estado</td>
                </tr>";
            }
            $cuerpo = '
                <div class="table-responsive mt-4">
                    <table id="tablaImportarMesas" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th title="Código de la carrera">Código</th>
                                <th title="Nombre de la carrera">Carrera</th>
                                <th title="Nombre de la asignatura">Asignatura</th>
                                <th title="Nombre del docente presidente del tribunal">Presidente</th>
                                <th title="Nombre del docente vocal primero del tribunal">Vocal 1</th>
                                <th title="Nombre del docente vocal segundo del tribunal">Vocal 2</th>
                                <th title="Nombre del docente suplente del tribunal">Suplente</th>
                                <th title="Fecha de la mesa de examen">Fecha</th>
                                <th title="Hora de la mesa de examen">Hora</th>
                                <th style="display: none;">Estado del registro</th>
                            </tr>
                        </thead>
                        <tbody>' . $filas . '</tbody>
                    </table>
                </div>';
        } else {
            // SE PROCESA EL ARCHIVO PARA DOS LLAMADOS
            $nroLlamados = 2;
            while (($registro = fgetcsv($registros, 2000, ";")) !== FALSE) {
                $errores = ValidadorMesa::validarRegistroDosLlamados($registro);
                $classCodigo = ($errores[0] == "Correcto") ? "" : "table-danger";
                $classCarrera = ($errores[1] == "Correcto") ? "" : "table-danger";
                $classAsignatura = ($errores[2] == "Correcto") ? "" : "table-danger";
                $classPresidente = ($errores[3] == "Correcto") ? "" : "table-danger";
                $classVocal1 = ($errores[4] == "Correcto") ? "" : "table-danger";
                $classVocal2 = ($errores[5] == "Correcto") ? "" : "table-danger";
                $classSuplente = ($errores[6] == "Correcto") ? "" : "table-danger";
                $classPrimero = ($errores[7] == "Correcta") ? "" : "table-danger";
                $classSegundo = ($errores[8] == "Correcta") ? "" : "table-danger";
                $classHora = ($errores[9] == "Correcta") ? "" : "table-danger";
                $estado = ($errores[10]) ? "Correcta" : "Incorrecta";
                if ($errores[10]) {
                    $sesionMesas[] = $registro;
                }
                $filas .= "
                    <tr>
                        <td title='$errores[0]' class='{$classCodigo}'>$registro[0]</td>
                        <td title='$errores[1]' class='{$classCarrera}'>" . utf8_encode($registro[1]) . "</td>
                        <td title='$errores[2]' class='{$classAsignatura}'>" . utf8_encode($registro[2]) . "</td>
                        <td title='$errores[3]' class='{$classPresidente}'>" . utf8_encode($registro[3]) . "</td>
                        <td title='$errores[4]' class='{$classVocal1}'>" . utf8_encode($registro[4]) . "</td>
                        <td title='$errores[5]' class='{$classVocal2}'>" . utf8_encode($registro[5]) . "</td>
                        <td title='$errores[6]' class='{$classSuplente}'>" . utf8_encode($registro[6]) . "</td>
                        <td title='$errores[7]' class='{$classPrimero}'>$registro[7]</td>
                        <td title='$errores[8]' class='{$classSegundo}'>$registro[8]</td>
                        <td title='$errores[9]' class='{$classHora}'>$registro[9]</td>
                        <td style='display: none;'>{$estado}</td>
                    </tr>";
            }
            $cuerpo = '
                <div class="table-responsive mt-4">
                    <table id="tablaImportarMesas" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th title="Código de la carrera">Código</th>
                                <th title="Nombre de la carrera">Carrera</th>
                                <th title="Nombre de la asignatura">Asignatura</th>
                                <th title="Nombre del docente presidente del tribunal">Presidente</th>
                                <th title="Nombre del docente vocal primero del tribunal">Vocal 1</th>
                                <th title="Nombre del docente vocal segundo del tribunal">Vocal 2</th>
                                <th title="Nombre del docente suplente del tribunal">Suplente</th>
                                <th title="Fecha del primer llamado para la mesa de examen">Llamado 1</th>
                                <th title="Fecha del segundo llamado para la mesa de examen">Llamado 2</th>
                                <th title="Hora para la mesa de examen">Hora</th>
                                <th style="display: none;">Estado</th>
                            </tr>
                        </thead>
                        <tbody>' . $filas . '</tbody>
                    </table>
                </div>';
        }
        $cantidad = count($sesionMesas);
        if ($cantidad > 0) {
            $_SESSION['nroLlamados'] = $nroLlamados;
            $_SESSION['mesas'] = $sesionMesas;
            $boton = '
                <button type="submit" class="btn btn-success" 
                        id="btnImportarMesa" name="btnImportarMesa" 
                        title="Guardar datos (' . $cantidad . ')">
                    <i class="far fa-save"></i> GUARDAR
                </button>';
        }
    } else {
        // EL ARCHIVO NO CUMPLIO ALGUNA DE LAS VALIDACIONES 
        $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
    }
} else {
    $mensaje = "No se obtuvo el archivo con mesas de examen";
    $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}
?>
<div class="container-fluid" id="contenido">
    <div class="container">
        <div class="form-row mt-4 mb-4">
            <div class="col text-left">
                <h4><i class="far fa-clock"></i> IMPORTAR MESAS DE EXAMEN</h4>
            </div>
            <div class="col text-right">
                <a href="principal_home">
                    <button class="btn btn-sm btn-outline-secondary"> 
                        <i class="fas fa-times"></i> CERRAR
                    </button>
                </a>
            </div>
        </div>
        <div id="seccionResultado"></div>
        <div id="seccionFormulario">
            <div class="card border-dark">
                <div class="card-header bg-dark text-white">Archivo con mesas de examen procesado</div>
                <div class="card-body">
                    <?= $cuerpo; ?>
                </div>
            </div>
            <div class="form-row mt-2 mb-4">
                <div class="col text-right">
                    <?= $boton; ?>
                    <a href="FormSeleccionarMesa.php">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-search"></i> VOLVER
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalProcesando" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content bg-dark">
            <h1 class="text-white text-center"><i class="fas fa-spinner fa-spin"></i></h1>
        </div>
    </div>
</div>
<script type="text/javascript" src="../js/ImportarMesa.js"></script>