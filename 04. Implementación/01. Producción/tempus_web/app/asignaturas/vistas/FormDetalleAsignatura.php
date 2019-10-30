<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

if (isset($_POST['idAsignatura']) && isset($_POST['nombre'])) {
    $id = $_POST['idAsignatura'];
    $nombre = $_POST['nombre'];
    $controlador = new ControladorAsignaturas();
    $carreras = $controlador->listarCarrerasAsignatura($id);
    if (gettype($carreras) == "object") {
        $titulo = "Información detallada de asignatura: " . $nombre;
        while ($carrera = $carreras->fetch_assoc()) {
            $filas .= "
                <tr>
                    <td class='align-middle'>" . str_pad($carrera['idcarrera'], 3, "0", STR_PAD_LEFT) . "</td>
                    <td class='align-middle'>" . utf8_encode($carrera['nombre']) . "</td>
                    <td class='align-middle'>{$carrera['anio']}</td>
                </tr>";
        }
        $contenido = '
            <div class="table-responsive">
                <table id="tablaDetalleAsignatura" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Código</th>
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
    $titulo = "Información detallada de asignatura";
    $mensaje = "No se obtuvo la información desde el formulario";
    $contenido = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}
?>
<div class="container">
    <div class="form-row mt-4 mb-4">
        <div class="col text-left"><h4><i class="fas fa-book-open"></i> DETALLE DE ASIGNATURA</h4></div>
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
            <a href="asignatura_buscar">
                <button type="button" class="btn btn-outline-info">
                    <i class="fas fa-search"></i> BUSCAR
                </button>
            </a>
        </div>
    </div>
</div>
<script type="text/javascript" src="./app/asignaturas/js/DetalleAsignatura.js"></script>