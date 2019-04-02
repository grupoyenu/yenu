<div class="container" id="FormBuscarMesa">
    <h4 class="text-center p-4">BUSCAR MESA DE EXAMEN</h4>
    <div id="contenido">
        <form method="POST" id="formBuscarMesas" name="formBuscarMesas">
            <fieldset class="border p-2">
                <legend class="w-auto h6" title="Complete el formulario de creación">Información básica</legend>
                <div class="form-row">
                    <label for="txtAsignatura" class="col-sm-2 col-form-label">Nombre de asignatura:</label>
                    <div class="col">
                        <input type="text" class="form-control mb-2"  
                               id="txtAsignatura" name="txtAsignatura"
                               pattern="[A-Za-zÁÉÍÓÚáéíóú0123456789 ]{0,100}"
                               maxlength="100"
                               placeholder="Ingrese nombre de asignatura" 
                               title="Búsqueda por campo vacio o nombre de la asignatura">
                    </div>
                </div>
            </fieldset>
            <div class="row">
                <div class="col">
                    <div class="text-center">
                        <br><input type="submit" class="btn btn-success"
                                   id="btnBuscarMesas" name="btnBuscarMesas"
                                   value="Buscar">
                        <a href="home">
                            <input type="button" class="btn btn-outline-secondary" 
                                              title="Cancelar la búsqueda de mesa de examen"
                                              value="Cancelar">
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <br>
    <div id="resultado"></div>
    <script type="text/javascript" src="./app/js/BuscarMesa.js"></script>
</div>
<?php
include_once './app/vistas/ModalBorrar.php';
include_once './app/vistas/ModalSeleccion.php';

