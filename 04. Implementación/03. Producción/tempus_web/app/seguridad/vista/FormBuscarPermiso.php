<?php include_once '../../principal/vista/header.php'; ?>
<div class="container-fluid" id="contenido">
    <div class="container">
        <div class="form-row mt-4 mb-4">
            <div class="col text-left">
                <h4><i class="fas fa-user-lock"></i> BUSCAR PERMISO</h4>
            </div>
            <div class="col text-right">
                <a href="../../principal/vista/home.php">
                    <button class="btn btn-sm btn-outline-secondary"> 
                        <i class="fas fa-times"></i> CERRAR
                    </button>
                </a>
            </div>
        </div>
        <div class="mt-4 mb-4">
            <form name="formBuscarPermiso" id="formBuscarPermiso" method="POST">
                <input type="hidden" name="peticion" id="peticion">
                <div class="card border-dark">
                    <div class="card-header bg-dark text-white"
                         title="Formulario de búsqueda">Formulario de búsqueda</div>
                    <div class="card-body">
                        <div class="form-row">
                            <label for="nombre" class="col-sm-2 col-form-label"
                                   title="Campo no obligatorio">Nombre:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="nombre" id="nombre" 
                                       maxlength="10" pattern="[A-Z]{0,10}"
                                       title="Escriba el nombre del permiso. Longitud máxima: 10."
                                       placeholder="Nombre del permiso">
                            </div>
                            <div class="col text-right">
                                <button type="submit" class="btn btn-success" 
                                        title="Realizar la búsqueda"
                                        name="btnBuscarPermiso">
                                    <i class="fas fa-search"></i> BUSCAR
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div id="seccionInferior" class="mt-4 mb-4"></div>
        <div class="modal fade" id="ModalBorrarPermiso" tabindex="-1" role="dialog" 
             aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">
                            <i class='fas fa-trash'></i> ELIMINACIÓN DE PERMISO
                        </h4>
                    </div>
                    <div class="modal-body" id="cuerpoModal">
                        <form id="formBorrarPermiso" name="formBorrarPermiso" method="POST">
                            <input type="hidden" name="modalIdPermiso" id="modalIdPermiso">
                            <div class="container">
                                <p><strong> Presione GUARDAR para confirmar la eliminación del permiso </strong></p>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"
                                name="btnBorrarPermiso" id="btnBorrarPermiso">
                            <i class="far fa-save"></i> GUARDAR</button>
                        <input type='submit' class='btn btn-outline-secondary' 
                               style="display: none;"
                               name="btnRefrescarPantalla" id="btnRefrescarPantalla" value='Aceptar'>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div> 
<script type="text/javascript" src="../js/BuscarPermiso.js"></script>
