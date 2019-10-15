<div class="container-fluid" id="FormBuscarCarrera">
    <div id="seccionSuperior" class="container mt-2 mb-2">
        <div class="row mt-sm-3 mb-4">
            <div class="col align-middle">
                <i class="fas fa-graduation-cap"></i><h3>BUSCAR CARRERA</h3>
            </div>
            <div class="col text-right">
                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                    <a class="btn btn-outline-danger" href="principal_home" title="Cancelar"><img data-feather="x-circle"/></a>
                </div>
            </div>
        </div>
        <form name="formBuscarAula" id="formBuscarCarrera" method="POST">
            <div class="card text-center">
                <div class="card-header text-left">Formulario de búsqueda</div>
                <div class="card-body">
                    <div class="form-row">
                        <label for="nombre" class="col-sm-2 col-form-label text-left">Nombre:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="nombre" id="nombre"
                                   minlength="3" maxlength=="10"
                                   placeholder="Nombre de carrera" required="">
                        </div>
                        <div class="col text-right">
                            <input type="submit" id="btnBuscarCarrera" name="btnBuscarCarrera" class="btn btn-success" value="Buscar">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <br>
    <div id="seccionCentral" class="container mt-2 mb-2"></div>
    <br>
    <div id="seccionInferior" class="container mt-2 mb-2"></div>
</div>
<div class="modal fade" id="ModalDetalleCarrera" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center" id="myModalLabel">DETALLE DE LA CARRERA</h4>
            </div>
            <div class="modal-body" id="cuerpoModal"></div>
            <div class="modal-footer">
                <input type='submit' class='btn btn-outline-secondary' data-dismiss="modal" value='Aceptar'>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="./app/carreras/js/BuscarCarrera.js"></script>
