<?php
if (isset($_FILES['fileMesas'])) {
    $mensaje = ValidadorMesa::validarArchivo();
    if (!$mensaje) {

        $nombre_temporal = $_FILES['fileMesas']['tmp_name'];
        $registros = fopen($nombre_temporal, "r");
        rewind($registros);
        $filas = "";
        
        
        
    } else {
        // EL ARCHIVO NO CUMPLIO ALGUNA DE LAS VALIDACIONES 
        $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
    }
} else {
    $mensaje = "No se obtuvo el archivo con mesas de examen";
    $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}
?>
<div class="container-fluid" id="contenido">
    <div class="container">
        <div class="form-row mt-4 mb-4">
            <div class="col text-left"><h4><i class="far fa-clock"></i> IMPORTAR MESAS DE EXAMEN</h4></div>
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
            <div class="card border-dark">
                <div class="card-header bg-dark text-white">Archivo con mesas de examen procesado</div>
                <div class="card-body">
                    <?= $cuerpo; ?>
                </div>
            </div>
            <div class="form-row mt-2 mb-4">
                <div class="col text-right">
                    <a href="mesa_seleccionar">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-search"></i> VOLVER
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="./app/mesas/js/ImportarMesa.js"></script>