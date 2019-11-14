<?php
/*
 * Controles que se realizan:
 *    1. Se verifica que el arreglo de cursadas este en sesion.
 *    2. Se verifica que la importacion devuelva un arreglo (Errores). Sino muestra error.
 *    3. Se verifica que el arreglo de errores no este vacio. Sino muestra tabla.
 */

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

session_start();

if (isset($_SESSION['cursadas'])) {
    $cursadas = $_SESSION['cursadas'];
    $controlador = new ControladorCursada();
    $resultado = $controlador->importar($cursadas);
    if (gettype($resultado) == "array") {
        $filas = $tabla = "";
        $mensaje = ControladorHTML::mostrarAlertaResultadoOperacion(2, $controlador->getDescripcion());
        if (!empty($errores)) {
            foreach ($resultado as $registro) {
                $filas .= "
                    <tr>
                        <td>$registro[0]</td>
                        <td>$registro[1]</td>
                        <td>$registro[2]</td>
                        <td>$registro[3]</td>
                        <td>$registro[4]</td>
                        <td>$registro[5]</td>
                        <td>$registro[6]</td>
                        <td>$registro[7]</td>
                        <td>$registro[8]</td>
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
        }
        $cuerpo = '<div class="form-row"> 
                    <div class="col">' . $mensaje . '</div>
                </div>' . $tabla;
    } else {
        $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion($resultado, $controlador->getDescripcion());
    }
    $_SESSION['cursadas'] = NULL;
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
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
                <div class="card-header bg-dark text-white">Resultado de la importación</div>
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