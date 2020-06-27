<?php
/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\carrera\modelo\Carrera;
use app\principal\controlador\ControladorHTML;
use app\principal\modelo\AutoCargador;

AutoCargador::cargarModulos();

$titulo = "";
if (isset($_POST['codigo'])) {
    $id = $_POST['codigo'];
    $carrera = new Carrera($id);
    $obtcar = $carrera->obtenerPorIdentificador();
    $obtasi = $carrera->obtenerAsignaturas();
    if (($obtcar[0] == 2) && ($obtasi[0] == 2)) {
        $nombreCorto = $carrera->getNombreCorto();
        $nombreLargo = $carrera->getNombreLargo();
        $asignaturas = $carrera->getAsignaturas();
        $titulo = "$nombreCorto - $nombreLargo";
        $filas = "";
        foreach ($asignaturas as $asignatura) {
            $nombreCortoAsignatura = $asignatura['nombreCorto'];
            $nombreLargoAsignatura = $asignatura['nombreLargo'];
            $anio = $asignatura['anio'];
            $filas .= "
                <tr>
                    <td class='align-middle'>{$anio}</td>
                    <td class='align-middle'>{$nombreCortoAsignatura}</td>
                    <td class='align-middle'>{$nombreLargoAsignatura}</td>
                </tr>";
        }
        $contenido = '
            <div class="table-responsive mt-4 mb-4">
                <table id="tablaDetalleCarrera" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th  title = "Año de la asignatura en la carrera">Año</th>
                            <th  title = "Nombre corto de la asignatura">Nombre corto de asignatura</th>
                            <th  title = "Nombre largo de la asignatura">Nombre largo de asignatura</th>
                        </tr>
                    </thead>
                    <tbody>' . $filas . '</tbody>
                </table>
            </div>';
    } else {
        $mensaje = "No se obtuvo la información de la carrera";
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
            <h4><i class="fas fa-graduation-cap"></i> DETALLE DE CARRERA</h4>
        </div>
        <div class="col text-right">
            <a href="../../principal/vista/home.php">
                <button class="btn btn-sm btn-outline-secondary"
                        title="Cerrar página actual"> 
                    <i class="fas fa-times"></i> CERRAR
                </button>
            </a>
        </div>
    </div>
    <div class="card border-dark">
        <div class="card-header bg-dark text-white" 
             title="Información detallada"><?= $titulo; ?></div>
        <div class="card-body"><?= $contenido; ?></div>
    </div>
    <div class="form-row"> 
        <div class="col text-right mt-2 mb-4">
            <a href="FormBuscarCarrera.php" title="Ir al formulario de búsqueda">
                <button type="button" class="btn btn-outline-info">
                    <i class="fas fa-search"></i> BUSCAR
                </button>
            </a>
        </div>
    </div>
</div>
<script type="text/javascript" src="../js/DetalleCarrera.js"></script>
