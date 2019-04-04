<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" id="modalAsignaturas">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title">SELECCIÓN DE ASIGNATURA</h4>
            </div>
            <div id="modalDivResultado" class="modal-body">
                <?php
                if(isset($asignaturas)) {
                    echo '
                    <table id="tablaAsignaturas" class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th></th>
                                <th>Nombre</th>
                            </tr>
                        </thead>
                        <tbody>';
                    foreach ($asignaturas as $asignatura) {
                        echo '
                            <tr>
                                <td><input type="radio" id="codigo" name="codigo" value="' . $aula['id_asignatura'] . '"></td>
                                <td>' . $asignatura['nombre'] . '</td>
                            </tr>';
                    }
                    echo '</tbody>
                    </table>';
                } else {
                    echo '<div class="alert alert-danger text-center" role="alert">No se obtuvieron asignaturas para mostrar</div>';
                }
                
                ?>
            </div>
            <div class="modal-footer">
                <?php
                    if(isset($asignaturas)) {
                        echo '<button type="button" class="btn btn-success"
                                      id="btnElegirAsignatura" name="btnElegirAsignatura"
                                      data-dismiss="modal"
                                      title="Elegir asignatura">Seleccionar</button>';
                    }
                 ?>
                <input type='submit' class='btn btn-outline-secondary' 
                       id='btnCancelarCarga'
                       data-dismiss="modal"
                       title="Cancelar la selección de asignatura"
                       value='Cancelar'>
            </div>
        </div>
    </div>
</div>