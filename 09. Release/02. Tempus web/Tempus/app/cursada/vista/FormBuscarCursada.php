<?php include_once '../../principal/vista/header.php'; ?>
<div class="container-fluid" id="contenido">
    <div class="container">
        <div class="form-row mt-4 mb-4">
            <div class="col text-left">
                <h4><i class="far fa-clock"></i> BUSCAR HORARIO DE CURSADA</h4>
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
            <form name="formBuscarCursada" id="formBuscarCursada" method="POST">
                <input type="hidden" name="peticion" id="peticion">
                <div class="card border-dark">
                    <div class="card-header bg-dark text-white" title="Formulario de búsqueda">Formulario de búsqueda</div>
                    <div class="card-body">
                        <div class="form-row">
                            <label for="carrera" class="col-sm-2 col-form-label" title="Caracter no obligatorio">Carrera:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" name="carrera" id="carrera" maxlength="40" pattern="[A-Za-zÁÉÍÓÚÑáéíóú ]{0,40}" title="Esciba el nombre de la carrera a buscar. Longitud máxima: 40." placeholder="Nombre de la carrera">
                            </div>
                            <label for="asignatura" class="col-sm-2 col-form-label" title="Caracter no obligatorio">Asignatura:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" name="asignatura" id="asignatura" maxlength="40" pattern="[A-Za-zÁÉÍÓÚÑáéíóú0-9 ]{0,40}" title="Escriba el nombre de la asignatura a buscar. Longitud máxima: 40." placeholder="Nombre de la asignatura">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col text-right">
                                <button type="submit" class="btn btn-success" title="Realizar la búsqueda" name="btnBuscarCursada">
                                    <i class="fas fa-search"></i> BUSCAR
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div id="seccionInferior" class="mt-4 mb-4"></div>
        <div class="modal fade" id="ModalBorrarCursada" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">
                            <i class='fas fa-trash'></i> ELIMINACIÓN DE CURSADA
                        </h4>
                    </div>
                    <div class="modal-body" id="cuerpoModalBorrar">
                        <form name="formBorrarCursada" id="formBorrarCursada" method="POST">
                            <input type="hidden" name="modalIdPlan" id="modalIdPlan">
                            <div class="form-row">
                                <b>
                                    <p id="nombreRegistroBorrar" name="nombreRegistroBorrar"></p>
                                </b>
                                <p> &nbsp; Presione <b>GUARDAR</b> para confirmar la eliminación de la cursada</p>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="btnBorrarCursada" id="btnBorrarCursada">
                            <i class="far fa-save"></i> GUARDAR</button>
                        <button type="submit" class="btn btn-outline-secondary" name="btnCancelarBorrarCursada" id="btnCancelarBorrarCursada" data-dismiss="modal">Cancelar</button>
                        <input type='submit' class='btn btn-outline-secondary' style="display: none;" onclick="window.location.reload()" name="btnRefrescarPantalla" id="btnRefrescarPantalla" value='Aceptar'>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript" src="../js/BuscarCursada.js"></script>
<?php
include_once '../../principal/vista/footer.php';