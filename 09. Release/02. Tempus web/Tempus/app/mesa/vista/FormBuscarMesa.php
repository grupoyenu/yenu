<?php include_once '../../principal/vista/header.php'; ?>
<div class="container-fluid" id="contenido">
    <div class="container">
        <div class="form-row mt-4 mb-4">
            <div class="col text-left">
                <h4><i class="far fa-calendar-alt"></i> BUSCAR MESA DE EXAMEN</h4>
            </div>
            <div class="col text-right">
                <a href="../../principal/vista/home.php">
                    <button class="btn btn-sm btn-outline-secondary" title="Cerrar página actual">
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
                                <input type="text" class="form-control mb-2" name="carrera" id="carrera" maxlength="40" pattern="[A-Za-zÁÉÍÓÚÑáéíóú0-9 ]{0,40}" title="Nombre de carrera: campo no obligatorio" placeholder="Nombre de la carrera">
                            </div>
                            <label for="asignatura" class="col-sm-2 col-form-label">Asignatura:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" name="asignatura" id="asignatura" maxlength="40" pattern="[A-Za-zÁÉÍÓÚÑáéíóú0-9 ]{0,40}" title="Nombre de asignatura: campo no obligatorio" placeholder="Nombre de la asignatura">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col"></div>
                            <div class="col text-right">
                                <button type="submit" class="btn btn-success" title="Realizar la búsqueda" name="btnBuscarMesa">
                                    <i class="fas fa-search"></i> BUSCAR
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div id="seccionInferior" class="mt-4 mb-2"></div>
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
                                <b>
                                    <p id="nombreRegistroBorrar" name="nombreRegistroBorrar"></p>
                                </b>
                                <p> &nbsp; Presione <b>GUARDAR</b> para confirmar la eliminación de la mesa de examen</p>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="btnBorrarMesa" id="btnBorrarMesa">
                            <i class="far fa-save"></i> GUARDAR</button>
                        <button type="submit" class="btn btn-outline-secondary" name="btnCancelarBorrarMesa" id="btnCancelarBorrarMesa" data-dismiss="modal">Cancelar</button>
                        <input type='submit' class='btn btn-outline-secondary' style="display: none;" onclick="window.location.reload()" name="btnRefrescarPantalla" id="btnRefrescarPantalla" value='Aceptar'>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bg-dark" style="opacity: 80%" id="ModalProcesando" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="false">
            <div class="modal-dialog modal-lg p-4">
                <div class="container p-4">
                    <div class="container mt-4 mb-4">
                        <div class="row mt-4 mb-4">
                            <div class="col text-center" style="font-size: 1.8rem;">
                                <i class="fas fa-spinner fa-3x fa-spin text-white"></i>
                            </div>
                        </div>
                        <div class="row mt-4 mb-4">
                            <div class="col text-center text-white" style="font-size: 1.4rem;">
                                <p><strong>Aguarde mientras se buscan las mesas de examen</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../js/BuscarMesa.js"></script>
<?php
include_once '../../principal/vista/footer.php';
