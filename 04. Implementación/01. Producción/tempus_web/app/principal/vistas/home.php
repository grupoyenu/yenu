<?php
require_once './app/principal/modelos/Constantes.php';
require_once './app/principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();

$controladorCursada = new ControladorCursada();
$resumenCursada = $controladorCursada->listarResumenInicial();

if (gettype($resumenCursada) == "object") {
    $cuerpoCursada = '';
    while ($cursada = $resumenCursada->fetch_assoc()) {
        $cuerpoCursada .= '
            <div class="form-row">
                <label for="nombre" class="col-sm-8">' . $cursada['nombre'] . ':</label>
                <div class="col"> <p>' . $cursada['cantidad'] . '</p></div>
            </div>';
    }
}
?>

<div class="container-fluid" id="FormBuscarAsignatura">
    <div id="seccionSuperior" class="container mt-2 mb-2">
        <div class="row mt-sm-3 mb-4">
            <div class="col align-middle">
                <h3>INICIO</h3>
            </div>
        </div>
    </div>
    <div id="seccionCentral" class="container mt-2 mb-2">


    </div>
    <div id="seccionInferior" class="container mt-2 mb-2">
        <div class="form-row">
            <div class="col">
                <div class="card border-dark">
                    <div class="card-header bg-dark text-white"><i class="far fa-clock"></i> CURSADAS</div>
                    <div class="card-body"> <?= $cuerpoCursada; ?></div>
                </div>
            </div>
            <div class="col">
                <div class="card border-dark">
                    <div class="card-header bg-dark text-white"><i class="far fa-calendar-alt"></i> MESAS DE EXAMEN</div>
                    <div class="card-body"></div>
                </div>
            </div>
        </div>
    </div>
</div>