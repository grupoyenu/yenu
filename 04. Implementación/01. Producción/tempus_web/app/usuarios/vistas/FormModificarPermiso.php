<?php
if (isset($_POST['idPermiso'])) {
    
    
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $contenido = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
    $botones = ControladorHTML::mostrarBotonBusqueda("usuario_buscarPermiso");
}
?>
<div class="container">
    <div class="form-row mt-4 mb-4">
        <div class="col text-left"><h4><i class="fas fa-user-lock"></i> MODIFICAR PERMISO</h4></div>
        <div class="col text-right">
            <a href="principal_home">
                <button class="btn btn-sm btn-outline-secondary"> 
                    <i class="fas fa-times"></i> CERRAR
                </button>
            </a>
        </div>
    </div>
    <div id="seccionResultado"></div>
    <div id="seccionFormulario">
        <form id="formModificarPermiso" name="formModificarPermiso" method="POST">
            <div class="card border-dark">
                <div class="card-header bg-dark text-white">Modifique el formulario y presione GUARDAR</div>
                <div class="card-body">
                    <div class="form-row">
                        <label for="nombre" class="col-sm-2 col-form-label">* Nombre:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="nombre" id="nombre"
                                   placeholder="Nombre de permiso" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row mt-2 mb-4">
                <div class="col text-right">
                    <button type="submit" class="btn btn-success" 
                            id="btnModificarPermiso" title="Guardar datos">
                        <i class="far fa-save"></i> GUARDAR
                    </button>
                    <a href="usuario_buscarPermiso">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-search"></i> BUSCAR
                        </button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" src="./app/usuarios/js/CrearPermiso.js"></script>
