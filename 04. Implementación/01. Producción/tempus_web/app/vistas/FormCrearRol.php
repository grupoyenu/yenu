<?php
$controladorPermiso = new ControladorPermiso();
$rows = $controladorPermiso->buscarPermisos();

?>

<div class="container">
    <h4 class="text-center p-4">CREAR ROL</h4>
    <div id="resultado"></div>
    <div id="contenido">
        <form id="formCrearRol" name="formCrearRol" method="POST">
            <?php
            if (is_null($rows) || empty($rows)) {
                $mensaje = "No se obtuvieron permisos para cargar el formulario. Verifique que exista al menos un permiso";
                echo '<div class="alert alert-danger text-center" role="alert">' . $mensaje . '</div>';
            } else {
                echo
                '<div class="form-row">
                    <label for="" class="col-sm-2 col-form-label" title="Campo obligatorio">* Nombre:</label>
                    <div class="col">
                        <input type="text" class="form-control mb-2" 
                               id="nombre" name="nombre" 
                               pattern="[A-Za-zÑñ ]{5,30}"
                               minlength="5" maxlength="30"
                               placeholder="Ingrese nombre del rol"
                               title="Nombre del rol (A-Z, a-z, espacio, 5-30)"
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
                </div>';
            }
            ?>

        </form>
    </div> 
</div>
<script type="text/javascript" src="./app/js/CrearRol.js"></script>
