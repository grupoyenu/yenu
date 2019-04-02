<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" id="modalDocentes">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title">SELECCIÓN DE DOCENTE</h4>
            </div>
            <div id="modalDivResultado" class="modal-body">
                <?php
                if($docentes) {
                    echo '
                    <input type="hidden" id="tipo" name="tipo" value="">
                    <table id="tablaDocentes" class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th></th>
                                <th>Nombre</th>
                            </tr>
                        </thead>
                        <tbody>';
                    foreach ($docentes as $docente) {
                        echo '
                            <tr>
                                <input type="hidden" id="nombre' . $docente['iddocente'] . '" name="nombre' . $docente['iddocente'] . '" value="' . $docente['nombre'] . '">
                                <td><input type="radio" id="radioDocente" name="radioDocente" value="' . $docente['iddocente'] . '"></td>
                                <td>' . $docente['nombre'] . '</td>
                            </tr>';
                    }
                    echo '</tbody>
                    </table>';
                } else {
                    echo '<div class="alert alert-danger text-center" role="alert">No se obtuvieron docentes para mostrar</div>';
                }
                
                ?>
            </div>
            <div class="modal-footer">
                <?php
                    if($docentes) {
                        echo '<button type="button" class="btn btn-success"
                                      id="btnElegirDocente" name="btnElegirDocente"
                                      title="Elegir docente">Seleccionar</button>';
                    }
                 ?>
                <input type='submit' class='btn btn-outline-secondary' 
                       id='btnCancelarCarga'
                       data-dismiss="modal"
                       title="Cancelar la selección del docente"
                       value='Cancelar'>
            </div>
        </div>
    </div>
</div>