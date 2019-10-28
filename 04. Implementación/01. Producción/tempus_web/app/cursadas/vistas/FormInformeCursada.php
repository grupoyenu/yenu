<div class="container-fluid" id="contenido">
    <div class="container">
        <div class="form-row mt-4 mb-4">
            <div class="col text-left"><h4><i class="far fa-clock"></i> INFORME HORARIO DE CURSADA</h4></div>
            <div class="col text-right">
                <a href="principal_home">
                    <button class="btn btn-sm btn-outline-secondary"> 
                        <i class="fas fa-times"></i> CERRAR
                    </button>
                </a>
            </div>
        </div> 
        <div class="mt-4 mb-4">
            <form name="formInformeCursada" id="formInformeCursada" method="POST">
                <div class="card">
                    <div class="card-header">Formulario de búsqueda</div>
                    <div class="card-body">
                        <div class="form-row">
                            <label for="carrera" class="col-sm-2 col-form-label">Carrera:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="carrera" id="carrera"
                                       placeholder="Nombre de carrera">
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="asignatura" class="col-sm-2 col-form-label">Asignatura:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="asignatura" id="asignatura"
                                       placeholder="Nombre de asignatura">
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="dia" class="col-sm-2 col-form-label">Día:</label>
                            <div class="col">
                                <select class="form-control mb-2">
                                    <option value="TODOS">No aplicar filtro</option>
                                    <option value="1">Lunes</option>
                                    <option value="2">Martes</option>
                                    <option value="3">Miercoles</option>
                                    <option value="4">Jueves</option>
                                    <option value="5">Viernes</option>
                                    <option value="6">Sábado</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="dia" class="col-sm-2 col-form-label">Franja horaria:</label>
                            <div class="col">
                                <select class="form-control mb-2">
                                    <option value="TODOS">No aplicar filtro para hora de inicio</option>
                                    <option value="1">Lunes</option>
                                    <option value="2">Martes</option>
                                    <option value="3">Miercoles</option>
                                    <option value="4">Jueves</option>
                                    <option value="5">Viernes</option>
                                    <option value="6">Sábado</option>
                                </select>
                            </div>
                            <div class="col">
                                <select class="form-control mb-2">
                                    <option value="TODOS">No aplicar filtro para hora de fin</option>
                                    <option value="1">Lunes</option>
                                    <option value="2">Martes</option>
                                    <option value="3">Miercoles</option>
                                    <option value="4">Jueves</option>
                                    <option value="5">Viernes</option>
                                    <option value="6">Sábado</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
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
            <?php require_once './app/cursadas/vistas/ProcesarInformeCursada.php'; ?>
        </div>
    </div>
</div>
<script type="text/javascript" src="./app/cursadas/js/BuscarCursada.js"></script>