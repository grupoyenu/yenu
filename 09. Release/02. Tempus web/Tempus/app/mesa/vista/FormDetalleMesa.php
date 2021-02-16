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

            $nombreCortoAsignatura = $asignatura->getNombreCorto();
            $nombreLargoAsignatura = $asignatura->getNombreLargo();
            $nombreCortoCarrera = $carrera->getNombreCorto();
            $nombreLargoCarrera = $carrera->getNombreLargo();

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
                <div class="card border-dark mb-2">
                    <div class="card-header bg-dark text-white">Seleccione asignatura</div>
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
                <div class="card border-dark mb-2" title="Las modificaciones sobre el tribunal no generan alertas en la APP">
                    <div class="card-header bg-dark text-white">Integrantes del tribunal</div>
                    <div class="card-body">
                        <div class="form-row">
                            <label for="presidente" class="col-sm-2 col-form-label">Presidente:</label>
                            <div class="col mb-2">
                                <input class="form-control" value="' . $presidente->getNombre() . '" disabled>
                            </div>
                            <label for="vocal1" class="col-sm-2 col-form-label">Vocal primero:</label>
                            <div class="col mb-2">
                                <input class="form-control" value="' . $vocal1->getNombre() . '" disabled>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="vocal2" class="col-sm-2 col-form-label">Vocal segundo:</label>
                            <div class="col mb-2">
                                <input class="form-control" value="' . $nombreVocal2 . '" disabled>
                            </div>
                            <label for="suplente" class="col-sm-2 col-form-label">Suplente:</label>
                            <div class="col mb-2">
                                <input class="form-control" value="' . $nombreSuplente . '" disabled>
                            </div>
                        </div>
                    </div>
                </div>';

            if ($cantidad == 1) {
                $primerLlamado = $mesaExamen->getPrimerLlamado();

                $sectorAulaPL = $nombreAulaPL = $idPL = "";
                if ($primerLlamado) {
                    $idPL = $primerLlamado->getId();
                    $estadoPL = $primerLlamado->getEstado();
                    $fechaPL = date_format(date_create($primerLlamado->getFecha()), 'd/m/Y');
                    $horaPL = substr($primerLlamado->getHora(), 0, 5);
                    $aulaPL = $primerLlamado->getAula();
                    $fechaCreacionPL = date_format(date_create($primerLlamado->getFechaCreacion()), 'd/m/Y H:m');
                    $fechaEdicionPL = ($primerLlamado->getFechaEdicion()) ? date_format(date_create($primerLlamado->getFechaEdicion()), 'd/m/Y H:m') : '';
                    if ($aulaPL) {
                        $sectorAulaPL = $aulaPL->getSector();
                        $nombreAulaPL = $aulaPL->getNombre();
                    }

                    $formulario .= '
                        <div class="card border-dark mb-2">
                            <div class="card-header bg-dark text-white">Información del primer llamado</div>
                            <div class="card-body">
                                <div class="form-row">
                                    <label class="col-sm-2 col-form-label">Fecha:</label>
                                    <div class="col">
                                        <input type="text" class="form-control mb-2" value="' . $fechaPL . '" disabled>
                                    </div>
                                    <label class="col-sm-2 col-form-label">Hora:</label>
                                    <div class="col">
                                    <input type="text" class="form-control mb-2" value="' . $horaPL . '" disabled>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label class="col-sm-2 col-form-label">Sector:</label>
                                    <div class="col">
                                        <input type="text" class="form-control mb-2" value="' . $sectorAulaPL . '" disabled>
                                    </div>
                                    <label class="col-sm-2 col-form-label">Aula:</label>
                                    <div class="col">
                                        <input type="text" class="form-control mb-2" value="' . $nombreAulaPL . '" disabled>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label class="col-sm-2 col-form-label">Estado: </label>
                                    <div class="col">
                                        <input type="text" class="form-control mb-2" value="' . $estadoPL . '" disabled>
                                    </div>
                                    <label class="col-sm-2 col-form-label"></label>
                                    <div class="col"></div>
                                </div>
                                <div class="form-row">
                                    <label class="col-sm-2 col-form-label">Fecha de creación: </label>
                                    <div class="col">
                                        <input type="text" class="form-control mb-2" value="' . $fechaCreacionPL . '" disabled>
                                    </div>
                                    <label class="col-sm-2 col-form-label">Fecha de edición: </label>
                                    <div class="col">
                                        <input type="text" class="form-control mb-2" value="' . $fechaEdicionPL . '" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>';
                }
            } else {
                /* SE ADAPTA EL FORMULARIO PARA DOS LLAMADOS */

                $primerLlamado = $mesaExamen->getPrimerLlamado();
                $segundoLlamado = $mesaExamen->getSegundoLlamado();

                $sectorAulaPL = $nombreAulaPL = $idPL = "";
                if ($primerLlamado) {
                    $idPL = $primerLlamado->getId();
                    $estadoPL = $primerLlamado->getEstado();
                    $fechaPL = date_format(date_create($primerLlamado->getFecha()), 'd/m/Y');
                    $horaPL = substr($primerLlamado->getHora(), 0, 5);
                    $aulaPL = $primerLlamado->getAula();
                    $fechaCreacionPL = date_format(date_create($primerLlamado->getFechaCreacion()), 'd/m/Y H:m');
                    $fechaEdicionPL = ($primerLlamado->getFechaEdicion()) ? date_format(date_create($primerLlamado->getFechaEdicion()), 'd/m/Y H:m') : '';
                    if ($aulaPL) {
                        $sectorAulaPL = $aulaPL->getSector();
                        $nombreAulaPL = $aulaPL->getNombre();
                    }

                    $formulario .= '
                        <div class="card border-dark mb-2">
                            <div class="card-header bg-dark text-white">Información del primer llamado</div>
                            <div class="card-body">
                                <div class="form-row">
                                    <label class="col-sm-2 col-form-label">Fecha:</label>
                                    <div class="col">
                                        <input type="text" class="form-control mb-2" value="' . $fechaPL . '" disabled>
                                    </div>
                                    <label class="col-sm-2 col-form-label">Hora:</label>
                                    <div class="col">
                                    <input type="text" class="form-control mb-2" value="' . $horaPL . '" disabled>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label class="col-sm-2 col-form-label">Sector:</label>
                                    <div class="col">
                                        <input type="text" class="form-control mb-2" value="' . $sectorAulaPL . '" disabled>
                                    </div>
                                    <label class="col-sm-2 col-form-label">Aula:</label>
                                    <div class="col">
                                        <input type="text" class="form-control mb-2" value="' . $nombreAulaPL . '" disabled>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label class="col-sm-2 col-form-label">Estado: </label>
                                    <div class="col">
                                        <input type="text" class="form-control mb-2" value="' . $estadoPL . '" disabled>
                                    </div>
                                    <label class="col-sm-2 col-form-label"></label>
                                    <div class="col"></div>
                                </div>
                                <div class="form-row">
                                    <label class="col-sm-2 col-form-label">Fecha de creación: </label>
                                    <div class="col">
                                        <input type="text" class="form-control mb-2" value="' . $fechaCreacionPL . '" disabled>
                                    </div>
                                    <label class="col-sm-2 col-form-label">Fecha de edición: </label>
                                    <div class="col">
                                        <input type="text" class="form-control mb-2" value="' . $fechaEdicionPL . '" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>';
                }

                $sectorAulaSL = $nombreAulaSL = $idSL = "";
                if ($segundoLlamado) {
                    $idSL = $segundoLlamado->getId();
                    $estadoSL = $segundoLlamado->getEstado();
                    $fechaSL = date_format(date_create($segundoLlamado->getFecha()), 'd/m/Y');
                    $horaSL = substr($segundoLlamado->getHora(), 0, 5);
                    $aulaSL = $segundoLlamado->getAula();
                    $fechaCreacionSL = date_format(date_create($segundoLlamado->getFechaCreacion()), 'd/m/Y H:m');
                    $fechaEdicionSL = ($segundoLlamado->getFechaEdicion()) ? date_format(date_create($segundoLlamado->getFechaEdicion()), 'd/m/Y H:m') : '';

                    if ($aulaSL) {
                        $sectorAulaSL = $aulaSL->getSector();
                        $nombreAulaSL = $aulaSL->getNombre();
                    }

                    $formulario .= '
                        <div class="card border-dark mb-2">
                            <div class="card-header bg-dark text-white">Información del segundo llamado</div>
                            <div class="card-body">
                                <div class="form-row">
                                    <label for="fecha1" class="col-sm-2 col-form-label">Fecha:</label>
                                    <div class="col">
                                        <input type="text" class="form-control mb-2" value="' . $fechaSL . '" disabled>
                                    </div>
                                    <label for="vocal2" class="col-sm-2 col-form-label">Hora:</label>
                                    <div class="col">
                                    <input type="text" class="form-control mb-2" value="' . $horaSL . '" disabled>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label for="aula1" class="col-sm-2 col-form-label">Sector:</label>
                                    <div class="col">
                                        <input type="text" class="form-control mb-2" value="' . $sectorAulaSL . '" disabled>
                                    </div>
                                    <label for="aula1" class="col-sm-2 col-form-label">Aula:</label>
                                    <div class="col">
                                        <input type="text" class="form-control mb-2" value="' . $nombreAulaSL . '" disabled>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <label class="col-sm-2 col-form-label">Estado: </label>
                                    <div class="col">
                                        <input type="text" class="form-control mb-2" value="' . $estadoSL . '" disabled>
                                    </div>
                                    <label class="col-sm-2 col-form-label"></label>
                                    <div class="col"></div>
                                </div>
                                <div class="form-row">
                                    <label class="col-sm-2 col-form-label">Fecha de creación: </label>
                                    <div class="col">
                                        <input type="text" class="form-control mb-2" value="' . $fechaCreacionSL . '" disabled>
                                    </div>
                                    <label class="col-sm-2 col-form-label">Fecha de edición: </label>
                                    <div class="col">
                                        <input type="text" class="form-control mb-2" value="' . $fechaEdicionSL . '" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>';
                }
            }

            /* COMPLETA EL FORMULARIO */

            $formulario .= '
                <div class="card border-dark mb-2">
                    <div class="card-header bg-dark text-white">Datos generales</div>
                    <div class="card-body">
                        <div class="form-row">
                            <label for="fecha2" class="col-sm-2 col-form-label">Observación:</label>
                            <div class="col">
                                <textarea class="form-control mb-2" rows="3"
                                       name="observacion" id="observacion"
                                       placeholder="Observacion" disabled>' . $mesaExamen->getObservacion() . '</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row mt-2 mb-4">
                    <div class="col text-right">
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
            <h4><i class="far fa-calendar-alt"></i> DETALLE MESA DE EXAMEN</h4>
        </div>
        <div class="col text-right">
            <a href="../../principal/vista/home.php">
                <button class="btn btn-sm btn-outline-secondary" title="Cerrar página actual">
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