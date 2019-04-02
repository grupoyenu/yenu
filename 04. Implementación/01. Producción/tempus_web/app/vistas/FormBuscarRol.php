
<div class="container" id="FormBuscarRol">
    <h4 class="text-center p-4">BUSCAR PERMISO</h4>
    <div id="resultado"></div>
    <div id="contenido"> 

        <?php
        $controlador = new ControladorRol();
        $rows = $controlador->buscarRoles();
        if (is_null($rows)) {
            echo '<h5 class="text-center p-2">No se pudo realizar la consulta de roles</h5>';
        } else {
            if (empty($rows)) {
                echo '<h5 class="text-center p-2">No se obtuvieron resultados</h5>';
            } else {
                echo '
                <table id="tablaBuscarRoles" class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">Nombre de rol</th>
                            <th class="text-center">Cantidad de permisos</th>
                            <th class="text-center">Eliminar</th>
                            <th class="text-center">Modificar</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: white;">';
                        foreach ($rows as $rol) {
                            echo '
                        <tr>
                            <td>' . $rol['nombre'] . '</td>
                            <td>' . $rol['permisos'] . '</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm  btn-outline-danger">
                                    <img src="./lib/img/tempus_borrar.png" 
                                         class="borrarRol" name="' . $rol['idrol'] . '" 
                                         width="18" height="18" alt="abm_eliminar"/>
                                </button>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm  btn-outline-warning">
                                    <img src="./lib/img/tempus_editar.png" 
                                         class="modificarRol" name="' . $rol['idrol'] . '" 
                                         width="18" height="18" alt="abm_editar"/>
                                </button>
                            </td>
                        </tr>';
                        }
                        echo '
                    </tbody>
                </table>';
            }
        }
        ?>
    </div>
</div>

<?php
    include_once './app/vistas/ModalBorrar.php';
?>
<script type="text/javascript" src="./app/js/BuscarRol.js"></script>