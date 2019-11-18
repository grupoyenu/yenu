<?php
require_once './app/principal/modelos/Constantes.php';
require_once './app/principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();

$controladorCursada = new ControladorCursada();
$controladorMesa = new ControladorMesa();

$resumenCursada = $controladorCursada->listarResumenInicial();
$resumenMesa = $controladorMesa->listarResumenInicial();

$filas = '';
if (gettype($resumenCursada) == "object") {
    while ($cursada = $resumenCursada->fetch_assoc()) {
        $filas .= "
            <tr>
                <td class='align-middle'>Horarios de cursada</td>
                <td class='align-middle'>" . utf8_encode($cursada['nombre']) . "</td>
                <td class='align-middle'>{$cursada['cantidad']}</td>
            </tr>";
    }
} else {
    $filas .= "
            <tr>
                <td class='align-middle'>Horarios de cursada</td>
                <td class='align-middle'>Sin información</td>
                <td class='align-middle'></td>
            </tr>";
}
/* REPORTE INICIAL PARA MESAS DE EXAMEN */
if (gettype($resumenMesa) == "object") {
    while ($mesa = $resumenMesa->fetch_assoc()) {
        $filas .= "
            <tr>
                <td class='align-middle'>Mesas de examen</td>
                <td class='align-middle'>" . utf8_encode($mesa['nombre']) . "</td>
                <td class='align-middle'>{$mesa['cantidad']}</td>
            </tr>";
    }
} else {
    $filas .= "
            <tr>
                <td class='align-middle'>Mesas de examen</td>
                <td class='align-middle'>Sin información</td>
                <td class='align-middle'></td>
            </tr>";
}

$tabla = '
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Módulo</th>
                    <th>Titulo</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>' . $filas . '</tbody>
        </table>    
    </div>';
?>
<div class="container-fluid" id="FormBuscarAsignatura">
    <div id="seccionSuperior" class="container mt-2 mb-2">
        <div class="row mt-sm-3 mb-4">
            <div class="col align-middle">
                <h3>INICIO</h3>
            </div>
        </div>
    </div>
    <div id="seccionCentral" class="container">
        <div class="card border-dark" title="Información resumida">
            <div class="card-header bg-dark text-white">RESUMEN DEL SISTEMA</div>
            <div class="card-body"> <?= $tabla; ?></div>
        </div>

    </div>
</div>