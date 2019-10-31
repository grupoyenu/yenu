<div class="container-fluid" id="contenido">
    <div class="container">
        <div class="form-row mt-4 mb-4">
            <div class="col text-left"><h4><i class="fas fa-chalkboard"></i> CREAR AULA</h4></div>
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
            <form id="formCrearAula" name="formCrearAula" method="POST">
                <div class="card">
                    <div class="card-header">
                        Complete el formulario y presione CREAR 
                    </div>
                    <div class="card-body ">
                        <div class="form-row">
                            <label for="sector" class="col-sm-2 col-form-label text-left" title="Campo obligatorio">* Sector:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2"
                                       id="sector" name="sector"  pattern="[A-Za-z]"
                                       minlength="1" maxlength="1" 
                                       placeholder="Ingrese nombre de sector"
                                       title="Nombre del sector"
                                       required>
                            </div>
                            <label for="nombre" class="col-sm-2 col-form-label text-left" title="Campo obligatorio">* Nombre:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2"
                                       id="nombre" name="nombre"  
                                       pattern="[A-Za-zÁÉÍÓÚÑáéíóúñ0123456789 ]{1,40}"
                                       minlength="1" maxlength="40" 
                                       placeholder="Ingrese nombre de aula" 
                                       title = "Nombre del aula"
                                       required>
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
                        <a href="aula_buscar">
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
<script type="text/javascript" src="./app/usuarios/js/CrearAula.js"></script>
