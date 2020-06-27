<?php include_once '../../principal/vista/header.php'; ?>
<div class="container-fluid" id="contenido">
    <div class="container">
        <div class="form-row mt-4 mb-4">
            <div class="col text-left">
                <h4><i class="fas fa-graduation-cap"></i> CREAR CARRERA</h4>
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
            <form id="formCrearCarrera" name="formCrearCarrera" method="POST">
                <div class="card border-dark">
                    <div class="card-header bg-dark text-white">Complete el formulario y presione CREAR</div>
                    <div class="card-body ">
                        <div class="form-row">
                            <label for="codigo" class="col-sm-2 col-form-label text-left" 
                                   title="Campo obligatorio">* Código:</label>
                            <div class="col">
                                <input type="number" class="form-control mb-2"
                                       id="codigo" name="codigo"  
                                       min="1" max="999" 
                                       placeholder="Ingrese codigo de la carrera" 
                                       title = "Código de la carrera" required>
                            </div>
                            <label for="nombre" class="col-sm-2 col-form-label text-left" 
                                   title="Campo obligatorio">* Nombre:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2"
                                       id="nombre" name="nombre"  
                                       pattern="[A-Za-zÁÉÍÓÚÑáéíóúñ0-9., ]{5,60}"
                                       minlength="5" maxlength="60" 
                                       placeholder="Ingrese nombre de asignatura" 
                                       title = "Nombre de la asignatura" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row mt-2 mb-4">
                    <div class="col text-right">
                        <button type="submit" class="btn btn-success" 
                                id="btnCrearAsignatura" title="Guardar datos">
                            <i class="far fa-save"></i> GUARDAR
                        </button>
                        <a href="FormBuscarCarrera.php">
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
<script type="text/javascript" src="../js/CrearCarrera.js"></script>
<?php
include_once '../../principal/vista/footer.php';