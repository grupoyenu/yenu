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
    $obtcar = $asignatura->obtenerCarreras();
    if (($obtdat[0] == 2) && ($obtcar[0] == 2)) {
        $nombreCorto = $asignatura->getNombreCorto();
        $nombreLargo = $asignatura->getNombreLargo();
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

        $contenido = '
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
            </div>';
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
    <div class="card border-dark">
        <div class="card-header bg-dark text-white">Detalle <?= $titulo; ?></div>
        <div class="card-body"><?= $contenido; ?></div>
    </div>
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
<script type="text/javascript" src="../js/DetalleAsignatura.js"></script>