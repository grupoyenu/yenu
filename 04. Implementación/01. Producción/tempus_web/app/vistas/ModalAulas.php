<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" id="modalAulas">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title">SELECCIÓN DE AULA</h4>
            </div>
            <div id="modalDivResultado" class="modal-body">
                <?php
                if(isset($aulas)) {
                    echo '
                    <input type="hidden" id="dia" name="tipo" value="">
                    <table id="tablaAulas" class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th></th>
                                <th>Sector</th>
                                <th>Nombre</th>
                            </tr>
                        </thead>
                        <tbody>';
                    foreach ($aulas as $aula) {
                        echo '
                            <tr>
                                <input type="hidden" id="sector' . $aula['idaula'] . '" value="' . $aula['sector'] . '">
                                <input type="hidden" id="nombre' . $aula['idaula'] . '" value="' . $aula['nombre'] . '">
                                <td><input type="radio" id="radioAula" name="radioAula" value="' . $aula['idaula'] . '"></td>
                                <td>' . $aula['sector'] . '</td>
                                <td>' . $aula['nombre'] . '</td>
                            </tr>';
                    }
                    echo '</tbody>
                    </table>';
                } else {
                    echo '<div class="alert alert-danger text-center" role="alert">No se obtuvieron aulas para mostrar</div>';
                }
                
                ?>
            </div>
            <div class="modal-footer">
                <?php
                    if(isset($aulas)) {
                        echo '<button type="button" class="btn btn-success"
                        id="btnElegirAula" name="btnElegirAula"
                        data-dismiss="modal"
                        title="Elegir aula">Seleccionar</button>';
                    }
                 ?>
                <input type='submit' class='btn btn-outline-secondary' 
                       id='btnCancelarCarga'
                       data-dismiss="modal"
                       title="Cancelar la selección de aula"
                       value='Cancelar'>
            </div>
        </div>
    </div>
</div>