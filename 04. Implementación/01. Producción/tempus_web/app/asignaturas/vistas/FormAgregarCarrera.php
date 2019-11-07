<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

if (isset($_POST['idAsignatura']) && isset($_POST['nombre'])) {

    $contenido = '
        <input type="hidden" name="idAsignatura" id="idAsignatura">
        <input type="hidden" name="nombreAsignatura" value="nombreAsignatura">
        <div class="form-row">
            <label class="col-sm-2 col-form-label">Seleccionar: </label>
            <div class="col">
                <button class="btn btn-outline-info mb-2" 
                        title="Seleccionar carrera existente"
                        id="seleccionarCarrera" name="seleccionarCarrera">
                    <i class="far fa-hand-point-right"></i> CARRERA
                </button>
            </div>
            <label class="col-sm-2 col-form-label"></label>
            <div class="col"></div>
        </div>
        <div class="form-row">
            <label for="codigoCarrera" class="col-sm-2 col-form-label">* Código:</label>
            <div class="col">
                <input type="number" class="form-control mb-2" 
                       name="codigoCarrera" id="codigoCarrera"
                       placeholder="Codigo de carrera" required>
            </div>
            <label for="nombreCarrera" class="col-sm-2 col-form-label">* Carrera:</label>
            <div class="col">
                <input type="text" class="form-control mb-2" 
                       name="nombreCarrera" id="nombreCarrera"
                       placeholder="Nombre de carrera" required>
            </div>
        </div>
        <div class="form-row">
            <label for="anio" class="col-sm-2 col-form-label">* Año:</label>
            <div class="col">
                <select class="form-control mb-2" name="anio" id="anio">
                    <option value="1">1°</option>
                    <option value="2">2°</option>
                    <option value="3">3°</option>
                    <option value="4">4°</option>
                    <option value="5">5°</option>
                </select>
            </div>
            <label class="col-sm-2 col-form-label"></label>
            <div class="col"></div>
        </div>';
    $boton = '<button type="submit" class="btn btn-success" 
                    id="btnAgregarCarrera" title="Guardar datos">
                <i class="far fa-save"></i> GUARDAR
            </button>';
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $contenido = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
    $boton = "";
}
?>
<div class="container">
    <div class="form-row mt-4 mb-4">
        <div class="col text-left"><h4><i class="fas fa-book-open"></i> AGREGAR ASIGNATURA A CARRERA</h4></div>
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
        <form id="formCrearAula" name="formCrearAula" method="POST">
            <div class="card border-dark">
                <div class="card-header bg-dark text-white">Complete el formulario y presione GUARDAR</div>
                <div class="card-body"> <?= $contenido; ?> </div>
            </div>
            <div class="form-row"> 
                <div class="col text-right mt-2">
                    <?= $boton; ?>
                    <a href="asignatura_buscar">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-search"></i> BUSCAR
                        </button>
                    </a>
                </div>
            </div>
        </form>
    </div> 
    <div class="modal fade" id="modalSeleccionarCarrera" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-graduation-cap"></i> SELECCIONAR CARRERA</h4>
                </div>
                <div class="modal-body" id="cuerpoModalCarrera"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="./app/asignaturas/js/AgregarCarrera.js"></script>