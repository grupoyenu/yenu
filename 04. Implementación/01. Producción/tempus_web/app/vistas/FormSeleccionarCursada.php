<div class="container">
    <h4 class="text-center p-4">IMPORTAR HORARIOS DE CURSADA</h4>
    <div id="resultado"></div>
    <div id="contenido">
        <form action="cursada_importar" enctype="multipart/form-data" id="formSeleccionarCursada" name="formSeleccionarCursada" method="POST">
            <fieldset class="border p-2">
                <legend class="w-auto h6" title="Seleccione un archivo con horarios de cursada">Información básica</legend>
                <div class="input-group">
                    <div class="custom-file p-4">
                        <input type="file" class="custom-file-input" id="fileCursadas" name="fileCursadas" accept=".csv" aria-describedby="inputGroupFileAddon01">
                        <label class="custom-file-label" for="inputGroupFile01">Seleccionar archivo .CSV para horarios de cursada</label>
                    </div>
                </div>
            </fieldset>
            <div class="form-row"> 
                <div class="col text-center p-4">
                    <input type="submit" class="btn btn-success" 
                           id="btnSeleccionarCursadas" name="btnSeleccionarCursadas"
                           title="Confirmar la selección del archivo con horarios de cursada"
                           value="Seleccionar">
                    <a href="home"><input type="button" class="btn btn-outline-secondary" 
                           title="Cancelar la selección del archivo con horarios de cursada"
                           value="Cancelar"></a>
                </div>
            </div>
        </form>
    </div>  
</div>