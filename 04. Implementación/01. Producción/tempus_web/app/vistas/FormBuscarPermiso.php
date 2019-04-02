
<div class="container" id="FormBuscarPermiso">
    <h4 class="text-center p-4">BUSCAR PERMISO</h4>
    <div id="resultado"></div>
    <div id="contenido"> 
        <?php
        $controlador = new ControladorPermiso();
        $rows = $controlador->buscarPermisos();
        if (is_null($rows)) {
            echo '<div class="alert alert-danger text-center" role="alert">No se pudo realizar la consulta de permisos</div>';
        } else {
            if (empty($rows)) {
                echo '<div class="alert alert-warning text-center" role="alert">No se obtuvieron resultados</div>';
            } else {
                echo '
                <table id="tablaPermisos" class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">Nombre de permiso</th>
                            <th class="text-center">Eliminar</th>
                            <th class="text-center">Modificar</th>
                        </tr>
                    </thead>
                    <tbody>';
                        foreach ($rows as $permiso) {
                            echo '
                        <tr>
                            <td>' . $permiso['nombre'] . '</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm  btn-outline-danger">
                                    <img src="./lib/img/tempus_borrar.png" class="borrarPermiso" name="' . $permiso['idpermiso'] . '" width="18" height="18" alt="abm_editar"/>
                                </button>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm  btn-outline-warning">
                                    <img src="./lib/img/tempus_editar.png" class="modificarPermiso" name="' . $permiso['idpermiso'] . '" width="18" height="18" alt="abm_editar"/>
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
<script type="text/javascript" src="./app/js/BuscarPermiso.js"></script>

