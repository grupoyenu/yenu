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

if (isset($_SESSION['mesas']) && isset($_SESSION['nroLlamados'])) {
    $nroLlamados = $_SESSION['nroLlamados'];
    $mesasExamen = $_SESSION['mesas'];
    $controlador = new ControladorMesa();
    $resultado = $controlador->importar($mesasExamen, $nroLlamados);
    if ($resultado[0] == 2) {
        $mensaje = "Proceso de importación finalizado correctamente";
        $filas = $tabla = "";
        if ((gettype($resultado[1]) == "array") && !empty($resultado[1])) {
            $errores = $resultado[1];
            $mensaje .= ". Cantidad de mesas no creadas : " . count($errores);
            if ($nroLlamados == 1) {
                foreach ($errores as $registro) {
                    $filas .= "
                        <tr>
                            <td>$registro[0]</td>
                            <td>" . utf8_encode($registro[1]) . "</td>
                            <td>" . utf8_encode($registro[2]) . "</td>
                            <td>" . utf8_encode($registro[3]) . "</td>
                            <td>" . utf8_encode($registro[4]) . "</td>
                            <td>" . utf8_encode($registro[5]) . "</td>
                            <td>" . utf8_encode($registro[6]) . "</td>
                            <td>$registro[7]</td>
                            <td>$registro[8]</td>
                        </tr>";
                }
                $tabla = '
                    <div class="table-responsive mt-4">
                        <table id="tablaImportarMesasErrores" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Carrera</th>
                                    <th>Asignatura</th>
                                    <th>Presidente</th>
                                    <th>Vocal 1</th>
                                    <th>Vocal 2</th>
                                    <th>Suplente</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                </tr>
                            </thead>
                            <tbody>' . $filas . '</tbody>
                        </table>
                    </div>';
            } else {
                foreach ($errores as $registro) {
                    $filas .= "
                        <tr>
                            <td>$registro[0]</td>
                            <td>" . utf8_encode($registro[1]) . "</td>
                            <td>" . utf8_encode($registro[2]) . "</td>
                            <td>" . utf8_encode($registro[3]) . "</td>
                            <td>" . utf8_encode($registro[4]) . "</td>
                            <td>" . utf8_encode($registro[5]) . "</td>
                            <td>" . utf8_encode($registro[6]) . "</td>
                            <td>$registro[7]</td>
                            <td>$registro[8]</td>
                            <td>$registro[9]</td>
                        </tr>";
                }
                $tabla = '
                    <div class="table-responsive mt-4">
                        <table id="tablaImportarMesasErrores" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Carrera</th>
                                    <th>Asignatura</th>
                                    <th>Presidente</th>
                                    <th>Vocal 1</th>
                                    <th>Vocal 2</th>
                                    <th>Suplente</th>
                                    <th>Llamado 1</th>
                                    <th>Llamado 2</th>
                                    <th>Hora</th>
                                </tr>
                            </thead>
                            <tbody>' . $filas . '</tbody>
                        </table>
                    </div>';
            }
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
    $_SESSION['nroLlamados'] = NULL;
    $_SESSION['mesas'] = NULL;
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
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
                    <a href="FormSeleccionarMesa.php">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-arrow-left"></i> VOLVER
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>