<?php
$opcionesHora = "";
for ($hora = 10; $hora < 23; ++$hora) {
    $opcionesHora .= "<option value='{$hora}:00'>{$hora}:00 hs</option>";
}
?>
<div class="container-fluid" id="contenido">
    <div class="container">
        <div class="form-row mt-4 mb-4">
            <div class="col text-left"><h4><i class="far fa-calendar-alt"></i> INFORME MESA DE EXAMEN</h4></div>
            <div class="col text-right">
                <a href="principal_home">
                    <button class="btn btn-sm btn-outline-secondary"> 
                        <i class="fas fa-times"></i> CERRAR
                    </button>
                </a>
            </div>
        </div> 
        <div class="mt-4 mb-4">
            <form name="formInformeMesa" id="formInformeMesa" method="POST">
                <div class="card border-dark">
                    <div class="card-header bg-dark text-white">Formulario de búsqueda</div>
                    <div class="card-body">
                        <div class="form-row">
                            <label for="carrera" class="col-sm-2 col-form-label">Carrera:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="carrera" id="carrera"
                                       placeholder="Nombre de carrera">
                            </div>
                            <label for="asignatura" class="col-sm-2 col-form-label">Asignatura:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="asignatura" id="asignatura"
                                       placeholder="Nombre de asignatura">
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="fecha" class="col-sm-2 col-form-label">Fecha:</label>
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
                            <label for="hora" class="col-sm-2 col-form-label">Hora:</label>
                            <div class="col">
                                <select class="form-control mb-2" name="hora" id="hora">
                                    <option value="TODOS">No aplicar filtro</option>
                                    <?= $opcionesHora; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="modificada" class="col-sm-2 col-form-label">Modificada:</label>
                            <div class="col">
                                <select class="form-control mb-2" name="modificada" id="modificada">
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col text-right">
                                <button type="submit" class="btn btn-success" 
                                        name="btnBuscarMesa"><i class="fas fa-search"></i> BUSCAR</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <br>
        <div id="seccionInferior" class="mt-4 mb-2">

        </div>
    </div>
</div>
<script type="text/javascript" src="./app/mesas/js/InformeMesa.js"></script>