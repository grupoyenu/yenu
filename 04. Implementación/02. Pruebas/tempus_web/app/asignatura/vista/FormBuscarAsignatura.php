<?php include_once '../../principal/vista/header.php'; ?>
<div class="container-fluid" id="contenido">
    <div class="container">
        <div class="form-row mt-4 mb-4">
            <div class="col text-left">
                <h4><i class="fas fa-book-open"></i> BUSCAR ASIGNATURA</h4>
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
        <div class="mt-4 mb-4">
            <form name="formBuscarAsignatura" id="formBuscarAsignatura" method="POST">
                <input type="hidden" name="peticion" id="peticion">
                <div class="card border-dark">
                    <div class="card-header bg-dark text-white"
                         title="Formulario de búsqueda">Formulario de búsqueda</div>
                    <div class="card-body">
                        <div class="form-row">
                            <label for="nombre" class="col-sm-2 col-form-label"
                                   title="Caracter no obligatorio">Nombre:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="nombre" id="nombre" maxlength="20" 
                                       pattern="[A-Za-zÁÉÍÓÚÑáéíóúñ0-9 ]{0,20}"
                                       title="Escriba el nombre de la asignatura a buscar. Longitud máxima: 20."
                                       placeholder="Nombre de la asignatura">
                            </div>
                            <div class="col text-right">
                                <button type="submit" class="btn btn-success" 
                                        title="Realizar la búsqueda"
                                        id="btnBuscarAsignatura" name="btnBuscarAsignatura">
                                    <i class="fas fa-search"></i> BUSCAR
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div id="seccionInferior" class="mt-4 mb-4"></div>
    </div>
</div>
<script type="text/javascript" src="../js/BuscarAsignatura.js"></script>
<?php
include_once '../../principal/vista/footer.php';

