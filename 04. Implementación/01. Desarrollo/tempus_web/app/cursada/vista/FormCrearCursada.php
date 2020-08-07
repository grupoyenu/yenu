<?php
include_once '../../principal/vista/header.php';

use app\util\modelo\Util;

$opcionesInicio = $opcionesFin = "";
for ($horainicio = 10; $horainicio < 23; ++$horainicio) {
    $opcionesInicio .= "<option value='{$horainicio}:00'>{$horainicio}:00 hs</option>
                        <option value='{$horainicio}:30'>{$horainicio}:30 hs</option>";
}
for ($horafin = 11; $horafin < 24; ++$horafin) {
    $opcionesFin .= "<option value='{$horafin}:00'>{$horafin}:00 hs</option>
                     <option value='{$horafin}:30'>{$horafin}:30 hs</option>";
}

$filas = "";
for ($dia = 1; $dia < 7; ++$dia) {
    $nombreDia = Util::obtenerNombreDia($dia);
    $filas .= '
        <tr name="' . $dia . '">
            <td class="align-middle text-center">
                <input type="checkbox" class="clases" id="clases" name="cbClases[]" value="' . $dia . '">
            </td>
            <td class="align-middle">' . $nombreDia . '</td>
            <td class="align-middle">
                <select class="form-control horaInicio" 
                        id="horaInicio' . $dia . '" name="horaInicio' . $dia . '" disabled>' . $opcionesInicio . '</select>
            </td>
            <td class="align-middle">
                <select class="form-control horaFin" 
                        id="horaFin' . $dia . '" name="horaFin' . $dia . '" disabled>' . $opcionesFin . '</select>
            </td>
            <td class="align-middle">
                <select class="form-control aula" style="width:100%" data-width="100%"
                        name="aula' . $dia . '" id="aula' . $dia . '" 
                        disabled required>
                </select>
            </td>
        </tr>';
}
?>
<div class="container-fluid" id="contenido">
    <div class="container">
        <div class="form-row mt-4 mb-4">
            <div class="col text-left">
                <h4><i class="far fa-clock"></i> CREAR HORARIO DE CURSADA</h4>
            </div>
            <div class="col text-right">
                <a href="../../principal/vista/home.php">
                    <button class="btn btn-sm btn-outline-secondary"> 
                        <i class="fas fa-times"></i> CERRAR
                    </button>
                </a>
            </div>
        </div>
        <div id="seccionResultado"></div>
        <div id="seccionFormulario">
            <form id="formCrearCursada" name="formCrearCursada" method="POST">
                <div class="card border-dark">
                    <div class="card-header bg-dark text-white">Seleccione asignatura</div>
                    <div class="card-body">
                        <div class="form-row  table-responsive">
                            <label for="plan" class="col-sm-2 col-form-label">* Asignatura:</label>
                            <div class="col">
                                <select class="form-control mb-2" name="plan" id="plan"  required></select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-2 border-dark">
                    <div class="card-header bg-dark text-white">Complete los horarios de cursada</div>
                    <div class="card-body">
                        <div class="table-responsive mt-4">
                            <table class="table" cellspacing="0" style="width:100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Día de la semana</th>
                                        <th>Hora de inicio</th>
                                        <th>Hora de fin</th>
                                        <th>Aula</th>
                                    </tr>
                                </thead>
                                <tbody> <?= $filas; ?> </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="form-row mt-2 mb-4">
                    <div class="col text-right">
                        <button type="submit" class="btn btn-success" 
                                id="btnCrearCursada" title="Guardar datos">
                            <i class="far fa-save"></i> GUARDAR
                        </button>
                        <a href="FormBuscarCursada.php">
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
<script type="text/javascript" src="../js/CrearCursada.js"></script>
<?php
include_once '../../principal/vista/footer.php';