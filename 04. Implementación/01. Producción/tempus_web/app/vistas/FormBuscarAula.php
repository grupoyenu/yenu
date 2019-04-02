
<div class="container" id="FormBuscarAula">
    <h4 class="text-center p-4">BUSCAR AULA</h4>
    <?php
    $controlador = new ControladorAula();
    $rows = $controlador->buscarAulas();
    if (is_null($rows)) {
        echo '<div class="alert alert-danger text-center" role="alert">No se pudo realizar la consulta de aulas</div>';
    } else {
        if (empty($rows)) {
            echo '<div class="alert alert-warning text-center" role="alert">No se obtuvieron resultados</div>';
        } else {
            echo '
                <table id="tablaAulas" class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sector</th>
                            <th>Nombre</th>
                            <th class="text-center">Eliminar</th>
                            <th class="text-center">Modificar</th>
                            <th class="text-center">Informe</th>
                        </tr>
                    </thead>
                    <tbody>';
            foreach ($rows as $aula) {
                echo '
                    <tr>
                        <td>' . $aula['sector'] . '</td>
                        <td>' . $aula['nombre'] . '</td>
                        <td class="text-center" title="Borrar ' . $aula['sector'] . ' - ' . $aula['nombre'] . '">
                             <button type="button" class="btn btn-sm  btn-outline-danger">
                                <img src="./lib/img/tempus_borrar.png" class="borrarAula" name="' . $aula['idaula'] . '" width="18" height="18"/>
                            </button>
                        </td>
                        <td class="text-center" title="Modificar ' . $aula['sector'] . ' - ' . $aula['nombre'] . '">
                            <button type="button" class="btn btn-sm  btn-outline-warning">
                                <img src="./lib/img/tempus_editar.png" class="modificarAula" name="' . $aula['idaula'] . '" width="18" height="18"/>
                            </button>
                        </td>
                        <td class="text-center" title="Informe para ' . $aula['sector'] . ' - ' . $aula['nombre'] . '">
                            <button type="button" class="btn btn-sm  btn-outline-info">
                                <img src="./lib/img/tempus_ver.png" class="informeAula" name="' . $aula['idaula'] . '" width="18" height="18"/>
                            </button>
                        </td>
                    </tr>';
            }
            echo '
                </tbody>
            </table>';
        }
    }
    include_once './app/vistas/ModalBorrar.php';
    ?>
</div>

<script type="text/javascript" src="./app/js/BuscarAula.js"></script>