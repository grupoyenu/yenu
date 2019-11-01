<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
if (isset($_POST['idAula'])) {
    $controlador = new ControladorAula();
    $clases = $controlador->listarHorariosClase($_POST['idAula']);
    if (gettype($clases) == "object") {
        $filas = "";
        while ($clase = $clases->fetch_assoc()) {
            $filas .= "
            <tr>
                <td class='align-middle'>" . utf8_encode($clase['nombreDia']) . "</td>
                <td class='align-middle'>" . utf8_encode($clase['nombreAsignatura']) . "</td>
                <td class='align-middle'>{$clase['desde']}</td>
                <td class='align-middle'>{$clase['hasta']}</td>
            </tr>";
        }
        $cuerpoCursada = '
        <div class="table-responsive mt-4">
            <table id="tablaCursadasAula" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Día</th>
                        <th>Asignatura</th>
                        <th>Hora de inicio</th>
                        <th>Hora de fin</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
    } else {
        $cuerpoCursada = ControladorHTML::mostrarAlertaResultadoBusqueda($clases, $controlador->getDescripcion());
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpoCursada = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}
?>

<div class="container">
    <div class="form-row mt-4 mb-4">
        <div class="col text-left"><h4><i class="fas fa-chalkboard"></i> DETALLE AULA</h4></div>
        <div class="col text-right">
            <a href="principal_home">
                <button class="btn btn-sm btn-outline-secondary"> 
                    <i class="fas fa-times"></i> CERRAR
                </button>
            </a>
        </div>
    </div>
    <div id="seccionFormulario">
        <div class="card border-dark">
            <div class="card-header bg-dark text-white">Horarios de cursada </div>
            <div class="card-body"><?= $cuerpoCursada; ?></div>
        </div>
    </div>
</div>
<script type="text/javascript" src="./app/aulas/js/DetalleAula.js"></script>
