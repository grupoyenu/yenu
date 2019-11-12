<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$boton = "";
if (isset($_POST['codigo'])) {
    $codigo = $_POST['codigo'];
    $cuerpo = '
        <input type="hidden" name="codigo" id="codigo" value="' . $codigo . '">
        <input type="hidden" name="nombreAsignatura" id="nombreAsignatura" value="">
        <div class="form-row">
            <label for="anio" class="col-sm-2 col-form-label text-left">* Asignatura:</label>
            <div class="col">
                <select class="form-control mb-2" id="asignatura" name="asignatura" required></select>
            </div>
            <label for="anio" class="col-sm-2 col-form-label text-left">* Año:</label>
            <div class="col">
                <select class="form-control mb-2" id="anio" name="anio" title="Seleccione año">
                    <option value="1">1°</option>
                    <option value="2">2°</option>
                    <option value="3">3°</option>
                    <option value="4">4°</option>
                    <option value="5">5°</option>
                </select>
            </div>
        </div>';
    $boton = '<button type="submit" class="btn btn-success" 
                        id="btnAgregarAsignatura" title="Guardar datos">
                    <i class="far fa-save"></i> GUARDAR
                </button>';
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}
?>

<div class="container">
    <div class="form-row mt-4 mb-4">
        <div class="col text-left"><h4><i class="fas fa-graduation-cap"></i> AGREGAR ASIGNATURA</h4></div>
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
        <form id="formAgregarAsignatura" name="formAgregarAsignatura" method="POST">
            <div class="card border-dark">
                <div class="card-header bg-dark text-white">Complete el formulario y presione CREAR</div>
                <div class="card-body"><?= $cuerpo; ?></div>
            </div>
            <div class="form-row mt-2 mb-4">
                <div class="col text-right">
                    <?= $boton; ?>
                    <a href="carrera_buscar">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-search"></i> BUSCAR
                        </button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="./app/carreras/js/AgregarAsignatura.js"></script>