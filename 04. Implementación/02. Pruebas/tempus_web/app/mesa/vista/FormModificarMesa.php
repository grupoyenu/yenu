<?php
/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\plan\modelo\Plan;
use app\mesa\controlador\ControladorMesa;
use app\principal\controlador\ControladorHTML;
use app\principal\modelo\AutoCargador;

AutoCargador::cargarModulos();

/* INICIALIZA LA SESION PARA GUARDAR LOG */

session_start();

$contenido = $botones = "";
if (isset($_POST['idPlan'])) {
    $controlador = new ControladorMesa();
    $cantidad = $controlador->obtenerNumeroDeLlamados();
    if ($cantidad > 0) {
        $idPlan = $_POST['idPlan'];
        $plan = new Plan($idPlan);
        $datosPlan = $plan->obtenerPorIdentificador();
        $datosMesa = $plan->obtenerMesaExamen();
        if (($datosPlan[0] == 2) && ($datosMesa[0] == 2)) {
            /* ESTABLECE COMO VALOR PREDETERMINADO LA FECHA DEL DIA PARA SELECCIONAR */
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $fechaHoy = date("Y-m-d");

            $mesaExamen = $plan->getMesa();
            $asignatura = $plan->getAsignatura();
            $carrera = $plan->getCarrera();
            $tribunal = $mesaExamen->getTribunal();
            $nombreAsignatura = $asignatura->getNombreLargo() . " - " . $carrera->getNombreLargo();

            /* DATOS DEL TRIBUNAL */

            $docentes = $tribunal->getDocentes();
            $presidente = $docentes[0];
            $vocal1 = $docentes[1];
            $idVocal2 = $nombreVocal2 = $idSuplente = $nombreSuplente = "";
            if (isset($docentes[2])) {
                $vocal2 = $docentes[2];
                $idVocal2 = $vocal2->getId();
                $nombreVocal2 = $vocal2->getNombre();
            }
            if (isset($docentes[3])) {
                $suplente = $docentes[3];
                $idSuplente = $suplente->getId();
                $nombreSuplente = $suplente->getNombre();
            }

            $formulario = '
                <input type="hidden" name="idMesaExamen" id="idMesaExamen" value="' . $mesaExamen->getId() . '">
                <div class="card border-dark mb-2">
                    <div class="card-header bg-dark text-white">Seleccione asignatura</div>
                    <div class="card-body">
                        <div class="form-row">
                            <label for="plan" class="col-sm-2 col-form-label">* Asignatura:</label>
                            <div class="col">
                                <select class="form-control mb-2" 
                                        name="plan" id="plan" disabled>
                                    <option value="' . $idPlan . '">' . $nombreAsignatura . '</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-dark mb-2" title="Las modificaciones sobre el tribunal no generan alertas en la APP">
                    <div class="card-header bg-dark text-white">Integrantes del tribunal</div>
                    <div class="card-body">
                        <input type="hidden" name="tribunalModificado" id="tribunalModificado" value="NO">
                        <input type="hidden" name="idTribunal" id="idTribunal" value="' . $tribunal->getId() . '">
                        <div class="form-row">
                            <label for="presidente" class="col-sm-2 col-form-label">* Presidente:</label>
                            <div class="col">
                                <select class="form-control mb-2 tribunal" name="presidente" id="presidente">
                                    <option value="' . $presidente->getId() . '">' . $presidente->getNombre() . '</option>
                                </select>
                            </div>
                            <label for="vocal1" class="col-sm-2 col-form-label">* Vocal primero:</label>
                            <div class="col">
                                <select class="form-control mb-2 tribunal" name="vocal1" id="vocal1">
                                     <option value="' . $vocal1->getId() . '">' . $vocal1->getNombre() . '</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="vocal2" class="col-sm-2 col-form-label">Vocal segundo:</label>
                            <div class="col">
                                <select class="form-control mb-2 tribunal" name="vocal2" id="vocal2">
                                     <option value="' . $idVocal2 . '">' . $nombreVocal2 . '</option>
                                </select>
                            </div>
                            <label for="suplente" class="col-sm-2 col-form-label">Suplente:</label>
                            <div class="col">
                                <select class="form-control mb-2 tribunal" name="suplente" id="suplente">
                                     <option value="' . $idSuplente . '">' . $nombreSuplente . '</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>';

            if ($cantidad == 1) {
                $idAula = $nombreAula = $opcionesHora = $opcionesEstado = "";
                $primerLlamado = $mesaExamen->getPrimerLlamado();
                $estado = $primerLlamado->getEstado();
                $aula = $primerLlamado->getAula();
                /* DATOS DEL AULA DEL LLAMADO */
                if ($aula) {
                    $idAula = $aula->getId();
                    $nombreAula = "{$aula->getSector()} - {$aula->getNombre()}";
                }
                /* DATOS DE LA HORA DEL LLAMADO */
                for ($hora = 10; $hora < 23; ++$hora) {
                    $selected = ($primerLlamado->getHora() == $hora . ":00:00") ? "selected" : "";
                    $opcionesHora .= "<option value='{$hora}:00' $selected>{$hora}:00 hs</option>";
                }
                /* DATOS DEL ESTADO DEL LLAMADO */
                $opcionesEstado = ($estado == "Activo") ? "<option value='Activo' selected>Activo</option>" : "<option value='Activo'>Activo</option>";
                $opcionesEstado .= ($estado == "Inactivo") ? "<option value='Inactivo' selected>Inactivo</option>" : "<option value='Inactivo'>Inactivo</option>";

                $formulario .= '
                    <div class="card border-dark mb-2" title="Las modificaciones sobre el llamado generan alertas en la APP">
                    <div class="card-header bg-dark text-white">Información del primer llamado</div>
                    <div class="card-body">
                        <input type="hidden" name="llamadoUnoModificado" id="llamadoUnoModificado" value="NO">
                        <input type="hidden" name="idLlamado1" id="idLlamado1" value="' . $primerLlamado->getId() . '">
                        <div class="form-row">
                            <label for="fecha1" class="col-sm-2 col-form-label">* Fecha:</label>
                            <div class="col">
                                <input type="date" class="form-control mb-2 llamadoUno" 
                                       value="' . $fechaHoy . '" min="' . $fechaHoy . '"
                                       name="fecha1" id="fecha1" required>
                            </div>
                            <label for="hora1" class="col-sm-2 col-form-label">* Hora:</label>
                            <div class="col">
                                <select class="form-control mb-2 llamadoUno" id="hora1" name="hora1">' . $opcionesHora . '</select>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="aula1" class="col-sm-2 col-form-label">Aula:</label>
                            <div class="col">
                                <select class="form-control mb-2 llamadoUno" name="aula1" id="aula1">
                                    <option value="' . $idAula . '">' . $nombreAula . '</option>
                                </select>
                            </div>
                            <label class="col-sm-2 col-form-label">* Estado: </label>
                            <div class="col">
                                <select class="form-control mb-2 llamadoUno" name="estado1" id="estado1">' . $opcionesEstado . '</select>
                            </div>
                        </div>
                    </div>
                </div>';
            } else {
                /* SE ADAPTA EL FORMULARIO PARA DOS LLAMADOS */

                $primerLlamado = $mesaExamen->getPrimerLlamado();
                $segundoLlamado = $mesaExamen->getSegundoLlamado();

                $disabledPL = $disabledSL = ""; // HABILITA PARA MODIFICAR LLAMADO

                $fechaPL = $fechaHoy;
                $fechaMinimaSL = date("Y-m-d", strtotime('+3 days', strtotime($fechaHoy)));
                $fechaSL = date("Y-m-d", strtotime('+3 days', strtotime($fechaHoy)));

                $opcionesHoraPL = "";
                for ($horaPL = 10; $horaPL < 23; ++$horaPL) {
                    $opcionesHoraPL .= "<option value='{$horaPL}:00'>{$horaPL}:00 hs</option>";
                }
                $opcionesHoraSL = $opcionesHoraPL;

                $opcionesEstadoPL = "<option value='Activo'>Activo</option><option value='Inactivo'>Inactivo</option>";
                $opcionesEstadoSL = $opcionesEstadoPL;

                $idAulaPL = $nombreAulaPL = $idPL = "";
                if ($primerLlamado) {
                    $idPL = $primerLlamado->getId();
                    $estadoPL = $primerLlamado->getEstado();
                    $fechaPL = $primerLlamado->getFecha();
                    $aulaPL = $primerLlamado->getAula();
                    if ($aulaPL) {
                        $idAulaPL = $aulaPL->getId();
                        $nombreAulaPL = "{$aulaPL->getSector()} - {$aulaPL->getNombre()}";
                    }
                    for ($horaPL = 10; $horaPL < 23; ++$horaPL) {
                        $selected = ($primerLlamado->getHora() == $horaPL . ":00:00") ? "selected" : "";
                        $opcionesHoraPL .= "<option value='{$horaPL}:00' $selected>{$horaPL}:00 hs</option>";
                    }
                    $opcionesEstadoPL = ($estadoPL == "Activo") ? "<option value='Activo' selected>Activo</option>" : "<option value='Activo'>Activo</option>";
                    $opcionesEstadoPL .= ($estadoPL == "Inactivo") ? "<option value='Inactivo' selected>Inactivo</option>" : "<option value='Inactivo'>Inactivo</option>";
                    if ($fechaHoy > $fechaPL) {
                        $disabledPL = "disabled";
                    }
                }

                $idAulaSL = $nombreAulaSL = $idSL = "";
                if ($segundoLlamado) {
                    $idSL = $segundoLlamado->getId();
                    $estadoSL = $segundoLlamado->getEstado();
                    $fechaSL = $segundoLlamado->getFecha();
                    $aulaSL = $segundoLlamado->getAula();
                    if ($aulaSL) {
                        $idAulaSL = $aulaSL->getId();
                        $nombreAulaSL = "{$aulaSL->getSector()} - {$aulaSL->getNombre()}";
                    }
                    for ($horaSL = 10; $horaSL < 23; ++$horaSL) {
                        $selected = ($segundoLlamado->getHora() == $horaSL . ":00:00") ? "selected" : "";
                        $opcionesHoraSL .= "<option value='{$horaSL}:00' $selected>{$horaSL}:00 hs</option>";
                    }
                    $opcionesEstadoSL = ($estadoSL == "Activo") ? "<option value='Activo' selected>Activo</option>" : "<option value='Activo'>Activo</option>";
                    $opcionesEstadoSL .= ($estadoSL == "Inactivo") ? "<option value='Inactivo' selected>Inactivo</option>" : "<option value='Inactivo'>Inactivo</option>";

                    if ($fechaHoy > $fechaSL) {
                        $disabledSL = "disabled";
                    }
                }

                $formulario .= '
                    <div class="card border-dark mb-2" title="Las modificaciones sobre el llamado generan alertas en la APP">
                        <div class="card-header bg-dark text-white">Información del primer llamado</div>
                        <div class="card-body">
                            <input type="hidden" name="llamadoUnoModificado" id="llamadoUnoModificado" value="NO">
                            <input type="hidden" name="idLlamado1" id="idLlamado1" value="' . $idPL . '">
                            <div class="form-row">
                                <label for="fecha1" class="col-sm-2 col-form-label">Fecha:</label>
                                <div class="col">
                                    <input type="date" class="form-control mb-2 llamadoUno" 
                                           value="' . $fechaPL . '" min="' . $fechaHoy . '"
                                           name="fecha1" id="fecha1" ' . $disabledPL . '>
                                </div>
                                <label for="vocal2" class="col-sm-2 col-form-label">Hora:</label>
                                <div class="col">
                                    <select class="form-control mb-2 llamadoUno" 
                                            id="hora1" name="hora1" ' . $disabledPL . '>
                                        ' . $opcionesHoraPL . '
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <label for="aula1" class="col-sm-2 col-form-label">Aula:</label>
                                <div class="col">
                                    <select class="form-control mb-2 llamadoUno" 
                                            name="aula1" id="aula1" ' . $disabledPL . '>
                                        <option value="' . $idAulaPL . '">' . $nombreAulaPL . '</option>
                                    </select>
                                </div>
                                <label class="col-sm-2 col-form-label">Estado: </label>
                                <div class="col">
                                    <select class="form-control mb-2 llamadoUno" 
                                            name="estado1" id="estado1" ' . $disabledPL . '>
                                        ' . $opcionesEstadoPL . '
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card border-dark mb-2" title="Las modificaciones sobre el llamado generan alertas en la APP">
                        <div class="card-header bg-dark text-white">Información del segundo llamado</div>
                        <div class="card-body">
                            <input type="hidden" name="llamadoDosModificado" id="llamadoDosModificado" value="NO">
                            <input type="hidden" name="idLlamado2" id="idLlamado2" value="' . $idSL . '">
                            <div class="form-row">
                                <label for="fecha2" class="col-sm-2 col-form-label">Fecha:</label>
                                <div class="col">
                                    <input type="date" class="form-control mb-2 llamadoDos" 
                                           value="' . $fechaSL . '" min="' . $fechaMinimaSL . '"
                                           name="fecha2" id="fecha2" ' . $disabledSL . '>
                                </div>
                                <label for="vocal2" class="col-sm-2 col-form-label">Hora:</label>
                                <div class="col">
                                    <select class="form-control mb-2 llamadoDos" 
                                            name="hora2" id="hora2" ' . $disabledSL . '> 
                                        ' . $opcionesHoraSL . '
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <label for="aula2" class="col-sm-2 col-form-label">Aula:</label>
                                <div class="col">
                                    <select class="form-control mb-2 llamadoDos" 
                                            name="aula2" id="aula2" ' . $disabledSL . '>
                                        <option value="' . $idAulaSL . '">' . $nombreAulaSL . '</option>
                                    </select>
                                </div>
                                <label class="col-sm-2 col-form-label">Estado: </label>
                                <div class="col">
                                    <select class="form-control mb-2 llamadoDos" 
                                            name="estado2" id="estado2" ' . $disabledSL . '>
                                        ' . $opcionesEstadoSL . '
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>';
            }

            /* COMPLETA EL FORMULARIO */

            $formulario .= '
                <div class="card border-dark mb-2">
                    <div class="card-header bg-dark text-white">Datos generales</div>
                    <div class="card-body">
                        <div class="form-row">
                            <label for="fecha2" class="col-sm-2 col-form-label">Observación:</label>
                            <div class="col">
                                <textarea class="form-control mb-2" 
                                       name="observacion" id="observacion"
                                       placeholder="Observacion">' . $mesaExamen->getObservacion() . '</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row mt-2 mb-4">
                    <div class="col text-right">
                        <button type="submit" class="btn btn-success" 
                                id="btnModificarMesa" title="Guardar datos" disabled>
                                <i class="far fa-save"></i> GUARDAR
                        </button>
                        <a href="FormBuscarMesa.php">
                            <button type="button" class="btn btn-outline-info">
                                <i class="fas fa-search"></i> BUSCAR
                            </button>
                        </a>
                    </div>
                </div>';
        } else {
            $titulo = "Información básica";
            $mensaje = "No se obtuvo la información del plan";
            $contenido = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
            $formulario = ControladorHTML::mostrarCard($titulo, $contenido);
        }
    }
} else {
    $titulo = "Información básica";
    $mensaje = "No se obtuvo la información desde el formulario";
    $contenido = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
    $formulario = ControladorHTML::mostrarCard($titulo, $contenido);
}
?>
<div class="container">
    <div class="form-row mt-4 mb-4">
        <div class="col text-left">
            <h4><i class="far fa-calendar-alt"></i> MODIFICAR MESA DE EXAMEN</h4>
        </div>
        <div class="col text-right">
            <a href="../../principal/vista/home.php">
                <button class="btn btn-sm btn-outline-secondary" 
                        title="Cerrar página actual"> 
                    <i class="fas fa-times"></i> CERRAR
                </button>
            </a>
        </div>
    </div>
    <div id="seccionResultado"></div>
    <div id="seccionFormulario">
        <form method="POST" name="formModificarMesa" id="formModificarMesa">
            <?= $formulario; ?>
        </form>
    </div>
</div>
<script type="text/javascript" src="../js/ModificarMesa.js"></script>