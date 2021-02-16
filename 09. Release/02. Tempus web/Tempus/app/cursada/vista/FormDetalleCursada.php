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

        $nombreCortoAsignatura = $asignatura->getNombreCorto();
        $nombreLargoAsignatura = $asignatura->getNombreLargo();
        $nombreCortoCarrera = $carrera->getNombreCorto();
        $nombreLargoCarrera = $carrera->getNombreLargo();

        $clases = $cursada->getClases();
        $filas = "";
        for ($dia = 1; $dia < 7; ++$dia) {
            $opcionesInicio = $opcionesFin = $operaciones = "";
            $clase = isset($clases[$dia]) ? $clases[$dia] : NULL;
            $horaInicio = ($clase) ? substr($clase->getHoraInicio(), 0, 5) : "";
            $horaFin = ($clase) ? substr($clase->getHoraFin(), 0, 5) : "";
            $nombreDia = ($clase) ? $clase->getDiaSemana("NOMBRE") : Util::obtenerNombreDia($dia);

            $sector = $nombreAula = "";
            if ($clase) {
                $aula = $clase->getAula();
                $nombreAula = $aula->getNombre();
                $sector = $aula->getSector();
            }
            $filas .= "
                <tr>
                    <td class='align-middle'>$nombreDia</td>
                    <td class='align-middle'>$horaInicio</td>
                    <td class='align-middle'>$horaFin</td>
                    <td class='align-middle'>$sector</td>
                    <td class='align-middle'>$nombreAula</td>
                </tr>";
        }

        $contenido = '
            <div class="card border-dark">
                <div class="card-header bg-dark text-white">Información básica</div>
                <div class="card-body">
                    <div class="form-row">
                        <label class="col-sm-2 col-form-label">Nombre corto:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"
                                   value="' . $nombreCortoAsignatura . '"
                                   placeholder="Nombre corto"
                                   title="Nombre corto de la asignatura" disabled>
                        </div>
                        <label for="nombre" class="col-sm-2 col-form-label">Nombre largo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"
                                   value="' . $nombreLargoAsignatura . '"
                                   title = "Nombre largo de la asignatura" disabled>
                        </div>
                    </div>
                    <div class="form-row">
                        <label class="col-sm-2 col-form-label">Nombre corto:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"
                                   value="' . $nombreCortoCarrera . '"
                                   placeholder="Nombre corto"
                                   title="Nombre corto de la carrera" disabled>
                        </div>
                        <label for="nombre" class="col-sm-2 col-form-label">Nombre largo:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"
                                   value="' . $nombreLargoCarrera . '"
                                   title = "Nombre largo de la carrera" disabled>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-2 border-dark">
                <div class="card-header bg-dark text-white">Horarios de cursada</div>
                <div class="card-body">
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered table-hover" cellspacing="0" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Día de la semana</th>
                                    <th>Hora de inicio</th>
                                    <th>Hora de fin</th>
                                    <th>Sector</th>
                                    <th>Aula</th>
                                </tr>
                            </thead>
                            <tbody>' . $filas . '</tbody>
                        </table>
                    </div>
                </div>
            </div>';
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
            <h4><i class="far fa-clock"></i> DETALLE HORARIO DE CURSADA</h4>
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