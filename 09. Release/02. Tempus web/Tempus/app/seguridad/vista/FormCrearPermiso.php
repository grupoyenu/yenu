<?php include_once '../../principal/vista/header.php'; ?>
<div class="container-fluid" id="contenido">
    <div class="container">
        <div class="form-row mt-4 mb-4">
            <div class="col text-left">
                <h4><i class="fas fa-user-lock"></i> CREAR PERMISO</h4>
            </div>
            <div class="col text-right">
                <a href="../../principal/vista/home.php">
                    <button class="btn btn-sm btn-outline-secondary"> 
                        <i class="fas fa-times"></i> CERRAR
                    </button>
                </a>
            </div>
        </div>
        <div id="seccionResultado"></div>
        <div id="seccionFormulario">
            <form id="formCrearPermiso" name="formCrearPermiso" method="POST">
                <div class="card border-dark">
                    <div class="card-header bg-dark text-white"
                         title="Formulario de creación">Complete el formulario y presione GUARDAR</div>
                    <div class="card-body">
                        <div class="form-row">
                            <label for="nombre" class="col-sm-2 col-form-label"
                                   title="Caracter obligatorio">* Nombre:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="nombre" id="nombre" 
                                       maxlength="15" minlength="5" 
                                       pattern="[A-Za-z_]{5,15}"
                                       title="Escriba el nombre del permiso a crear. Longitud mínima: 5. Longitud máxima: 15."
                                       placeholder="Nombre de permiso" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row mt-2 mb-4">
                    <div class="col text-right">
                        <button type="submit" class="btn btn-success" 
                                id="btnCrearPermiso" title="Guardar datos">
                            <i class="far fa-save"></i> GUARDAR
                        </button>
                        <a href="FormBuscarPermiso.php" title="Ir al formulario de búsqueda">
                            <button type="button" class="btn btn-outline-info">
                                <i class="fas fa-search"></i> BUSCAR
                            </button>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="../js/CrearPermiso.js"></script>
<?php
include_once '../../principal/vista/footer.php';