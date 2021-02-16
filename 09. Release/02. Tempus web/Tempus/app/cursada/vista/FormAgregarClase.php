<?php
/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\plan\modelo\Plan;
use app\principal\controlador\ControladorHTML;
use app\principal\modelo\AutoCargador;
use app\util\modelo\Util;

AutoCargador::cargarModulos();

/* INICIALIZA LA SESION PARA GUARDAR LOG */

session_start();

$contenido = $botones = "";
if (isset($_POST['idPlan'])) {
    $idPlan = $_POST['idPlan'];
    $plan = new Plan($idPlan);
    $datosPlan = $plan->obtenerPorIdentificador();
    $datosCursada = $plan->obtenerCursada();
    if (($datosPlan[0] == 2) && ($datosCursada[0] == 2)) {
        $asignatura = $plan->getAsignatura();
        $carrera = $plan->getCarrera();
        $cursada = $plan->getCursada();
        $nombreAsignatura = $asignatura->getNombreLargo() . " - " . $carrera->getNombreLargo();
        $clases = $cursada->getClases();
        $filas = "";

        $opcionesInicio = $opcionesFin = "";
        for ($hora = 10; $hora < 23; ++$hora) {
            $opcionesInicio .= "<option value='{$hora}:00'>{$hora}:00 hs</option>";
            $opcionesInicio .= "<option value='{$hora}:30'>{$hora}:30 hs</option>";
        }

        for ($hora = 11; $hora < 24; ++$hora) {
            $opcionesFin .= "<option value='{$hora}:00'>{$hora}:00 hs</option>";
            $opcionesFin .= "<option value='{$hora}:30'>{$hora}:30 hs</option>";
        }

        for ($dia = 1; $dia < 7; ++$dia) {


            $clase = isset($clases[$dia]) ? $clases[$dia] : NULL;
            $nombreDia = ($clase) ? $clase->getDiaSemana("NOMBRE") : Util::obtenerNombreDia($dia);

            $opcionAula = $cbBorrar = $cbEditar = "";
            if (!$clase) {

                $filas .= '
                    <tr name="' . $dia . '">
                        <td class="align-middle text-center">
                            <input type="checkbox" class="clases" id="clases" name="cbClases[]" value="' . $dia . '">
                        </td>
                        <td class="align-middle">' . $nombreDia . '</td>
                        <td class="align-middle">
                            <select class="form-control horaInicio" 
                                    id="horaInicio' . $dia . '" name="horaInicio' . $dia . '"
                                    disabled>' . $opcionesInicio . '</select>
                        </td>
                        <td class="align-middle">
                            <select class="form-control horaFin" 
                                    id="horaFin' . $dia . '" name="horaFin' . $dia . '"
                                    disabled>' . $opcionesFin . '</select>
                        </td>
                        <td class="align-middle">
                            <select class="form-control aula" style="width:100%" data-width="100%"
                                    name="aula' . $dia . '" id="aula' . $dia . '" 
                                    disabled required></select>
                        </td>
                    </tr>';
            }
        }

        $contenido = '
            <div class="card border-dark">
                <div class="card-header bg-dark text-white">Información de la asignatura</div>
                <div class="card-body">
                    <div class="form-row  table-responsive">
                        <label for="plan" class="col-sm-2 col-form-label">* Asignatura:</label>
                        <div class="col">
                            <select class="form-control mb-2" name="plan" id="plan" readonly>
                                <option value="' . $idPlan . '">' . $nombreAsignatura . '</option>
                            </select>
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
                            <tbody>' . $filas . '</tbody>
                        </table>
                    </div>
                </div>
            </div>';
        $botones = '
            <button type="submit" class="btn btn-success" 
                    id="btnModificarCursada" title="Guardar datos" disabled>
                    <i class="far fa-save"></i> GUARDAR
            </button>';
    } else {
        $titulo = "Información básica";
        $mensaje = "No se obtuvo la información del plan";
        $contenido = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $contenido = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}
?>
<div class="container">
    <div class="form-row mt-4 mb-4">
        <div class="col text-left">
            <h4><i class="far fa-clock"></i> AGREGAR CLASE A HORARIO DE CURSADA</h4>
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
        <form id="formModificarCursada" name="formModificarCursada" method="POST">
            <?= $contenido; ?>
            <div class="form-row">
                <div class="col text-right mt-2">
                    <?= $botones; ?>
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
<script type="text/javascript" src="../js/AgregarClase.js"></script>