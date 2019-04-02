<?php

echo '<h4 class="text-center p-4">MODIFICAR AULA</h4>';

if (!isset($_POST['idaula'])) {
    echo '<div class="alert alert-danger text-center" role="alert">No se obtuvo la información necesaria para cargar el formulario</div>';
} else {
    
    require_once '../controladores/Autoload.php';
    $autoload = new Autoload();
    $autoload->autoloadProcesa();
    
    $aula = new Aula($_POST['idaula']);
    if (!$aula->getEstado()) {
        echo '<div class="alert alert-danger text-center" role="alert">No se pudo consultar la información del aula</div>';
    } else {
        
        echo '
        <div id="resultado"></div>
        <div id="contenido">
            <form id="formModificarAula" name="formModificarAula" method="POST">
            <input type="hidden" name="idaula" value=" ' . $_POST['idaula'] . '">
            <fieldset class="border p-2">
                <legend class="w-auto h6" title="Complete el formulario de modificación">Información básica</legend>
                <div class="form-row">
                    <label for="sector" class="col-sm-2 col-form-label" title="Campo obligatorio">* Sector:</label>
                    <div class="col">
                        <input type="text" class="form-control mb-2"
                               id="sector" name="sector"  pattern="[A-Za-z]"
                               minlength="1" maxlength="1" 
                               value="' . $aula->getSector() . '"
                               placeholder="Ingrese nombre de sector"
                               title="Nombre del sector" required>
                    </div>
                    <label for="nombre" class="col-sm-2 col-form-label" title="Campo obligatorio">* Nombre:</label>
                    <div class="col">
                        <input type="text" class="form-control mb-2"
                               id="nombre" name="nombre"  
                               pattern="[A-Za-zÁÉÍÓÚÑáéíóúñ0123456789 ]{1,40}"
                               minlength="1" maxlength="40" 
                               value="' . $aula->getNombre() . '"
                               placeholder="Ingrese nombre de aula" 
                               title = "Nombre del aula" required>
                    </div>
                </div>
            </fieldset>
            <div class="form-row"> 
                <div class="col text-center p-4">
                    <input type="submit"
                           class="btn btn-success" 
                           id="btnModificarAula" name="btnModificarAula"
                           title="Confirmar la modificación del aula"
                           value="Modificar">
                    <a href="home"><input type="button" class="btn btn-outline-secondary" 
                           title="Cancelar la modificación del aula"
                           value="Cancelar"></a>
                </div>
            </div>
        </form>
        </div>
        <script type="text/javascript" src="./app/js/ModificarAula.js"></script>';
    }
}


