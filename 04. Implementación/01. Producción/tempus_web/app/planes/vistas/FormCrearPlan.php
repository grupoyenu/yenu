<div class="container-fluid" id="FormCrearPlan">
    <div id="seccionSuperior" class="container mt-2 mb-2">
        <div class="row mt-sm-3 mb-4">
            <div class="col align-middle">
                <h3>CREAR PLAN</h3>
            </div>
            <div class="col text-right">
                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                    <a class="btn btn-outline-danger" href="principal_home" title="Cancelar"><img data-feather="x-circle"/></a>
                </div>
            </div>
        </div>
        <form name="formBuscarAula" id="formBuscarAsignatura" method="POST">
            <div class="card text-center">
                <div class="card-header text-left">Complete el formulario y presione CREAR</div>
                <div class="card-body">
                    <div class="form-row text-left mb-4">
                        <div class="col text-right">
                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a class="btn btn-outline-dark" href="#" id="btnSeleccionarCarrera" title="Seleccionar carrera">CARRERA</a>
                                <a class="btn btn-outline-dark" href="#" id="btnSeleccionarAsignatura" title="Seleccionar asignatura">ASIGNATURA</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="codigoCarrera" class="col-sm-2 col-form-label text-left" title="Campo obligatorio">* Código de carrera:</label>
                        <div class="col">
                            <input type="number" class="form-control mb-2"
                                   id="codigoCarrera" name="codigoCarrera" 
                                   min="1" max="999" minlength="1" maxlength="3"
                                   placeholder="Código de carrera"
                                   title="Código de la carrera (1-999)"
                                   required>
                        </div>
                        <label for="nombreCarrera" class="col-sm-2 col-form-label text-left">* Nombre de carrera:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"
                                   id="nombreCarrera" name="nombreCarrera"
                                   pattern="[A-Za-zÁÉÍÓÚÑáéíóúñ. ]{10,255}"
                                   minlength="5" maxlength="255"
                                   placeholder="Nombre de carrera"
                                   title="Nombre de la carrera (A-Z, a-z, acentos, espacio, punto, 10-255)" 
                                   required>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="" class="col-sm-2 col-form-label text-left" title="Campo obligatorio">* Asignatura:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"
                                   id="nombreAsignatura" name="nombreAsignatura"
                                   pattern="[A-Za-zÑÁÉÍÓÚñáéíóú0123456789,. ]{5,255}"
                                   minlength="5" maxlength="255"
                                   placeholder="Nombre de asignatura"
                                   title="Nombre de la asignatura (A-Z, a-z, 0-9, punto, espacio, 5-255)"
                                   required>
                        </div>
                        <label for="selectAnio" class="col-sm-2 col-form-label text-left" title="Campo obligatorio">* Año:</label>
                        <div class="col">
                            <select class="form-control mb-2" id="selectAnio" name="selectAnio" title="Seleccione año">
                                <option value="1">1°</option>
                                <option value="2">2°</option>
                                <option value="3">3°</option>
                                <option value="4">4°</option>
                                <option value="5">5°</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <br>
    <div id="seccionCentral" class="container mt-2 mb-2"></div>
    <br>
    <div id="seccionInferior" class="container mt-2 mb-2"></div>
</div>

<script type="text/javascript" src="./app/planes/js/CrearPlan.js"></script>