<div class="container-fluid" id="contenido">
    <div class="container">
        <div class="form-row mt-4 mb-4">
            <div class="col text-left"><h4><i class="far fa-clock"></i> BUSCAR HORARIO DE CURSADA</h4></div>
            <div class="col text-right">
                <a href="principal_home">
                    <button class="btn btn-sm btn-outline-secondary"> 
                        <i class="fas fa-times"></i> CERRAR
                    </button>
                </a>
            </div>
        </div> 
        <div class="mt-4 mb-4">
            <form name="formBuscarCursada" id="formBuscarCursada" method="POST">
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
                                        name="btnBuscarCursada"><i class="fas fa-search"></i> BUSCAR</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <br>
        <div id="seccionInferior" class="mt-4 mb-2">
            <?php require_once './app/cursadas/vistas/ProcesarBuscarCursada.php'; ?>
        </div>
        <div class="modal fade" id="ModalDetalleCursada" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="far fa-clock"></i> DETALLE DEL HORARIO DE CURSADA</h4>
                    </div>
                    <div class="modal-body" id="cuerpoModal">
                        <div class="form-row">
                            <label for="mdcCodigoCarrera" class="col-sm-2 col-form-label">Carrera:</label>
                            <div class="col-1">
                                <input type="text" class="form-control mb-2" 
                                       name="mdcCodigoCarrera" id="mdcCodigoCarrera"
                                       placeholder="Nombre de carrera" readonly>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdcNombreCarrera" id="mdcNombreCarrera"
                                       placeholder="Nombre de carrera" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdcNombreAsignatura" class="col-sm-2 col-form-label">Asignatura:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdcNombreAsignatura" id="mdcNombreAsignatura"
                                       placeholder="Nombre de asignatura" readonly>
                            </div>
                        </div>
                        <div class="form-row mt-2 mb-2">
                            <label class="col-form-label"><strong>HORARIOS DE CLASE</strong></label>
                        </div>
                        <div class="form-row">
                            <label for="mdcLunes" class="col-sm-2 col-form-label">Lunes:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdcLunes" id="mdcLunes" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdcMartes" class="col-sm-2 col-form-label">Martes:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdcMartes" id="mdcMartes" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdcMiercoles" class="col-sm-2 col-form-label">Miercoles:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdcMiercoles" id="mdcMiercoles" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdcJueves" class="col-sm-2 col-form-label">Jueves:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdcJueves" id="mdcJueves" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdcViernes" class="col-sm-2 col-form-label">Viernes:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdcViernes" id="mdcViernes" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdcSabado" class="col-sm-2 col-form-label">Sábado:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdcSabado" id="mdcSabado" readonly>
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
<script type="text/javascript" src="./app/cursadas/js/BuscarCursada.js"></script>

