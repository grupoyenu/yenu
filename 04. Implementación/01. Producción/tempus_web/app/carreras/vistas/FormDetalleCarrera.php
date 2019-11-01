<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
if (isset($_POST['codigo']) && isset($_POST['nombre'])) {
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $controlador = new ControladorCarreras();
    $asignaturas = $controlador->listarAsignaturasDeCarrera($codigo);
    if (gettype($asignaturas) == "object") {
        $titulo = "Información detallada de carrera: " . $nombre;
        $filas = "";
        while ($asignatura = $asignaturas->fetch_assoc()) {
            $filas .= "
                <tr>
                    <td class='align-middle'>" . utf8_encode($asignatura['nombre']) . "</td>
                    <td class='align-middle'>{$asignatura['anio']}</td>
                </tr>";
        }
        $contenido = '
            <div class="table-responsive">
                <table id="tablaDetalleCarrera" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Año</th>
                        </tr>
                    </thead>
                    <tbody>' . $filas . '</tbody>
                </table>
            </div>';
    } else {
        $contenido = ControladorHTML::mostrarAlertaResultadoOperacion(0, $controlador->getDescripcion());
    }
} else {
    $titulo = "Información detallada de carrera";
    $mensaje = "No se obtuvo la información desde el formulario";
    $contenido = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}
?>
<div class="container">
    <div class="form-row mt-4 mb-4">
        <div class="col text-left"><h4><i class="fas fa-graduation-cap"></i> DETALLE DE CARRERA</h4></div>
        <div class="col text-right">
            <a href="principal_home">
                <button class="btn btn-sm btn-outline-secondary"> 
                    <i class="fas fa-times"></i> CERRAR
                </button>
            </a>
        </div>
    </div>
    <div class="card border-dark">
        <div class="card-header bg-dark text-white"><?= $titulo; ?></div>
        <div class="card-body"><?= $contenido; ?></div>
    </div>
    <div class="form-row"> 
        <div class="col text-right mt-2">
            <a href="carrera_buscar">
                <button type="button" class="btn btn-outline-info">
                    <i class="fas fa-search"></i> BUSCAR
                </button>
            </a>
        </div>
    </div>
</div>
<script type="text/javascript" src="./app/carreras/js/DetalleCarrera.js"></script>
