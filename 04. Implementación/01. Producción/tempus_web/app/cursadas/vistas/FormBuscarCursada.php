<div class="container-fluid" id="contenido">
    <div class="container">
        <div class="form-row mt-4 mb-4">
            <div class="col text-left"><h4><i class="far fa-clock"></i> BUSCAR HORARIO DE CURSADA</h4></div>
            <div class="col text-right">
                <a href="principal_home">
                    <button class="btn btn-sm btn-outline-secondary"> 
                        <i class="fas fa-times"></i> CERRAR
                    </button>
                </a>
            </div>
        </div> 
        <div class="mt-4 mb-4">
            <form name="formBuscarCursada" id="formBuscarCursada" method="POST">
                <div class="card">
                    <div class="card-header">Formulario de búsqueda</div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col">
                                <select id="campo" name="campo" class="form-control mb-2" >
                                    <option value="nombreCarrera">Por carrera</option>
                                    <option value="nombreAsignatura">Por asignatura</option>
                                </select>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="valor" id="valor"
                                       placeholder="Nombre de carrera o asignatura">
                            </div>
                            <div class="col text-right">
                                <button type="submit" class="btn btn-success" 
                                        name="btnBuscarCursada"><i class="fas fa-search"></i> BUSCAR</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <br>
        <div id="seccionInferior" class="mt-4 mb-2">
            <?php require_once './app/cursadas/vistas/ProcesarBuscarCursada.php'; ?>
        </div>
    </div>
</div>
<script type="text/javascript" src="./app/cursadas/js/BuscarCursada.js"></script>

