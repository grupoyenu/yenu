<div class="container-fluid" id="contenido">
    <div class="container">
        <div class="form-row mt-4 mb-4">
            <div class="col text-left"><h4><i class="fas fa-chalkboard"></i> BUSCAR AULA</h4></div>
            <div class="col text-right">
                <a href="principal_home">
                    <button class="btn btn-sm btn-outline-secondary"> 
                        <i class="fas fa-times"></i> CERRAR
                    </button>
                </a>
            </div>
        </div>
        <div class="mt-4 mb-4">
            <form name="formBuscarAula" id="formBuscarAula" method="POST">
                <div class="card border-dark">
                    <div class="card-header bg-dark text-white"> Formulario de búsqueda</div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col">
                                <select id="campo" name="campo" class="form-control mb-2" >
                                    <option value="sector">Por sector</option>
                                    <option value="nombre">Por nombre</option>
                                </select>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="valor" id="valor"
                                       placeholder="Nombre del aula">
                            </div>
                            <div class="col text-right">
                                <button type="submit" class="btn btn-success" 
                                        name="btnBuscarAula"><i class="fas fa-search"></i> BUSCAR</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <br>
        <div id="seccionInferior" class="mt-4 mb-2">
            <?php require_once './app/aulas/vistas/ProcesarBuscarAula.php'; ?>
        </div>
        <div class="modal fade" id="modalBorrarAula" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel"><i class='fas fa-trash'></i> ELIMINACIÓN DE AULA</h4>
                    </div>
                    <div class="modal-body" id="cuerpoModalBorrar">
                        <form name="formBorrarAula" id="formBorrarAula" method="POST">
                            <input type="hidden" name="modalIdAula" id="modalIdAula">
                            <div class="container">
                                <p><strong> Presione GUARDAR para confirmar la eliminación del aula </strong></p>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"
                                name="btnBorrarAula" id="btnBorrarAula">
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
<script type="text/javascript" src="./app/aulas/js/BuscarAula.js"></script>