<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

session_start();

if (isset($_SESSION['mesas']) && isset($_SESSION['nroLlamados'])) {
    $nroLlamados = $_SESSION['nroLlamados'];
    $mesasExamen = $_SESSION['mesas'];
    Log::escribirLineaError("Nro Llamados: " . $nroLlamados);
    $controlador = new ControladorMesa();
    $resultado = $controlador->importar($mesasExamen, $nroLlamados);
    if (gettype($resultado) == "array") {
        $filas = $tabla = "";
        $mensaje = ControladorHTML::mostrarAlertaResultadoOperacion(2, $controlador->getDescripcion());
        if (!empty($errores)) {
            if ($nroLlamados == 1) {
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
                    <table id="tablaImportarMesas" class="table table-bordered table-hover">
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
                    <td>$registro[9]</td>
                </tr>";
                }
                $tabla = '
                <div class="table-responsive mt-4">
                    <table id="tablaImportarMesas" class="table table-bordered table-hover">
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
                                <th style="display: none;">Estado</th>
                            </tr>
                        </thead>
                        <tbody>' . $filas . '</tbody>
                    </table>
                </div>';
            }
        }
        $cuerpo = '<div class="form-row"> 
                    <div class="col">' . $mensaje . '</div>
                </div>' . $tabla;
    } else {
        $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion($resultado, $controlador->getDescripcion());
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
            <div class="col text-left"><h4><i class="far fa-clock"></i> IMPORTAR MESAS DE EXAMEN</h4></div>
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
                    <a href="mesa_seleccionar">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-search"></i> VOLVER
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>