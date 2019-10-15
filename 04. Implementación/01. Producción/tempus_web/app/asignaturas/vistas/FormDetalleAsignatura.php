<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();
$contenido = $filas = "";
$titulo = "Información detalla de asignatura";
if (isset($_POST['idAsignatura']) && isset($_POST['nombre'])) {
    $id = $_POST['idAsignatura'];
    $nombre = $_POST['nombre'];
    $asignatura = new Asignatura($id);
    $obtenerCarreras = $asignatura->obtenerCarreras();
    if ($obtenerCarreras == 2) {
        $titulo .= ": " . $nombre;
        $carreras = $asignatura->getCarreras();
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
                    <thead class="thead-dark">
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
        
    }
} else {
    $contenido = '<div class="alert alert-danger text-center" role="alert"> 
                    <i class="fas fa-exclamation-triangle"></i> 
                    <strong>No se obtuvo la informaciòn desde el formulario</strong>
                </div>';
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
    <div id="seccionResultado"></div>
    <div id="seccionFormulario">
        <form id="formDetalleAsignatura" name="formDetalleAsignatura" method="POST">
            <div class="card">
                <div class="card-header"><?= $titulo; ?></div>
                <div class="card-body"><?= $contenido; ?></div>
            </div>
        </form>
    </div>
</div>
