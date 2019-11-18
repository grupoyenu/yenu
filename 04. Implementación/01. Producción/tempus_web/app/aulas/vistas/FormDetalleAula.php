<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
if (isset($_POST['idAula']) && isset($_POST['sector']) && isset($_POST['nombre'])) {
    $sector = $_POST['sector'];
    $nombre = $_POST['nombre'];
    $lugar = $sector . " " . $nombre . ": ";
    $controladorAula = new ControladorAula();
    $controladorMesa = new ControladorMesa();
    $clases = $controladorAula->listarHorariosClase($_POST['idAula']);
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
        $cuerpoCursada = ControladorHTML::mostrarAlertaResultadoOperacion($clases, $controladorAula->getDescripcion());
    }
    $mesas = $controladorAula->listarMesasExamen($_POST['idAula']);
    $llamados = $controladorMesa->obtenerCantidadLlamados();
    if (($llamados > 0) && gettype($mesas) == "object") {
        $filas = "";
        if ($llamados == 1) {
            while ($mesa = $mesas->fetch_assoc()) {
                $fechaLlamado = isset($mesa['fechaPri']) ? date_format(date_create($mesa['fechaPri']), 'd/m/Y') . " " . substr($mesa['horaPri'], 0, 5) : "";
                $filas .= "
                    <tr>
                        <td class='align-middle'>" . str_pad($mesa['codigoCarrera'], 3, "0", STR_PAD_LEFT) . "</td>
                        <td class='align-middle'>" . utf8_encode($mesa['nombreCarrera']) . "</td>
                        <td class='align-middle'>" . utf8_encode($mesa['nombreAsignatura']) . "</td>
                        <td class='align-middle'>{$fechaLlamado}</td>
                    </tr>";
            }
            $cuerpoMesa = '
                <div class="table-responsive mt-4">
                    <table id="tablaMesasAula" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th title="Código de carrera">Código</th>
                                <th title="Nombre de carrera">Carrera</th>
                                <th title="Nombre de asignatura">Asignatura</th>
                                <th title="Fecha y hora de la mesa de examen">Llamado 1</th>
                            </tr>
                        </thead>
                        <tbody>' . $filas . '</tbody>
                    </table>
                </div>';
        } else {
            while ($mesa = $mesas->fetch_assoc()) {
                $fechaLlamado1 = isset($mesa['fechaPri']) ? date_format(date_create($mesa['fechaPri']), 'd/m/Y') . " " . substr($mesa['horaPri'], 0, 5) : "";
                $fechaLlamado2 = isset($mesa['fechaSeg']) ? date_format(date_create($mesa['fechaSeg']), 'd/m/Y') . " " . substr($mesa['horaSeg'], 0, 5) : "";
                $filas .= "
                    <tr>
                        <td class='align-middle'>" . str_pad($mesa['codigoCarrera'], 3, "0", STR_PAD_LEFT) . "</td>
                        <td class='align-middle'>" . utf8_encode($mesa['nombreCarrera']) . "</td>
                        <td class='align-middle'>" . utf8_encode($mesa['nombreAsignatura']) . "</td>
                        <td class='align-middle'>{$fechaLlamado1}</td>
                        <td class='align-middle'>{$fechaLlamado2}</td>
                    </tr>";
            }
            $cuerpoMesa = '
                <div class="table-responsive mt-4">
                    <table id="tablaMesasAula" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th title="Código de carrera">Código</th>
                                <th title="Nombre de carrera">Carrera</th>
                                <th title="Nombre de asignatura">Asignatura</th>
                                <th title="Fecha y hora del primer llamado">Llamado 1</th>
                                <th title="Fecha y hora del segundo llamado">Llamado 2</th>
                            </tr>
                        </thead>
                        <tbody>' . $filas . '</tbody>
                    </table>
                </div>';
        }
    } else {
        if ($llamados == 0) {
            $mensaje = "No se pudieron consultar la cantidad de llamados";
            $cuerpoMesa = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
        } else {
            $cuerpoMesa = ControladorHTML::mostrarAlertaResultadoOperacion($mesas, $controladorAula->getDescripcion());
        }
    }
} else {
    $lugar = "";
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
            <div class="card-header bg-dark text-white"><?= $lugar; ?> Horarios de cursada </div>
            <div class="card-body"><?= $cuerpoCursada; ?></div>
        </div>
        <br>
        <div class="card border-dark">
            <div class="card-header bg-dark text-white"><?= $lugar; ?> Mesas de examen</div>
            <div class="card-body"><?= $cuerpoMesa; ?></div>
        </div>
        <div class="form-row mt-2 mb-4">
            <div class="col text-right">
                <a href="aula_buscar">
                    <button type="button" class="btn btn-outline-info">
                        <i class="fas fa-search"></i> BUSCAR
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="./app/aulas/js/DetalleAula.js"></script>
