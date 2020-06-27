<?php include_once '../../principal/vista/header.php'; ?>
<div class="container-fluid" id="contenido">
    <div class="container">
        <div class="form-row mt-4 mb-4">
            <div class="col text-left">
                <h4><i class="fas fa-chalkboard"></i> CREAR AULA</h4>
            </div>
            <div class="col text-right">
                <a href="../../principal/vista/home.php">
                    <button class="btn btn-sm btn-outline-secondary"
                            title="Cerrar página actual"> 
                        <i class="fas fa-times"></i> CERRAR
                    </button>
                </a>
            </div>
        </div>
        <div id="seccionResultado"></div>
        <div id="seccionFormulario">
            <form id="formCrearAula" name="formCrearAula" method="POST">
                <div class="card border-dark">
                    <div class="card-header bg-dark text-white"
                         title="Formulario de creación">Complete el formulario y presione CREAR</div>
                    <div class="card-body ">
                        <div class="form-row">
                            <label for="sector" class="col-sm-2 col-form-label text-left" 
                                   title="Campo obligatorio">* Sector:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2"
                                       id="sector" name="sector" 
                                       minlength="1" maxlength="1" pattern="[A-Za-z]"
                                       title="Escriba el nombre del sector. Longitud mímina: 1. Longitud máxima: 1." 
                                       placeholder="Nombre del sector" required>
                            </div>
                            <label for="nombre" class="col-sm-2 col-form-label text-left" 
                                   title="Campo obligatorio">* Nombre:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2"
                                       id="nombre" name="nombre" 
                                       minlength="1" maxlength="40"
                                       pattern="[A-Za-zÁÉÍÓÚÑáéíóúñ0-9 ]{1,40}"
                                       title = "Escriba el nombre del aula. Longitud mínima: 1. Longitud máxima: 40." 
                                       placeholder="Nombre del aula"required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row mt-2 mb-4">
                    <div class="col text-right">
                        <button type="submit" class="btn btn-success" 
                                id="btnCrearAula" title="Guardar datos">
                            <i class="far fa-save"></i> GUARDAR
                        </button>
                        <a href="FormBuscarAula.php" title="Ir al formulario de búsqueda">
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
<script type="text/javascript" src="../js/CrearAula.js"></script>
