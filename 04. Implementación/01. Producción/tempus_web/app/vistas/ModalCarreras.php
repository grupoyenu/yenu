<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" id="modalCarreras">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title">SELECCIÓN DE CARRERA</h4>
            </div>
            <div id="modalDivResultado" class="modal-body">
                <?php
                if(isset($carreras)) {
                    echo '
                    <table id="tablaCarreras" class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th></th>
                                <th>Código</th>
                                <th>Nombre</th>
                            </tr>
                        </thead>
                        <tbody>';
                    foreach ($carreras as $carrera) {
                        echo '
                            <tr>
                                <td><input type="radio" id="codigo" name="codigo" value="' . $carrera['codigo'] . '"></td>
                                <td>' . $carrera['nombre'] . '</td>
                                <td>' . $carrera['nombre'] . '</td>
                            </tr>';
                    }
                    echo '</tbody>
                    </table>';
                } else {
                    echo '<div class="alert alert-danger text-center" role="alert">No se obtuvieron carreras para mostrar</div>';
                }
                
                ?>
            </div>
            <div class="modal-footer">
                <?php
                    if(isset($carreras)) {
                        echo '<button type="button" class="btn btn-success"
                                      id="btnElegirCarrera" name="btnElegirCarrera"
                                      data-dismiss="modal"
                                      title="Elegir carrera">Seleccionar</button>';
                    }
                 ?>
                <input type='submit' class='btn btn-outline-secondary' 
                       id='btnCancelarCarga'
                       data-dismiss="modal"
                       title="Cancelar la selección de carrera"
                       value='Cancelar'>
            </div>
        </div>
    </div>
</div>