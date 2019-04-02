<h4 class="text-center p-4">MODIFICAR ROL</h4>
<?php
if (!isset($_POST['idrol'])) {
    echo '<div class="alert alert-danger text-center" role="alert">No se obtuvo la información necesaria para cargar el formulario</div>';
} else {
    require_once '../controladores/Autoload.php';
    $autoload = new Autoload();
    $autoload->autoloadProcesa();

    $controladorPermiso = new ControladorPermiso();
    $rows = $controladorPermiso->buscarPermisos();

    if (is_null($rows) || empty($rows)) {
        $mensaje = "No se obtuvieron permisos para cargar el formulario. Verifique que exista al menos un permiso";
        echo '<div class="alert alert-danger text-center" role="alert">' . $mensaje . '</div>';
    } else {
        $rol = new Rol($_POST['idrol']);
        if (!$rol->getEstado()) {
            echo '<div class="alert alert-danger text-center" role="alert">No se pudo consultar la información del rol</div>';
        } else {
            echo '
            <div id="resultado"></div>
            <div id="contenido">
                <form id="formModificarRol" name="formModificarRol" method="POST">
                    <input type="hidden" name="idrol" id="idrol" value="' . $rol->getIdrol() . '">
                    <div class="form-row">
                        <label for="" class="col-sm-2 col-form-label" title="Campo obligatorio">* Nombre:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   id="nombre" name="nombre" 
                                   pattern="[A-Za-zÑñ ]{5,30}"
                                   minlength="5" maxlength="30"
                                   placeholder="Ingrese nombre del rol"
                                   title="Nombre del rol (A-Z, a-z, espacio, 5-30)"
                                   value="' . $rol->getNombre() . '"
                                   required>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="" class="col-sm-2 col-form-label" title="Campo obligatorio">* Permisos:</label>
                        <div class="col">
                            <table id="tablaPermisosRol" class="table table-bordered table-hover" >
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="text-center"><input type="checkbox" id="todosPermisos" name="todosPermisos" value="todosPermisos"/></th>
                                        <th class="text-center">Nombre de permiso</th>
                                    </tr>
                                </thead>
                                <tbody>';
            foreach ($rows as $permiso) {
                echo '  <tr>
                        <th class="text-center"><input type="checkbox" id="permisos" name="permisos[]" value="' . $permiso['idpermiso'] . '"/></th>
                        <td>' . $permiso['nombre'] . '</td>
                    </tr>';
            }
            echo '      </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <div class="text-center p-4">
                                <input type="submit" class="btn btn-success" 
                                           id="btnCrearRol" name="btnCrearRol"
                                           title="Confirmar la creación del nuevo rol"
                                           value="Crear">
                                <a href="home">
                                    <input type="button" class="btn btn-outline-secondary" 
                                            title="Cancelar la creación del nuevo rol"
                                            value="Cancelar">
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <script type="text/javascript" src="./app/js/ModificarRol.js"></script>';
        }
    }
}

