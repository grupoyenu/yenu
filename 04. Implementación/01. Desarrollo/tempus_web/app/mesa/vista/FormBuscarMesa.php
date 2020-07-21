<?php include_once '../../principal/vista/header.php'; ?>
<div class="container-fluid" id="contenido">
    <div class="container">
        <div class="form-row mt-4 mb-4">
            <div class="col text-left">
                <h4><i class="far fa-calendar-alt"></i> BUSCAR MESA DE EXAMEN</h4>
            </div>
            <div class="col text-right">
                <a href="principal_home">
                    <button class="btn btn-sm btn-outline-secondary" 
                            title="Cerrar página actual"> 
                        <i class="fas fa-times"></i> CERRAR
                    </button>
                </a>
            </div>
        </div> 
        <div class="mt-4 mb-4">
            <form name="formBuscarMesa" id="formBuscarMesa" method="POST">
                <input type="hidden" name="peticion" id="peticion">
                <div class="card border-dark">
                    <div class="card-header bg-dark text-white">Formulario de búsqueda</div>
                    <div class="card-body">
                        <div class="form-row">
                            <label for="carrera" class="col-sm-2 col-form-label">Carrera:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="carrera" id="carrera"
                                       maxlength="20" 
                                       pattern="[A-Za-zÁÉÍÓÚÑáéíóú0-9 ]{0,20}"
                                       title="Nombre de carrera: campo no obligatorio"
                                       placeholder="Nombre de la carrera">
                            </div>
                            <label for="asignatura" class="col-sm-2 col-form-label">Asignatura:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="asignatura" id="asignatura"
                                       maxlength="20" 
                                       pattern="[A-Za-zÁÉÍÓÚÑáéíóú0-9 ]{0,20}"
                                       title="Nombre de asignatura: campo no obligatorio"
                                       placeholder="Nombre de la asignatura">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col"></div>
                            <div class="col text-right">
                                <button type="submit" class="btn btn-success" 
                                        title="Realizar la búsqueda"
                                        name="btnBuscarMesa">
                                    <i class="fas fa-search"></i> BUSCAR
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div id="seccionInferior" class="mt-4 mb-2"></div>
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
                            <label for="mdmEstadoPrimero" class="col-sm-2 col-form-label">Estado:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdmEstadoPrimero" id="mdmEstadoPrimero"
                                       placeholder="Fecha de modificación" readonly>
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
                        <div id="datosSegundoLlamado" name="datosSegundoLlamado" style="display: none;">
                            <div class="form-row mt-2 mb-2">
                                <label class="col-form-label"><strong>SEGUNDO LLAMADO</strong></label>
                            </div>
                            <div class="form-row">
                                <label for="mdmFechaSegundo" class="col-sm-2 col-form-label">Fecha y hora:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="mdmFechaSegundo" id="mdmFechaSegundo"
                                           placeholder="Fecha de segundo llamado" readonly>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="mdmHoraSegundo" id="mdmHoraSegundo"
                                           placeholder="Hora de segundo llamado" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <label for="mdmSectorSegundo" class="col-sm-2 col-form-label">Lugar:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="mdmSectorSegundo" id="mdmSectorSegundo"
                                           placeholder="Sector" readonly>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="mdmAulaSegundo" id="mdmAulaSegundo"
                                           placeholder="Aula" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <label for="mdmEstadoSegundo" class="col-sm-2 col-form-label">Estado:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="mdmEstadoSegundo" id="mdmEstadoSegundo"
                                           placeholder="Fecha de modificación" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <label for="mdmEdicionSegundo" class="col-sm-2 col-form-label">Modificación:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2" 
                                           name="mdmEdicionSegundo" id="mdmEdicionSegundo"
                                           placeholder="Fecha de modificación" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-row mt-2 mb-2">
                            <label class="col-form-label"><strong>DATOS GENERALES</strong></label>
                        </div>
                        <div class="form-row">
                            <label for="mdmFechaCreacion" class="col-sm-2 col-form-label">Creación:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="mdmFechaCreacion" id="mdmFechaCreacion"
                                       placeholder="Fecha de creacion de la mesa" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="mdmObservacion" class="col-sm-2 col-form-label">Observación:</label>
                            <div class="col">
                                <textarea type="text" class="form-control mb-2" 
                                          name="mdmObservacion" id="mdmObservacion"
                                          placeholder="Observación" readonly></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type='submit' class='btn btn-outline-secondary' data-dismiss="modal" value='Aceptar'>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ModalBorrarMesa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center" id="myModalLabel"> <i class='fas fa-trash'></i> ELIMINACIÓN DE MESA DE EXAMEN</h4>
                    </div>
                    <div class="modal-body" id="cuerpoModalBorrar">
                        <form id="formBorrarMesa" name="formBorrarMesa" method="POST">
                            <input type="hidden" name="modalIdPlan" id="modalIdPlan">
                            <div class="form-row">
                                <b><p id="nombreRegistroBorrar" name="nombreRegistroBorrar"></p></b>
                                <p> &nbsp; Presione <b>GUARDAR</b> para confirmar la eliminación de la mesa de examen</p>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"
                                name="btnBorrarMesa" id="btnBorrarMesa">
                            <i class="far fa-save"></i> GUARDAR</button>
                        <button type="submit" class="btn btn-outline-secondary" 
                                name="btnCancelarBorrarMesa" id="btnCancelarBorrarMesa"
                                data-dismiss="modal">Cancelar</button>
                        <input type='submit' class='btn btn-outline-secondary' 
                               style="display: none;" onclick="window.location.reload()"
                               name="btnRefrescarPantalla" id="btnRefrescarPantalla" value='Aceptar'>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../js/BuscarMesa.js"></script>
<?php
include_once '../../principal/vista/footer.php';
