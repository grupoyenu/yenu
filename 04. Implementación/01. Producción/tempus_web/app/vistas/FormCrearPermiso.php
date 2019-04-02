<div class="container">
    <h4 class="text-center p-4">CREAR PERMISO</h4>
    <div id="resultado"></div>
    <div id="contenido">
        <form id="formCrearPermiso" name="formCrearPermiso" method="POST">
            <fieldset class="border p-2">
                <legend class="w-auto h6" title="Complete el formulario de creación">Información básica</legend>
                <div class="form-row">
                    <label for="nombre" class="col-sm-2 col-form-label" title="Campo obligatorio">* Nombre:</label>
                    <div class="col">
                        <input type="text" 
                               class="form-control mb-2" 
                               id="nombre" name="nombre" 
                               pattern="[A-Z ]{5,30}"
                               minlength="5"
                               maxlength="30"
                               placeholder="Ingrese nombre de permiso"
                               title="Nombre del permiso [A-Z ]{5,30}"
                               required>
                    </div>
                </div>
            </fieldset>
            <div class="form-row"> 
                <div class="col text-center p-4">
                    <input type="submit"
                           class="btn btn-success" 
                           id="btnCrearPermiso" name="btnCrearPermiso"
                           title="Confirmar la creación del nuevo permiso"
                           value="Crear">
                    <a href="home"><input type="button" class="btn btn-outline-secondary" 
                           title="Cancelar la creación del nuevo permiso"
                           value="Cancelar"></a>
                </div>
            </div>
        </form>
    </div>  
</div>
<script type="text/javascript" src="./app/js/CrearPermiso.js"></script>