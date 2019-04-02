<div class="container">
    <h4 class="text-center p-4">INFORME MESA DE EXAMEN</h4>
    <div id="contenido">
        <form method="POST" id="formInformeMesas" name="formInformeMesas">
            <fieldset class="border p-2">
                <legend class="w-auto h6" title="Seleccione un archivo con mesas de examen">Información básica</legend>
                <div class="form-row">
                    <label for="" class="col-sm-2 col-form-label">Fecha:</label>
                    <div class="col">
                        <input class="form-control mb-2" type="text" id="txtAsignatura" name="txtAsignatura" placeholder="Ingrese nombre de asignatura" title="Búsqueda por campo vacio o nombre de la asignatura (Se aceptan letras, números, puntos y comas)">
                    </div>
                    <label for="" class="col-sm-2 col-form-label">Hora:</label>
                    <div class="col">
                        <input class="form-control mb-2" type="text" id="txtAsignatura" name="txtAsignatura" placeholder="Ingrese nombre de asignatura" title="Búsqueda por campo vacio o nombre de la asignatura (Se aceptan letras, números, puntos y comas)">
                    </div>
                </div>
                <div class="form-row">
                    <label for="" class="col-sm-2 col-form-label">Sector:</label>
                    <div class="col">
                        <input class="form-control mb-2" type="text" id="txtAsignatura" name="txtAsignatura" placeholder="Ingrese nombre de asignatura" title="Búsqueda por campo vacio o nombre de la asignatura (Se aceptan letras, números, puntos y comas)">
                    </div>
                    <label for="" class="col-sm-2 col-form-label">Modifica:</label>
                    <div class="col">
                        <input class="form-control mb-2" type="text" id="txtAsignatura" name="txtAsignatura" placeholder="Ingrese nombre de asignatura" title="Búsqueda por campo vacio o nombre de la asignatura (Se aceptan letras, números, puntos y comas)">
                    </div>
                </div>
            </fieldset>
            <div class="form-row">
                <div class="col text-center p-4">
                    <input type="submit" class="btn btn-success" 
                           id="btnSeleccionarMesa" name="btnSeleccionarMesa" 
                           title="Confirmar la búsqueda de mesas de examen"
                           value="Buscar">
                    <a href="home"><input type="button" class="btn btn-outline-secondary" 
                                          title="Cancelar la búsqueda de mesas de examen"
                                          value="Cancelar"></a>
                </div>
            </div>
        </form>
    </div>
    <br>
    <div id="resultado"></div>
</div>
<script type="text/javascript" src="./app/js/BuscarMesa.js"></script>