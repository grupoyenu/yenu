<div class="container-fluid">
    <h4 class="text-center p-4">CREAR AULA</h4>
    <div id="resultado"></div>
    <div id="contenido">
        <form id="formCrearAula" name="formCrearAula" method="POST">
            <fieldset class="border p-2">
                <legend class="w-auto h6" title="Complete el formulario de creación">Información básica</legend>
                <div class="form-row">
                    <label for="sector" class="col-sm-2 col-form-label" title="Campo obligatorio">* Sector:</label>
                    <div class="col">
                        <input type="text" 
                               class="form-control mb-2"
                               id="sector" name="sector"  pattern="[A-Za-z]"
                               minlength="1"
                               maxlength="1" 
                               placeholder="Ingrese nombre de sector"
                               title="Nombre del sector"
                               required>
                    </div>
                    <label for="nombre" class="col-sm-2 col-form-label" title="Campo obligatorio">* Nombre:</label>
                    <div class="col">
                        <input type="text"
                               class="form-control mb-2"
                               id="nombre" name="nombre"  
                               pattern="[A-Za-zÁÉÍÓÚÑáéíóúñ0123456789 ]{1,40}"
                               minlength="1"
                               maxlength="40" 
                               placeholder="Ingrese nombre de aula" 
                               title = "Nombre del aula"
                               required>
                    </div>
                </div>
            </fieldset>
            <div class="form-row"> 
                <div class="col text-center p-4">
                    <input type="submit" class="btn btn-success" 
                           id="btnCrearAula" name="btnCrearAula"
                           title="Confirmar la creación de la nueva aula"
                           value="Crear">
                    <a href="home"><input type="button" class="btn btn-outline-secondary" 
                           title="Cancelar la creación de la nueva aula"
                           value="Cancelar"></a>
                </div>
            </div>
        </form>
    </div>  
</div>
<script type="text/javascript" src="./app/js/CrearAula.js"></script>