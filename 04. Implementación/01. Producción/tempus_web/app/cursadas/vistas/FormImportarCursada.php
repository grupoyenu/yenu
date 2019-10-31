<?php


if (isset($_FILES['fileCursadas'])) {

    $mensaje = ValidadorCursada::validarArchivo();
    if (!$mensaje) {
        // EL ARCHIVO CUMPLE CON LAS CONDICIONES PARA SER PROCESADO

        $nombre_temporal = $_FILES['fileCursadas']['tmp_name'];
        $registros = fopen($nombre_temporal, "r");
        rewind($registros);
        $filas = "";
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
            $filas .= "
                <tr>
                    <td title='$errores[0]' class='{$classCodigo}'>$registro[0]</td>
                    <td title='$errores[1]' class='{$classCarrera}'>$registro[1]</td>
                    <td title='$errores[2]' class='{$classAsignatura}'>$registro[2]</td>
                    <td title='$errores[3]' class='{$classAnio}'>$registro[3]</td>
                    <td title='$errores[4]' class='{$classLunes}'>$registro[4] $registro[5] $registro[6] $registro[7]</td>
                    <td title='$errores[5]' class='{$classMartes}'>$registro[8] $registro[9] $registro[10] $registro[11]</td>
                    <td title='$errores[6]' class='{$classMiercoles}'>$registro[12] $registro[13] $registro[14] $registro[15]</td>
                    <td title='$errores[7]' class='{$classJueves}'>$registro[16] $registro[17] $registro[18] $registro[19]</td>
                    <td title='$errores[8]' class='{$classViernes}'>$registro[20] $registro[21] $registro[22] $registro[23]</td>
                    <td title='$errores[9]' class='{$classSabado}'>$registro[24] $registro[25] $registro[26] $registro[27]</td>
                </tr>";
        }
        $cuerpo = '
            <div class="table-responsive mt-4">
                <table id="tablaImportarCursadas" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Carrera</th>
                            <th>Asignatura</th>
                            <th>Año</th>
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
        // EL ARCHIVO NO CUMPLIO ALGUNA DE LAS VALIDACIONES 
        $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
    }
} else {
    $mensaje = "No se obtuvo el archivo con horarios de cursada";
    $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}
?>
<div class="container-fluid" id="contenido">
    <div class="container">
        <div class="form-row mt-4 mb-4">
            <div class="col text-left"><h4><i class="far fa-clock"></i> IMPORTAR HORARIOS DE CURSADA</h4></div>
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
                <div class="card-header bg-dark text-white">Archivo con horarios de cursada procesado</div>
                <div class="card-body">
                    <?= $cuerpo; ?>
                </div>
            </div>
            <div class="form-row mt-2 mb-4">
                <div class="col text-right">
                    <a href="cursada_seleccionar">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-search"></i> VOLVER
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="./app/cursadas/js/ImportarCursada.js"></script>