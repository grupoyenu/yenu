<?php
$opcionesInicio = $opcionesFin = "";
for ($horainicio = 10; $horainicio < 23; ++$horainicio) {
    $opcionesInicio .= "<option value='{$horainicio}:00'>{$horainicio}:00 hs</option>
                        <option value='{$horainicio}:30'>{$horainicio}:30 hs</option>";
}
for ($horafin = 11; $horafin < 24; ++$horafin) {
    $opcionesFin .= "<option value='{$horafin}:00'>{$horafin}:00 hs</option>
                     <option value='{$horafin}:30'>{$horafin}:30 hs</option>";
}
?>
<?php include_once '../../principal/vista/header.php'; ?>
<div class="container-fluid" id="contenido">
    <div class="container">
        <div class="form-row mt-4 mb-4">
            <div class="col text-left"><h4><i class="far fa-clock"></i> INFORME HORARIO DE CURSADA</h4></div>
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
            <form name="formInformeCursada" id="formInformeCursada" method="POST">
                <div class="card border-dark">
                    <div class="card-header bg-dark text-white">Formulario de búsqueda</div>
                    <div class="card-body">
                        <div class="form-row">
                            <label for="carrera" class="col-sm-2 col-form-label">Carrera:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="carrera" id="carrera" maxlength="20"
                                       placeholder="Nombre de carrera">
                            </div>
                            <label for="asignatura" class="col-sm-2 col-form-label">Asignatura:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="asignatura" id="asignatura" maxlength="20"
                                       placeholder="Nombre de asignatura">
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="dia" class="col-sm-2 col-form-label">Día:</label>
                            <div class="col">
                                <select class="form-control mb-2" name="dia" id="dia">
                                    <option value="NO">No aplicar filtro</option>
                                    <option value="Lunes">Lunes</option>
                                    <option value="Martes">Martes</option>
                                    <option value="Miercoles">Miercoles</option>
                                    <option value="Jueves">Jueves</option>
                                    <option value="Viernes">Viernes</option>
                                    <option value="Sabado">Sábado</option>
                                </select>
                            </div>
                            <label for="modificada" class="col-sm-2 col-form-label">Modificada:</label>
                            <div class="col">
                                <select class="form-control mb-2" name="modificada" id="modificada">
                                    <option value="SI">Si</option>
                                    <option value="NO">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="operadorDesde" class="col-sm-2 col-form-label">Operador de inicio:</label>
                            <div class="col">
                                <select class="form-control mb-2" name="operadorDesde" id="operadorDesde">
                                    <option value="=">Igual</option>
                                    <option value=">=">Mayor o igual</option>
                                    <option value=">">Mayor</option>
                                </select>
                            </div>
                            <label for="desde" class="col-sm-2 col-form-label">Hora de inicio:</label>
                            <div class="col">
                                <select class="form-control mb-2" name="desde" id="desde">
                                    <option value="NO">No aplicar filtro</option>
                                    <?= $opcionesInicio; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="operadorHasta" class="col-sm-2 col-form-label">Operador de fin:</label>
                            <div class="col">
                                <select class="form-control mb-2" name="operadorHasta" id="operadorHasta">
                                    <option value="=">Igual</option>
                                    <option value="<=">Menor o igual</option>
                                    <option value="<">Menor</option>
                                </select>
                            </div>
                            <label for="hasta" class="col-sm-2 col-form-label">Hora de fin:</label>
                            <div class="col">
                                <select class="form-control mb-2" name="hasta" id="hasta">
                                    <option value="NO">No aplicar filtro</option>
                                    <?= $opcionesFin; ?>
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
        </div>
    </div>
</div>
<script type="text/javascript" src="./app/cursadas/js/InformeCursada.js"></script>
<?php
include_once '../../principal/vista/footer.php';
