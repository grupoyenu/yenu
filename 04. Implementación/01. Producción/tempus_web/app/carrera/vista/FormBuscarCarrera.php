<?php include_once '../../principal/vista/header.php'; ?>
<div class="container-fluid" id="contenido">
    <div class="container">
        <div class="form-row mt-4 mb-4">
            <div class="col text-left">
                <h4><i class="fas fa-graduation-cap"></i> BUSCAR CARRERA</h4>
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
            <form name="formBuscarCarrera" id="formBuscarCarrera" method="POST">
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
                                       pattern="[A-Za-zÁÉÍÓÚÑáéíóú ]{0,20}"
                                       title="Escriba el nombre de la carrera a buscar. Longitud máxima: 20."
                                       placeholder="Nombre de la carrera">
                            </div>
                            <div class="col text-right">
                                <button type="submit" class="btn btn-success" 
                                        title="Realizar la búsqueda"
                                        id="btnBuscarCarrera" name="btnBuscarCarrera">
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
<script type="text/javascript" src="../js/BuscarCarrera.js"></script>
