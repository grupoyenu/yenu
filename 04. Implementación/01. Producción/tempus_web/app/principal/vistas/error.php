<?php
if (isset($_SESSION['tipoMensaje']) && $_SESSION['mensaje']) {
    $tipo = $_SESSION['tipoMensaje'];
    $mensaje = $_SESSION['mensaje'];
    $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion($tipo, $mensaje);
} else {
    $mensaje = 'Se detectó alguna irregularidad que no permitió continuar';
    $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion($tipo, $mensaje);
}
?>
<div class="container-fluid" id="contenido">
    <div class="container">
        <div class="form-row mt-4 mb-4">
            <div class="col text-left"><h4><i class="fas fa-info-circle"></i> INFORMACIÓN DEL SISTEMA</h4></div>
            <div class="col text-right"></div>
        </div>
        <div class="card border-dark">
            <div class="card-header bg-dark text-white"> DETALLE</div>
            <div class="card-body"><?= $cuerpo; ?></div>
        </div>
    </div>
</div>

