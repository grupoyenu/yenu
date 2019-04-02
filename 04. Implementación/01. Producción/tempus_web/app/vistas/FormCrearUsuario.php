<div class="container">
    <h4 class="text-center p-4">CREAR USUARIO</h4>
    <div id="resultado"></div>
    <div id="contenido">
        <form id="formCrearUsuario" name="formCrearUsuario" method="POST">
            <fieldset class="border p-2">
                <legend class="w-auto h6" title="Complete el formulario">Información básica</legend>
                <div class="form-row">
                    <label for="email" class="col-sm-2 col-form-label" title="Campo obligatorio">* Email:</label>
                    <div class="col">
                        <input type="email" class="form-control mb-2"
                               id="email" name="email" 
                               placeholder="Ingrese email de usuario" 
                               title="Correo electronico de usuario"
                               required>
                    </div>
                    <label for="nombre" class="col-sm-2 col-form-label" title="Campo obligatorio">* Nombre:</label>
                    <div class="col">
                        <input type="text" class="form-control mb-2"
                               id="nombre" name="nombre" 
                               minlength="5" maxlength="40"
                               pattern="[A-Za-zÁÉÍÓÚÑáéíóúñ0123456789 ]{5,40}" 
                               placeholder="Ingrese nombre de usuario" 
                               title="Nombre de usuario (A-Z, a-z, 0-9, acento, espacio, 5-40)"
                               required>
                    </div>
                </div>
            </fieldset>
            <div class="form-row"> 
                <div class="col text-center p-4">
                    <input type="submit" class="btn btn-success" 
                           id="btnCrearAula" name="btnCrearAula" 
                           title="Confirmar la creación del nuevo usuario"
                           value="Crear">
                    <a href="home">
                        <input type="button" class="btn btn-outline-secondary" 
                               title="Cancelar la creación del nuevo usuario"
                               value="Cancelar">
                    </a>
                </div>
            </div>
        </form>
    </div>  
</div>
<script type="text/javascript" src="./app/js/CrearUsuario.js"></script>