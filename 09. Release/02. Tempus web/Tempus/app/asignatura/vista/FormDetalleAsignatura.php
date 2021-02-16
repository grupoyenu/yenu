<?php
/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\asignatura\modelo\Asignatura;
use app\principal\controlador\ControladorHTML;
use app\principal\modelo\AutoCargador;

AutoCargador::cargarModulos();

$titulo = "";
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $asignatura = new Asignatura($id);
    $obtdat = $asignatura->obtenerPorIdentificador();

    if ($obtdat[0] == 2) {
        $nombreCorto = $asignatura->getNombreCorto();
        $nombreLargo = $asignatura->getNombreLargo();
        $fechaCreacion = date_format(date_create($asignatura->getFechaCreacion()), 'd/m/Y');
        $horaCreacion = date_format(date_create($asignatura->getFechaCreacion()), 'H:m');

        $obtcar = $asignatura->obtenerCarreras();

        $formulario = '
            <div class="card border-dark mb-2 mt-2">
                <div class="card-header bg-dark text-white">Información básica</div>
                <div class="card-body">
                    <div class="form-row">
                        <label for="sector" class="col-sm-2 col-form-label">Nombre corto:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"
                                   value="' . $nombreCorto . '"
                                   placeholder="Nombre corto"
                                   title="Nombre corto de la asignatura" disabled>
                        </div>
                        <label for="nombre" class="col-sm-2 col-form-label">Nombre largo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"
                                   value="' . $nombreLargo . '"
                                   title = "Nombre largo de la asignatura" disabled>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="sector" class="col-sm-2 col-form-label">Fecha de creación:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"
                                   value="' . $fechaCreacion . '"
                                   title="Fecha de creación" disabled>
                        </div>
                        <label for="nombre" class="col-sm-2 col-form-label">Hora de creación:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"
                                   value="' . $horaCreacion . '"
                                   title = "Hora de creación" disabled>
                        </div>
                    </div>
                </div>
            </div>';

        if ($obtcar[0] == 2) {

            $carreras = $asignatura->getCarreras();
            $titulo = "$nombreCorto - $nombreLargo";
            $filas = "";
            foreach ($carreras as $carrera) {
                $codigo = str_pad($carrera['id'], 3, "0", STR_PAD_LEFT);
                $nombreCortoCarrera = $carrera['nombreCorto'];
                $nombreLargoCarrera = $carrera['nombreLargo'];
                $anio = $carrera['anio'];
                $filas .= "
                    <tr>
                        <td class='align-middle'>{$anio}</td>
                        <td class='align-middle'>{$codigo}</td>
                        <td class='align-middle'>{$nombreCortoCarrera}</td>
                        <td class='align-middle'>{$nombreLargoCarrera}</td>
                    </tr>";
            }

            $formulario .= '
                <div class="card border-dark mb-2 mt-2">
                    <div class="card-header bg-dark text-white">Carreras asociadas</div>
                    <div class="card-body">
                        <div class="table-responsive mt-4 mb-4">
                            <table id="tablaDetalleAsignatura" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th title = "Año de la asignatura en la carrera">Año</th>
                                        <th title = "Código de la carrera">Código de carrera</th>
                                        <th title = "Nombre corto de la carrera">Nombre corto de carrera</th>
                                        <th title = "Nombre largo de la carrera">Nombre largo de carrera</th>
                                    </tr>
                                </thead>
                                <tbody>' . $filas . '</tbody>
                            </table>
                        </div>
                    </div>
                </div>';
        }
    } else {
        $mensaje = "No se obtuvo la información de la asignatura";
        $contenido = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $contenido = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}
?>
<div class="container">
    <div class="form-row mt-4 mb-4">
        <div class="col text-left">
            <h4><i class="fas fa-book-open"></i> DETALLE DE ASIGNATURA</h4>
        </div>
        <div class="col text-right">
            <a href="../../principal/vista/home.php">
                <button class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-times"></i> CERRAR
                </button>
            </a>
        </div>
    </div>
    <div id="seccionFormulario">
        <?= $formulario; ?>
        <div class="form-row">
            <div class="col text-right mt-2">
                <a href="FormBuscarAsignatura.php">
                    <button type="button" class="btn btn-outline-info">
                        <i class="fas fa-search"></i> BUSCAR
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../js/DetalleAsignatura.js"></script>