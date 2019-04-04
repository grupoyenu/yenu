<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" id="modalPlanes">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title">SELECCIONE PLAN</h4>
            </div>
            <div id="modalDivResultado" class="modal-body">
                <?php
                if (isset($planes)) {
                    echo '
                    <table id="tablaBuscarCarreras" class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th></th>
                                <th>Nombre de carrera</th>
                                <th>Nombre de asignatura</th>
                            </tr>
                        </thead>
                        <tbody>';
                    foreach ($planes as $plan) {
                        echo '
                            <tr>
                                <input type="hidden" id="carrera' . $plan['codigo'] . '" value="' . $plan['carrera'] . '">
                                <input type="hidden" id="asignatura' . $plan['idasignatura'] . '" value="' . $plan['asignatura'] . '">
                                <td><input type="radio" id="plan" name="' . $plan['codigo'] . '" value="' . $plan['idasignatura'] . '"></td>
                                <td>' . $plan['carrera'] . '</td>
                                <td>' . $plan['asignatura'] . '</td>
                            </tr>';
                    }
                    echo '
                        </tbody>
                    </table>';
                } else {
                    echo '<div class="alert alert-danger text-center" role="alert">No se obtuvieron planes para mostrar</div>';
                }
                ?>
            </div>
            <div class="modal-footer">
                <?php
                if (isset($planes)) {
                    echo '<button type="button" class="btn btn-success"
                                  id="btnElegirPlan" name="btnElegirPlan" 
                                  data-dismiss="modal"
                                  title="Elegir plan">Seleccionar</button>';
                }
                ?>
                <input type='submit' class='btn btn-outline-secondary' 
                       id='btnCancelarCarga'
                       data-dismiss="modal"
                       title="Cancelar la selección del plan"
                       value='Cancelar'>
            </div>
        </div>
    </div>
</div>