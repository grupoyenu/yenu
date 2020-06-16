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

if (isset($_SESSION['cursadas'])) {
    $cursadas = $_SESSION['cursadas'];
    $controlador = new ControladorCursada();
    $resultado = $controlador->importar($cursadas);
    if ($resultado[0] == 2) {
        $mensaje = "Proceso de importación finalizado correctamente";
        $filas = $tabla = "";
        if ((gettype($resultado[1]) == "array") && !empty($resultado[1])) {
            $mensaje .= ". Cantidad de horarios de cursada no creados : " . count($errores);
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
            $tabla = '
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
                            </tr>
                        </thead>
                        <tbody>' . $filas . '</tbody>
                    </table>
                </div>';
        }
        $proceso = ControladorHTML::mostrarAlertaResultadoOperacion(2, $mensaje);
        $cuerpo = " 
            <div class='form-row'> 
                <div class='col'>$proceso</div>
            </div>
            <div class='form-row'>$tabla</div>";
    } else {
        $codigo = $resultado[0];
        $mensaje = $resultado[1];
        $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion($codigo, $mensaje);
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
                <div class="card-header bg-dark text-white">Resultado de la importación</div>
                <div class="card-body">
                    <?= $cuerpo; ?>
                </div>
            </div>
            <div class="form-row mt-2 mb-4">
                <div class="col text-right">
                    <a href="FormSeleccionarCursada.php">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-search"></i> VOLVER
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>