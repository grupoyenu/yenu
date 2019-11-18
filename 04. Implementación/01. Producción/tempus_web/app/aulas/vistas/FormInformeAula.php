<?php
$controlador = new ControladorLlamados();
$fechas = $controlador->listarFechas();

$opcionesFecha = $opcionesInicio = $opcionesFin = $opcionesHora = "";

if (gettype($fechas) == "object") {
    while ($llamado = $fechas->fetch_assoc()) {
        $fecha = date_format(date_create($llamado['fecha']), 'd/m/Y');
        $opcionesFecha .= "<option value='{$llamado['fecha']}'>{$fecha}</option>";
    }
}

for ($horainicio = 10; $horainicio < 23; ++$horainicio) {
    $opcionesInicio .= "<option value='{$horainicio}:00'>{$horainicio}:00 hs</option>
                        <option value='{$horainicio}:30'>{$horainicio}:30 hs</option>";
}
for ($horafin = 11; $horafin < 24; ++$horafin) {
    $opcionesFin .= "<option value='{$horafin}:00'>{$horafin}:00 hs</option>
                     <option value='{$horafin}:30'>{$horafin}:30 hs</option>";
}

for ($hora = 10; $hora < 23; ++$hora) {
    $opcionesHora .= "<option value='{$hora}:00'>{$hora}:00 hs</option>";
}
?>
<div class="container-fluid" id="contenido">
    <div class="container">
        <div class="form-row mt-4 mb-4">
            <div class="col text-left"><h4><i class="fas fa-chalkboard"></i> INFORME AULA</h4></div>
            <div class="col text-right">
                <a href="principal_home">
                    <button class="btn btn-sm btn-outline-secondary"> 
                        <i class="fas fa-times"></i> CERRAR
                    </button>
                </a>
            </div>
        </div>
        <div class="mt-4 mb-4">
            <form name="formInformeAula" id="formInformeAula" method="POST">
                <div class="card border-dark">
                    <div class="card-header bg-dark text-white"> Formulario de búsqueda</div>
                    <div class="card-body">
                        <div class="form-row">
                            <label for="modulo" class="col-sm-2 col-form-label">Módulo:</label>
                            <div class="col">
                                <select id="modulo" name="modulo" class="form-control mb-2" >
                                    <option value="CUR">Horarios de cursada</option>
                                    <option value="MES">Mesas de examen</option>
                                </select>
                            </div>
                            <label class="col-sm-2 col-form-label"></label>
                            <div class="col"></div>
                        </div>
                        <hr>
                        <div class="form-row">
                            <label for="disponibleCursada" class="col-sm-2 col-form-label">Condición:</label>
                            <div class="col">
                                <select class="form-control mb-2" name="disponibleCursada" id="disponibleCursada">
                                    <option value="NOT IN">Disponible</option>
                                    <option value="IN">Ocupada</option>
                                </select>
                            </div>
                            <label for="dia" class="col-sm-2 col-form-label">Día:</label>
                            <div class="col">
                                <select id="dia" name="dia" class="form-control mb-2">
                                    <option value="NO">No aplicar filtro</option>
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
                            <label for="desde" class="col-sm-2 col-form-label">Hora de inicio:</label>
                            <div class="col">
                                <select class="form-control mb-2" name="desde" id="desde">
                                    <?= $opcionesInicio; ?>
                                </select>
                            </div>
                            <label for="hasta" class="col-sm-2 col-form-label">Hora de fin:</label>
                            <div class="col">
                                <select class="form-control mb-2" name="hasta" id="hasta">
                                    <?= $opcionesFin; ?>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="form-row">
                            <label for="disponibleMesa" class="col-sm-2 col-form-label">Disponibilidad:</label>
                            <div class="col">
                                <select class="form-control mb-2" name="disponibleMesa" id="disponibleMesa" disabled>
                                    <option value="NOT IN">Disponible</option>
                                    <option value="IN">Ocupada</option>
                                </select>
                            </div>

                            <label for="fecha" class="col-sm-2 col-form-label">Fecha:</label>
                            <div class="col">
                                <select class="form-control mb-2" name="fecha" id="fecha" disabled>
                                    <?= $opcionesFecha; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="horaMesa" class="col-sm-2 col-form-label">Día:</label>
                            <div class="col">
                                <select id="horaMesa" name="horaMesa" class="form-control mb-2" disabled>
                                    <?= $opcionesHora; ?>
                                </select>
                            </div>
                            <label class="col-sm-2 col-form-label"></label>
                            <div class="col"></div>
                        </div>
                        <div class="form-row">
                            <div class="col text-right">
                                <button type="submit" class="btn btn-success" 
                                        name="btnBuscarAula"><i class="fas fa-search"></i> BUSCAR</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <br>
        <div id="seccionInferior" class="mt-4 mb-2"></div>
    </div>
</div>
<script type="text/javascript" src="./app/aulas/js/InformeAula.js"></script>