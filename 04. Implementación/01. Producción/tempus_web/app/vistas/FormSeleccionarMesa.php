<div class="container">
    <h4 class="text-center p-4">IMPORTAR MESAS DE EXAMEN</h4>
    <div id="resultado"></div>
    <div id="contenido">
        <form action="mesa_importar" enctype="multipart/form-data" id="formSeleccionarMesa" name="formSeleccionarMesa" method="POST">
            <fieldset class="border p-2">
                <legend class="w-auto h6" title="Seleccione un archivo con mesas de examen">Información básica</legend>
                <div class="input-group">
                    <div class="custom-file p-4">
                        <input type="file" class="custom-file-input" id="fileMesas" name="fileMesas" accept=".csv" aria-describedby="inputGroupFileAddon01">
                        <label class="custom-file-label" for="inputGroupFile01">Seleccionar archivo .CSV para mesas de examen</label>
                    </div>
                </div>
            </fieldset>
            <div class="form-row"> 
                <div class="col text-center p-4">
                    <input type="submit" class="btn btn-success" 
                           id="btnSeleccionarMesa" name="btnSeleccionarMesa" 
                           title="Confirmar la selección del archivo con mesas de examen"
                           value="Seleccionar">
                    <a href="home"><input type="button" class="btn btn-outline-secondary" 
                           title="Cancelar la selección del archivo con mesas de examen"
                           value="Cancelar"></a>
                </div>
            </div>
        </form>
    </div>  
</div>