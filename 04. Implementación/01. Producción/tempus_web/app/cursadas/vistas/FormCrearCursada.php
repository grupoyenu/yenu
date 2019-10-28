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
<div class="container-fluid" id="contenido">
    <div class="container">
        <div class="form-row mt-4 mb-4">
            <div class="col text-left"><h4><i class="far fa-clock"></i> CREAR HORARIO DE CURSADA</h4></div>
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
            <form id="formCrearCursada" name="formCrearCursada" method="POST">
                <input type="hidden" name="idAsignatura" id="idAsignatura">
                <input type="hidden" name="idCarrera" id="idCarrera">
                <input type="hidden" name="idAula1" id="idAula1">
                <input type="hidden" name="idAula2" id="idAula2">
                <input type="hidden" name="idAula3" id="idAula3">
                <input type="hidden" name="idAula4" id="idAula4">
                <input type="hidden" name="idAula5" id="idAula5">
                <input type="hidden" name="idAula6" id="idAula6">
                <div class="card border-dark">
                    <div class="card-header bg-dark text-white">Seleccione asignatura</div>
                    <div class="card-body">
                        <div class="form-row">
                            <label for="carrera" class="col-sm-2 col-form-label">* Carrera:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="nombreCarrera" id="nombreCarrera"
                                       placeholder="Nombre de carrera" required readonly>
                            </div>
                            <label for="nroSerie" class="col-sm-2 col-form-label">* Asignatura:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="nombreAsignatura" id="nombreAsignatura"
                                       placeholder="Nombre de asignatura" required readonly>
                            </div>
                        </div>
                        <div class="form-row mt-2">
                            <div class="col text-right">
                                <button class='btn btn-outline-info' 
                                        id="seleccionarAsignatura" name='seleccionarAsignatura'>
                                    <i class="far fa-hand-point-right"></i> ELEGIR
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-2 border-dark">
                    <div class="card-header bg-dark text-white">Complete los horarios de cursada</div>
                    <div class="card-body">
                        <table class="table table table-bordered table-hover" cellspacing="0" style="width:100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Día</th>
                                    <th>Hora de inicio</th>
                                    <th>Hora de fin</th>
                                    <th>Aula</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr name="1">
                                    <td class="align-middle text-center">
                                        <input type="checkbox" class="clases" id="clases" name="cbClases[]" value="1">
                                    </td>
                                    <td class="align-middle">Lunes</td>
                                    <td class="align-middle">
                                        <select class="form-control horaInicio" id="horaInicio1" name="horaInicio1">
                                            <?= $opcionesInicio; ?>
                                        </select>
                                    </td>
                                    <td class="align-middle">
                                        <select class="form-control horaFin" id="horaFin1" name="horaFin1">
                                            <?= $opcionesFin; ?>
                                        </select>
                                    </td>
                                    <td class="align-middle">
                                        <input type="text" class="form-control" id="aula1" name="aula1" placeholder="Nombre de aula" readonly>
                                    </td>
                                    <td class="align-middle text-center">
                                        <button class='btn btn-outline-info seleccionarAula' name='1' ><i class="far fa-hand-point-right"></i> ELEGIR</button>
                                    </td>
                                </tr>
                                <tr name="2">
                                    <td class="align-middle text-center">
                                        <input type="checkbox" class="clases" id="clases" name="cbClases[]" value="2">
                                    </td>
                                    <td class="align-middle">Martes</td>
                                    <td class="align-middle">
                                        <select class="form-control horaInicio" id="horaInicio2" name="horaInicio2">
                                            <?= $opcionesInicio; ?>
                                        </select>
                                    </td>
                                    <td class="align-middle">
                                        <select class="form-control horaFin" id="horaFin2" name="horaFin2">
                                            <?= $opcionesFin; ?>
                                        </select>
                                    </td>
                                    <td class="align-middle">
                                        <input type="text" class="form-control" id="aula2" name="aula2" placeholder="Nombre de aula" readonly>
                                    </td>
                                    <td class="align-middle text-center">
                                        <button class='btn btn-outline-info seleccionarAula' name='2' ><i class="far fa-hand-point-right"></i> ELEGIR</button>
                                    </td>
                                </tr>
                                <tr name="3">
                                    <td class="align-middle text-center">
                                        <input type="checkbox" class="clases" id="clases" name="cbClases[]" value="3">
                                    </td>
                                    <td class="align-middle">Miercoles</td>
                                    <td class="align-middle">
                                        <select class="form-control horaInicio" id="horaInicio3" name="horaInicio3">
                                            <?= $opcionesInicio; ?>
                                        </select>
                                    </td>
                                    <td class="align-middle">
                                        <select class="form-control horaFin" id="horaFin3" name="horaFin3">
                                            <?= $opcionesFin; ?>
                                        </select>
                                    </td>
                                    <td class="align-middle">
                                        <input type="text" class="form-control" id="aula3" name="aula3" placeholder="Nombre de aula" readonly>
                                    </td>
                                    <td class="align-middle text-center">
                                        <button class='btn btn-outline-info seleccionarAula' name='3' ><i class="far fa-hand-point-right"></i> ELEGIR</button>
                                    </td>
                                </tr>
                                <tr name="4">
                                    <td class="align-middle text-center">
                                        <input type="checkbox" class="clases" id="clases" name="cbClases[]" value="4">
                                    </td>
                                    <td class="align-middle">Jueves</td>
                                    <td class="align-middle">
                                        <select class="form-control horaInicio" id="horaInicio4" name="horaInicio4">
                                            <?= $opcionesInicio; ?>
                                        </select>
                                    </td>
                                    <td class="align-middle">
                                        <select class="form-control horaFin" id="horaFin4" name="horaFin4">
                                            <?= $opcionesFin; ?>
                                        </select>
                                    </td>
                                    <td class="align-middle">
                                        <input type="text" class="form-control" id="aula4" name="aula4" placeholder="Nombre de aula" readonly>
                                    </td>
                                    <td class="align-middle text-center">
                                        <button class='btn btn-outline-info seleccionarAula' name='4' ><i class="far fa-hand-point-right"></i> ELEGIR</button>
                                    </td>
                                </tr>
                                <tr name="5">
                                    <td class="align-middle text-center">
                                        <input type="checkbox" class="clases" id="clases" name="cbClases[]" value="5">
                                    </td>
                                    <td class="align-middle">Viernes</td>
                                    <td class="align-middle">
                                        <select class="form-control horaInicio" id="horaInicio5" name="horaInicio5">
                                            <?= $opcionesInicio; ?>
                                        </select>
                                    </td>
                                    <td class="align-middle">
                                        <select class="form-control horaFin" id="horaFin5" name="horaFin5">
                                            <?= $opcionesFin; ?>
                                        </select>
                                    </td>
                                    <td class="align-middle">
                                        <input type="text" class="form-control" id="aula5" name="aula5" placeholder="Nombre de aula" readonly>
                                    </td>
                                    <td class="align-middle text-center">
                                        <button class='btn btn-outline-info seleccionarAula' name='5' ><i class="far fa-hand-point-right"></i> ELEGIR</button>
                                    </td>
                                </tr>
                                <tr name="6">
                                    <td class="align-middle text-center">
                                        <input type="checkbox" class="clases" id="clases" name="cbClases[]" value="6">
                                    </td>
                                    <td class="align-middle">Sábado</td>
                                    <td class="align-middle">
                                        <select class="form-control horaInicio" id="horaInicio6" name="horaInicio6">
                                            <?= $opcionesInicio; ?>
                                        </select>
                                    </td>
                                    <td class="align-middle">
                                        <select class="form-control horaFin" id="horaFin6" name="horaFin6">
                                            <?= $opcionesFin; ?>
                                        </select>
                                    </td>
                                    <td class="align-middle">
                                        <input type="text" class="form-control" id="aula6" name="aula6" placeholder="Nombre de aula" readonly>
                                    </td>
                                    <td class="align-middle text-center">
                                        <button class='btn btn-outline-info seleccionarAula' name='6' ><i class="far fa-hand-point-right"></i> ELEGIR</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="form-row mt-2 mb-4">
                    <div class="col text-right">
                        <button type="submit" class="btn btn-success" 
                                id="btnCrearCursada" title="Guardar datos">
                            <i class="far fa-save"></i> GUARDAR
                        </button>
                        <a href="cursada_buscar">
                            <button type="button" class="btn btn-outline-info">
                                <i class="fas fa-search"></i> BUSCAR
                            </button>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="modalSeleccionarAsignatura" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center">SELECCIONAR ASIGNATURA</h4>
                </div>
                <div class="modal-body" id="cuerpoModalAsignatura"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalSeleccionarAula" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center">SELECCIONAR AULA</h4>
                </div>
                <div class="modal-body" id="cuerpoModalAula"></div>
            </div>
        </div>
    </div>
</div> 
<script type="text/javascript" src="./app/cursadas/js/CrearCursada.js"></script>