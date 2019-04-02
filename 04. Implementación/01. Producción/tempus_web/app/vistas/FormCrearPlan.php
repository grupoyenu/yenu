<?php

$controlador = new ControladorPlan();
$carreras = $controlador->buscarCarreras();

?>


<div class="container">
    <h4 class="text-center p-4">CREAR PLAN</h4>
    <div id="resultado"></div>
    <div id="contenido">
        <form id="formCrearPlan" name="formCrearPlan" method="POST">
            <fieldset class="border p-2">
                <legend class="w-auto h6" title="Complete la información obligatoria de la carrera">Información de carrera</legend>
                <div class="form-row">
                    <label for="codigoCarrera" class="col-sm-2 col-form-label" title="Campo obligatorio">* Código:</label>
                    <div class="col">
                        <input 
                            type="number" class="form-control mb-2"
                            id="codigoCarrera" name="codigoCarrera" 
                            min="1" max="999" minlength="1" maxlength="3"
                            placeholder="Ingrese código de carrera"
                            title="Código de la carrera (1-999)"
                            required>
                    </div>
                    <label for="nombreCarrera" class="col-sm-2 col-form-label">* Nombre:</label>
                    <div class="col">
                        <input type="text" class="form-control mb-2"
                               id="nombreCarrera" name="nombreCarrera"
                               pattern="[A-Za-zÁÉÍÓÚÑáéíóúñ. ]{10,255}"
                               minlength="5" maxlength="255"
                               placeholder="Ingrese nombre de carrera"
                               title="Nombre de la carrera (A-Z, a-z, acentos, espacio, punto, 10-255)" 
                               required>
                    </div>
                    <div class="col-xs-3 text-right">
                        <button type="button" id="seleccionarCarrera" name="seleccionarCarrera" class="btn btn-outline-info" title="Seleccionar una asignatura">
                            <img src="./lib/img/tempus_seleccionar.png" width="20" height="20"/>
                        </button>
                    </div>
                </div>
            </fieldset>
            <br>
            <fieldset class="border p-2">
                <legend class="w-auto h6" title="Complete la informacion obligatoria de asignatura">Información de asignatura</legend>
                <div class="form-row">
                    <label for="selectAnio" class="col-sm-2 col-form-label" title="Campo obligatorio">* Año:</label>
                    <div class="col">
                        <select class="form-control mb-2" id="selectAnio" name="selectAnio" title="Seleccione año">
                            <option value="1">1ro</option>
                            <option value="2">2do</option>
                            <option value="3">3ro</option>
                            <option value="4">4to</option>
                            <option value="5">5to</option>
                        </select>
                    </div>
                    <label for="" class="col-sm-2 col-form-label" title="Campo obligatorio">* Nombre:</label>
                    <div class="col">
                        <input type="text" class="form-control mb-2"
                               id="nombreAsignatura" name="nombreAsignatura"
                               pattern="[A-Za-zÑÁÉÍÓÚñáéíóú0123456789,. ]{5,255}"
                               minlength="5" maxlength="255"
                               placeholder="Ingrese nombre de asignatura"
                               title="Nombre de la asignatura (A-Z, a-z, 0-9, punto, espacio, 5-255)"
                               required>
                    </div>
                    <div class="col-xs-3 text-right">
                        <button type="button" id="seleccionarAsignatura" name="seleccionarAsignatura" class="btn btn-outline-info" title="Seleccionar una asignatura">
                            <img src="./lib/img/tempus_seleccionar.png" width="20" height="20"/>
                        </button>
                    </div>
                </div>
            </fieldset>
            <div class="form-row"> 
                <div class="col text-center p-4">
                    <input type="submit" class="btn btn-success" 
                           id="btnCrearPlan" name="btnCrearPlan"
                           title="Confirmar la creación del nuevo plan"
                           value="Crear">
                    <a href="home"><input type="button" class="btn btn-outline-secondary" 
                                          title="Cancelar la creación del nuevo plan"
                                          value="Cancelar"></a>
                </div>
            </div>
        </form>
    </div>  
</div>
<?php include_once './app/vistas/ModalCarreras.php'; ?>
<script type="text/javascript" src="./app/js/CrearPlan.js"></script>