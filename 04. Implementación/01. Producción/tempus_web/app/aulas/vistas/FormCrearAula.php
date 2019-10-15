<div class="container-fluid">

    <div id="seccionSuperior" class="container mt-2 mb-2">
        <div class="row mt-sm-3 mb-4">
            <div class="col align-middle">
                <h3>CREAR AULA</h3>
            </div>
            <div class="col text-right">
                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                    <a class="btn btn-outline-danger" href="principal_home" title="Cancelar"><img data-feather="x-circle"/></a>
                </div>
            </div>
        </div>
    </div>
    <div id="seccionCentral" class="container mt-2 mb-2"></div>
    <div id="seccionInferior" class="container mt-2 mb-2">
        <form id="formCrearAula" name="formCrearAula" method="POST">
            <div class="card text-center">
                <div class="card-header text-left">
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
            <div class="form-row"> 
                <div class="col text-center p-4">
                    <input type="submit" class="btn btn-success" 
                           id="btnCrearAula" name="btnCrearAula"
                           title="Confirmar la creación de la nueva aula"
                           value="CREAR">
                    
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="./app/aulas/js/CrearAula.js"></script>