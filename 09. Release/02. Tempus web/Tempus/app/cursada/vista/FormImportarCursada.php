<?php
/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

include_once '../../principal/vista/header.php';
require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\principal\controlador\ControladorHTML;
use app\cursada\modelo\ValidadorCursada;
use app\principal\modelo\AutoCargador;

AutoCargador::cargarModulos();

$boton = "";
if (isset($_FILES['fileCursadas'])) {
    $resultado = ValidadorCursada::validarArchivo();
    if ($resultado[0] == 2) {
        /* EL ARCHIVO CUMPLE CON LAS CONDICIONES PARA SER PROCESADO */
        $nombre_temporal = $_FILES['fileCursadas']['tmp_name'];
        $registros = fopen($nombre_temporal, "r");
        rewind($registros);
        $filas = "";
        $sesionCursadas = array();
        while (($registro = fgetcsv($registros, 2000, ";")) !== FALSE) {
            $errores = ValidadorCursada::validarRegistro($registro);
            $classCodigo = ($errores[0] == "Correcto") ? "" : "table-danger";
            $classCarrera = ($errores[1] == "Correcto") ? "" : "table-danger";
            $classAsignatura = ($errores[2] == "Correcto") ? "" : "table-danger";
            $classAnio = ($errores[3] == "Correcto") ? "" : "table-danger";
            $classLunes = ($errores[4] == "Correcto") ? "" : "table-danger";
            $classMartes = ($errores[5] == "Correcto") ? "" : "table-danger";
            $classMiercoles = ($errores[6] == "Correcto") ? "" : "table-danger";
            $classJueves = ($errores[7] == "Correcto") ? "" : "table-danger";
            $classViernes = ($errores[8] == "Correcto") ? "" : "table-danger";
            $classSabado = ($errores[9] == "Correcto") ? "" : "table-danger";
            $estado = ($errores[10]) ? "Correcta" : "Incorrecta";
            if ($errores[10]) {
                $sesionCursadas[] = $registro;
            }
            $filas .= "
                <tr>
                    <td title='$errores[0]' class='{$classCodigo}'>$registro[0]</td>
                    <td title='$errores[1]' class='{$classCarrera}'>" . utf8_encode($registro[1]) . "</td>
                    <td title='$errores[2]' class='{$classAsignatura}'>" . utf8_encode($registro[2]) . "</td>
                    <td title='$errores[3]' class='{$classAnio}'>$registro[3]</td>
                    <td title='$errores[4]' class='{$classLunes}'>$registro[4] $registro[5] $registro[6] " . utf8_encode($registro[7]) . "</td>
                    <td title='$errores[5]' class='{$classMartes}'>$registro[8] $registro[9] $registro[10] " . utf8_encode($registro[11]) . "</td>
                    <td title='$errores[6]' class='{$classMiercoles}'>$registro[12] $registro[13] $registro[14] " . utf8_encode($registro[15]) . "</td>
                    <td title='$errores[7]' class='{$classJueves}'>$registro[16] $registro[17] $registro[18] " . utf8_encode($registro[19]) . "</td>
                    <td title='$errores[8]' class='{$classViernes}'>$registro[20] $registro[21] $registro[22] " . utf8_encode($registro[23]) . "</td>
                    <td title='$errores[9]' class='{$classSabado}'>$registro[24] $registro[25] $registro[26] " . utf8_encode($registro[27]) . "</td>
                    <td style='display: none;'>$estado</td>
                </tr>";
        }
        $cuerpo = '
            <div class="table-responsive mt-4">
                <table id="tablaImportarCursadas" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th title="Código de la carrera">Código</th>
                            <th title="Nombre de la carrera">Carrera</th>
                            <th title="Nombre de la asignatura">Asignatura</th>
                            <th title="Año de la cursada">Año</th>
                            <th title="Clase del día Lunes">Lunes</th>
                            <th title="Clase del día Martes">Martes</th>
                            <th title="Clase del día Miercoles">Miercoles</th>
                            <th title="Clase del día Jueves">Jueves</th>
                            <th title="Clase del día Viernes">Viernes</th>
                            <th title="Clase del día Sabado">Sábado</th>
                            <th style="display: none;">Estado del registro</th>
                        </tr>
                    </thead>
                    <tbody>' . $filas . '</tbody>
                </table>
            </div>';
        $cantidad = count($sesionCursadas);
        if ($cantidad > 0) {
            $_SESSION['cursadas'] = $sesionCursadas;
            $boton = '
                <button type="submit" class="btn btn-success" 
                        id="btnImportarCursada" name="btnImportarCursada" 
                        title="Guardar datos (' . $cantidad . ')">
                        <i class="far fa-save"></i> GUARDAR
                </button>';
        }
    } else {
        /* EL ARCHIVO NO CUMPLIO ALGUNA DE LAS VALIDACIONES */
        $codigo = $resultado[0];
        $mensaje = $resultado[1];
        $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion($codigo, $mensaje);
    }
} else {
    $mensaje = "No se obtuvo el archivo con horarios de cursada";
    $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}
?>
<div class="container-fluid" id="contenido">
    <div class="container">
        <div class="form-row mt-4 mb-4">
            <div class="col text-left">
                <h4><i class="far fa-clock"></i> IMPORTAR HORARIOS DE CURSADA</h4>
            </div>
            <div class="col text-right">
                <a href="../../principal/vista/home.php">
                    <button class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-times"></i> CERRAR
                    </button>
                </a>
            </div>
        </div>
        <div id="seccionResultado"></div>
        <div id="seccionFormulario">
            <div class="card border-dark">
                <div class="card-header bg-dark text-white">Archivo con horarios de cursada procesado</div>
                <div class="card-body">
                    <?= $cuerpo; ?>
                </div>
            </div>
            <div class="form-row mt-2 mb-4">
                <div class="col text-right">
                    <?= $boton; ?>
                    <a href="FormSeleccionarCursada.php">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-arrow-left"></i> VOLVER
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bg-dark" style="opacity: 80%" id="ModalProcesando" tabindex="0" aria-labelledby="myModalLabel" data-backdrop="static" aria-hidden="false">
    <div class="modal-dialog modal-lg p-4">
        <div class="container p-4">
            <div class="container mt-4 mb-4">
                <div class="row mt-4 mb-4">
                    <div class="col text-center" style="font-size: 1.8rem;">
                        <i class="fas fa-spinner fa-3x fa-spin text-white"></i>
                    </div>
                </div>
                <div class="row mt-4 mb-4">
                    <div class="col text-center text-white" style="font-size: 1.4rem;">
                        <p><strong>Aguarde mientras se procesan los horarios de cursada</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../js/ImportarCursada.js"></script>
<?php
include_once '../../principal/vista/footer.php';
