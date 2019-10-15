<div class="container-fluid" id="contenido">
    <div class="container">
        <div class="form-row mt-4 mb-4">
            <div class="col text-left"><h4><i class="fas fa-user-lock"></i> BUSCAR PERMISO</h4></div>
            <div class="col text-right">
                <a href="principal_home">
                    <button class="btn btn-sm btn-outline-secondary"> 
                        <i class="fas fa-times"></i> CERRAR
                    </button>
                </a>
            </div>
        </div>
        <div class="mt-4 mb-4">
            <form name="formBuscarPermiso" id="formBuscarPermiso" method="POST">
                <div class="card text-center">
                    <div class="card-header text-left">Complete el formulario de búsqueda</div>
                    <div class="card-body">
                        <div class="form-row">
                            <label for="nombre" class="col-sm-2 col-form-label text-left">Nombre:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="nombre" id="nombre"
                                       placeholder="Nombre del permiso">
                            </div>
                            <div class="col text-right">
                                <button type="submit" class="btn btn-success" 
                                        name="btnBuscarPermiso"><i class="fas fa-search"></i> BUSCAR</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <br>
        <div id="seccionInferior" class="mt-4 mb-2">
            <?php require_once './app/permisos/vistas/ProcesarBuscarPermiso.php'; ?>
        </div>
        <div class="modal fade" id="ModalDetallePermiso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center" id="myModalLabel">DETALLE DEL PERMISO</h4>
                    </div>
                    <div class="modal-body"><div class="container" id="cuerpoModalDetalle"></div></div>
                    <div class="modal-footer">
                        <input type='submit' class='btn btn-outline-secondary' data-dismiss="modal" value='Aceptar'>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ModalBorrarPermiso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center" id="myModalLabel">ELIMINACIÓN DE PERMISO</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="alert alert-danger text-center" role="alert"><strong> Confirme la eliminación del permiso </strong></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type='submit' class='btn btn-success' value='Eliminar'>
                        <input type='button' class='btn btn-outline-secondary' data-dismiss="modal" value='Cancelar'>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ModalActualizarPermiso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center" id="myModalLabel">FORMULARIO DE PERMISO</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container" id="seccionSuperiorModal"></div>
                        <div class="container" id="seccionCentralModal">
                            <form id="formActualizarPermiso" name="formActualizarPermiso">
                                <input type="hidden" name="idPermiso" id="idPermiso">
                                <input type="hidden" name="operacion" id="operacion">
                                <div class="card text-center mb-4">
                                    <div class="card-header text-left">Complete el formulario</div>
                                    <div class="card-body">
                                        <div class="form-row"> 
                                            <label for="nombre" class="col-sm-2 col-form-label text-left">Nombre:</label>
                                            <div class="col">
                                                <input type="text" class="form-control mb-2" 
                                                       name="nombre" id="nombre"
                                                       placeholder="Nombre del permiso" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row mb-4">
                                    <div class="col text-right">
                                        <input type='submit' class='btn btn-success' value='Guardar'>
                                        <input type='button' class='btn btn-outline-secondary' data-dismiss="modal" value='Cancelar'>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="container" id="seccionInferiorModal" style="display: none;">
                            <div class="form-row mb-4">
                                <div class="col text-right">
                                    <input type="button" name="btnRefrescar" id="btnRefrescar" class="btn btn-outline-secondary" value="Aceptar">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div> 
<script type="text/javascript" src="./app/usuarios/js/BuscarPermiso.js"></script>
