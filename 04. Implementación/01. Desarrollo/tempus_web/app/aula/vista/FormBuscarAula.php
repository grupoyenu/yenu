<?php include_once '../../principal/vista/header.php'; ?>
<div class="container-fluid" id="contenido">
    <div class="container">
        <div class="form-row mt-4 mb-4">
            <div class="col text-left">
                <h4><i class="fas fa-chalkboard"></i> BUSCAR AULA</h4>
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
            <form name="formBuscarAula" id="formBuscarAula" method="POST">
                <input type="hidden" name="peticion" id="peticion">
                <div class="card border-dark">
                    <div class="card-header bg-dark text-white"
                         title="Formulario de búsqueda"> Formulario de búsqueda</div>
                    <div class="card-body">
                        <div class="form-row">
                            <label for="sector" class="col-sm-2 col-form-label"
                                   title="Caracter no obligatorio">Sector:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="sector" id="sector" maxlength="1" 
                                       pattern="[A-Za-z]{0,1}"
                                       title="Escriba el nombre del sector a buscar. Longitud máxima: 1."
                                       placeholder="Nombre del sector">
                            </div>
                            <label for="nombre" class="col-sm-2 col-form-label"
                                   title="Caracter no obligatorio">Nombre:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="nombre" id="nombre" maxlength="15" 
                                       pattern="[A-Za-zÁÉÍÓÚÑáéíóúñ0-9 ]{0,15}"
                                       title="Escriba el nombre del aula a buscar. Longitud máxima: 15."
                                       placeholder="Nombre del sector o aula">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col text-right">
                                <button type="submit" class="btn btn-success" 
                                        title="Realizar la búsqueda"
                                        name="btnBuscarAula"><i class="fas fa-search"></i> BUSCAR</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div id="seccionInferior" class="mt-4 mb-4"></div>
        <div class="modal fade" id="modalBorrarAula" tabindex="-1" role="dialog" 
             aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">
                            <i class='fas fa-trash'></i> ELIMINACIÓN DE AULA
                        </h4>
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
<script type="text/javascript" src="../js/BuscarAula.js"></script>