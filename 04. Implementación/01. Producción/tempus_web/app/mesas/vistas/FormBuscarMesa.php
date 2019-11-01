<div class="container-fluid" id="contenido">
    <div class="container">
        <div class="form-row mt-4 mb-4">
            <div class="col text-left"><h4><i class="far fa-calendar-alt"></i> BUSCAR MESA DE EXAMEN</h4></div>
            <div class="col text-right">
                <a href="principal_home">
                    <button class="btn btn-sm btn-outline-secondary"> 
                        <i class="fas fa-times"></i> CERRAR
                    </button>
                </a>
            </div>
        </div> 
        <div class="mt-4 mb-4">
            <form name="formBuscarMesa" id="formBuscarMesa" method="POST">
                <div class="card border-dark">
                    <div class="card-header bg-dark text-white">Formulario de búsqueda</div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col">
                                <select id="campo" name="campo" class="form-control mb-2" >
                                    <option value="nombreCarrera">Por carrera</option>
                                    <option value="nombreAsignatura">Por asignatura</option>
                                </select>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="valor" id="valor"
                                       placeholder="Nombre de carrera o asignatura">
                            </div>
                            <div class="col text-right">
                                <button type="submit" class="btn btn-success" 
                                        name="btnBuscarMesa"><i class="fas fa-search"></i> BUSCAR</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <br>
        <div id="seccionInferior" class="mt-4 mb-2">
            <?php require_once './app/mesas/vistas/ProcesarBuscarMesa.php'; ?>
        </div>
        <div class="modal fade" id="ModalDetalleMesa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="far fa-calendar-alt"></i> DETALLE DE LA MESA DE EXAMEN</h4>
                    </div>
                    <div class="modal-body" id="cuerpoModal">
                        <div class="form-row">
                            <label for="mdmCodigoCarrera" class="col-sm-2 col-form-label">Carrera:</label>
                            <div class="col-1">
                                <input type="text" class="form-control mb-2" 
                                       name="mdmCodigoCarrera" id="mdmCodigoCarrera"
                                       placeholder="Código de carrera" readonly>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdmNombreCarrera" id="mdmNombreCarrera"
                                       placeholder="Nombre de carrera" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdmNombreAsignatura" class="col-sm-2 col-form-label">Asignatura:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdmNombreAsignatura" id="mdmNombreAsignatura"
                                       placeholder="Nombre de asignatura" readonly>
                            </div>
                        </div>
                        <div class="form-row mt-2 mb-2">
                            <label class="col-form-label"><strong>TRIBUNAL</strong></label>
                        </div>
                        <div class="form-row">
                            <label for="mdmPresidente" class="col-sm-2 col-form-label">Presidente:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdmPresidente" id="mdmPresidente"
                                       placeholder="Nombre de presidente" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdmVocal1" class="col-sm-2 col-form-label">Vocal primero:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdmVocal1" id="mdmVocal1"
                                       placeholder="Nombre de vocal primero" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdmVocal2" class="col-sm-2 col-form-label">Vocal segundo:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdmVocal12" id="mdmVocal2"
                                       placeholder="Nombre de vocal segundo" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdmSuplente" class="col-sm-2 col-form-label">Suplente:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdmSuplente" id="mdmSuplente"
                                       placeholder="Nombre de suplente" readonly>
                            </div>
                        </div>
                        <div class="form-row mt-2 mb-2">
                            <label class="col-form-label"><strong>PRIMER LLAMADO</strong></label>
                        </div>
                        <div class="form-row">
                            <label for="mdmFechaPrimero" class="col-sm-2 col-form-label">Fecha y hora:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdmFechaPrimero" id="mdmFechaPrimero"
                                       placeholder="Fecha de primer llamado" readonly>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdmHoraPrimero" id="mdmHoraPrimero"
                                       placeholder="Hora de primer llamado" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdmSectorPrimero" class="col-sm-2 col-form-label">Lugar:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdmSectorPrimero" id="mdmSectorPrimero"
                                       placeholder="Sector" readonly>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdmAulaPrimero" id="mdmAulaPrimero"
                                       placeholder="Aula" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdmEdicionPrimero" class="col-sm-2 col-form-label">Modificación:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdmEdicionPrimero" id="mdmEdicionPrimero"
                                       placeholder="Fecha de modificación" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type='submit' class='btn btn-outline-secondary' data-dismiss="modal" value='Aceptar'>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="./app/mesas/js/BuscarMesa.js"></script>