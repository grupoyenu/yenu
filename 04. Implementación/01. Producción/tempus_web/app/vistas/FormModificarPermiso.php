<?php

echo '<h4 class="text-center p-4">MODIFICAR PERMISO </h4>';
if (!isset($_POST['idpermiso'])) {
    echo '<div class="alert alert-danger text-center" role="alert">No se obtuvo la información necesaria para cargar el formulario</div>';
} else {
    require_once '../controladores/Autoload.php';
    $autoload = new Autoload();
    $autoload->autoloadProcesa();
    
    $permiso = new Permiso($_POST['idpermiso']);
    if (!$permiso->getEstado()) {
         echo '<div class="alert alert-danger text-center" role="alert">No se pudo consultar la información del permiso</div>';
    } else {
        echo '
        <div id="resultado"></div>
        <div id="contenido">
            <form id="formModificarPermiso" name="formModificarPermiso" method="POST">
                <input type="hidden" name="idpermiso" value=" ' . $_POST['idpermiso'] . '">
                <div class="form-row">
                    <label for="nombreCarrera" class="col-sm-2 col-form-label">* Nombre:</label>
                    <div class="col">
                        <input type="text" class="form-control mb-2"
                               id="nombre" name="nombre" 
                               pattern="[A-Z ]{5,30}"
                               value="'.$permiso->getNombre().'" 
                               placeholder="Ingrese nombre de permiso"
                               title="Nombre del permiso" required>
                    </div>
                </div>
                <div class="form-row"> 
                    <div class="col text-center p-4">
                        <input type="submit" class="btn btn-success" 
                               id="btnModificarPermiso" name="btnModificarPermiso" 
                               title="Confirmar la modificación del permiso"
                               value="Modificar">
                        <a href="home"><input type="button" class="btn btn-outline-secondary" 
                                              title="Cancelar la modificación del permiso"
                                              value="Cancelar"></a>
                    </div>
                </div>
            </form>
        </div>
        <script type="text/javascript" src="./app/js/ModificarPermiso.js"></script>';
    }
}
