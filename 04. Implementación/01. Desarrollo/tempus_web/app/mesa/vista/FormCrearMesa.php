<?php
/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

include_once '../../principal/vista/header.php';
require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\mesa\controlador\ControladorMesa;
use app\principal\controlador\ControladorHTML;
use app\principal\modelo\AutoCargador;

AutoCargador::cargarModulos();

/* INICIA EL CODIGO CON LA FUNCIONALIDAD PROPIA */

$controlador = new ControladorMesa();
$cantidad = $controlador->obtenerNumeroDeLlamados();
if ($cantidad > 0) {

    // ESTABLECE COMO VALOR PREDETERMINADO LA FECHA DEL DIA PARA SELECCIONAR

    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $fechaHoy = date("Y-m-d");

    // CARGA EL RANGO DE HORARIO PARA SELECCIONAR

    $opcionesHora = "";
    for ($hora = 10; $hora < 23; ++$hora) {
        $opcionesHora .= "<option value='{$hora}:00'>{$hora}:00 hs</option>";
    }

    $formulario = '
        <input type="hidden" name="cantidadLlamados" id="cantidadLlamados" value="' . $cantidad . '">
        <div class="card border-dark mb-2">
            <div class="card-header bg-dark text-white">Seleccione asignatura</div>
            <div class="card-body">
                <div class="form-row">
                    <label for="plan" class="col-sm-2 col-form-label"
                           title="Caracter obligatorio">* Asignatura:</label>
                    <div class="col">
                        <select class="form-control mb-2" 
                                title="Escriba el nombre de la asignatura para seleccionarla"
                                name="plan" id="plan" required></select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-dark mb-2">
            <div class="card-header bg-dark text-white">Seleccione los integrantes del tribunal</div>
            <div class="card-body">
                <div class="form-row">
                    <label for="presidente" class="col-sm-2 col-form-label"
                           title="Caracter obligatorio">* Presidente:</label>
                    <div class="col">
                        <select class="form-control mb-2" 
                                name="presidente" id="presidente"
                                title="Escriba el nombre del docente para seleccionarlo"
                                required></select>
                    </div>
                    <label for="vocal1" class="col-sm-2 col-form-label"
                           title="Caracter obligatorio">* Vocal primero:</label>
                    <div class="col">
                        <select class="form-control mb-2" 
                                name="vocal1" id="vocal1" 
                                title="Escriba el nombre del docente para seleccionarlo"
                                required disabled></select>
                    </div>
                </div>
                <div class="form-row">
                    <label for="vocal2" class="col-sm-2 col-form-label"
                           title="Caracter no obligatorio">Vocal segundo:</label>
                    <div class="col">
                        <select class="form-control mb-2"
                                name="vocal2" id="vocal2" 
                                title="Escriba el nombre del docente para seleccionarlo" 
                                disabled></select>
                    </div>
                    <label for="suplente" class="col-sm-2 col-form-label"
                           title="Caracter no obligatorio">Suplente:</label>
                    <div class="col">
                        <select class="form-control mb-2" 
                                name="suplente" id="suplente"
                                title="Escriba el nombre del docente para seleccionarlo" 
                                disabled></select>
                    </div>
                </div>
            </div>
        </div>';
    if ($cantidad == 1) {

        /* CUANDO HAY UN SOLO LLAMADO LOS CAMPOS FECHA Y HORA SON OBLIGATORIOS */

        $formulario .= '
            <div class="card border-dark mb-2">
                <div class="card-header bg-dark text-white">Complete los datos del primer llamado</div>
                <div class="card-body">
                    <input type="hidden" name="hayPrimerLlamado" id="hayPrimerLlamado" value="TRUE">
                    <div class="form-row">
                        <label for="fecha1" class="col-sm-2 col-form-label"
                               title="Caracter obligatorio">* Fecha:</label>
                        <div class="col">
                            <input type="date" class="form-control mb-2" 
                                   value="' . $fechaHoy . '" min="' . $fechaHoy . '"
                                   title="Seleccione la fecha del llamado"
                                   name="fecha1" id="fecha1" required>
                        </div>
                        <label for="vocal2" class="col-sm-2 col-form-label"
                               title="Caracter obligatorio">* Hora:</label>
                        <div class="col">
                            <select class="form-control mb-2" 
                                    title="Seleccione la hora del llamado"
                                    name="hora1" id="hora1">' . $opcionesHora . '</select>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="aula1" class="col-sm-2 col-form-label"
                               title="Caracter no obligatorio">Aula:</label>
                        <div class="col">
                            <select class="form-control mb-2" 
                                    name="aula1" id="aula1"
                                    title="Escriba el nombre del aula para seleccionarla"></select>
                        </div>
                         <label class="col-sm-2 col-form-label"></label>
                        <div class="col"></div>
                    </div>
                </div>
            </div>';
    } else {
        /* CUANDO HAY DOS LLAMADOS LOS CAMPOS FECHA Y HORA NO SON OBLIGATORIOS */

        $fechaSegundo = date("Y-m-d", strtotime('+3 days', strtotime($fechaHoy)));
        $formulario .= '
                <div class="card border-dark mb-2">
                <div class="card-header bg-dark text-white">Complete los datos del primer llamado</div>
                <div class="card-body">
                    <input type="hidden" name="hayPrimerLlamado" id="hayPrimerLlamado" value="FALSE">
                    <div class="form-row">
                        <label for="fecha1" class="col-sm-2 col-form-label"
                               title="Caracter no obligatorio">Fecha:</label>
                        <div class="col">
                            <input type="date" class="form-control mb-2" 
                                   min="' . $fechaHoy . '"
                                   name="fecha1" id="fecha1"
                                   title="Seleccione la fecha del primer llamado">
                        </div>
                        <label for="vocal2" class="col-sm-2 col-form-label"
                               title="Caracter no obligatorio">Hora:</label>
                        <div class="col">
                            <select class="form-control mb-2" 
                                    name="hora1" id="hora1"
                                    title="Seleccione la hora del primer llamado">' . $opcionesHora . '</select>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="aula1" class="col-sm-2 col-form-label"
                               title="Caracter no obligatorio">Aula:</label>
                        <div class="col">
                            <select class="form-control mb-2" 
                                    name="aula1" id="aula1"
                                    title="Escriba el nombre del aula para seleccionarla"></select>
                        </div>
                         <label class="col-sm-2 col-form-label"></label>
                        <div class="col"></div>
                    </div>
                </div>
            </div>
            <div class="card border-dark mb-2">
                <div class="card-header bg-dark text-white">Complete los datos del segundo llamado</div>
                <div class="card-body">
                    <input type="hidden" name="haySegundoLlamado" id="haySegundoLlamado" value="FALSE">
                    <div class="form-row">
                        <label for="fecha2" class="col-sm-2 col-form-label"
                               title="Caracter no obligatorio">Fecha:</label>
                        <div class="col">
                            <input type="date" class="form-control mb-2" 
                                   name="fecha2" id="fecha2"
                                   min="' . $fechaSegundo . '"
                                   title="Seleccione la fecha del segundo llamado">
                        </div>
                        <label for="fecha2" class="col-sm-2 col-form-label"
                               title="Caracter no obligatorio">Hora:</label>
                        <div class="col">
                            <select class="form-control mb-2"
                                    title="Seleccione la hora del segundo llamado"
                                    name="hora2" id="hora2">' . $opcionesHora . '</select>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="aula2" class="col-sm-2 col-form-label"
                               title="Caracter no obligatorio">Aula:</label>
                        <div class="col">
                            <select class="form-control mb-2" 
                                    name="aula2" id="aula2"
                                    title="Escriba el nombre del aula para seleccionarla"></select>
                        </div>
                         <label class="col-sm-2 col-form-label"></label>
                        <div class="col"></div>
                    </div>
                </div>
            </div>';
    }
    $formulario .= '
        <div class="card border-dark mb-2">
            <div class="card-header bg-dark text-white">Información adicional</div>
            <div class="card-body">
                <div class="form-row">
                    <label for="observacion" class="col-sm-2 col-form-label"
                           title="Caracter no obligatorio">Observación:</label>
                    <div class="col">
                        <textarea class="form-control mb-2" 
                                  maxlength="300" 
                                  pattern="[A-Za-zÁÉÍÓÚÑáéíóú0-9.,%$¡!()¿?_-*+/#@ ]{0,300}"
                                  title = "Escriba la observación. Longitud máxima: 300 caracteres."
                                  placeholder="Observación"
                                  name="observacion" id="observacion"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-row mt-2 mb-4">
            <div class="col text-right">
                <button type="submit" class="btn btn-success" 
                        id="btnCrearMesa" title="Guardar datos">
                    <i class="far fa-save"></i> GUARDAR
                </button>
                <a href="FormBuscarMesa.php" title="Ir al formulario de búsqueda">
                    <button type="button" class="btn btn-outline-info">
                        <i class="fas fa-search"></i> BUSCAR
                    </button>
                </a>
            </div>
        </div>';
} else {
    $titulo = "Información básica";
    $mensaje = ($cantidad == -1) ? "Ocurrió un error al consultar cantidad de llamados" : "Debe importar mesas de examen antes de crear";
    $contenido = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
    $formulario = ControladorHTML::mostrarCard($titulo, $contenido);
}
?>
<div class="container-fluid" id="contenido">
    <div class="container">
        <div class="form-row mt-4 mb-4">
            <div class="col text-left"><h4><i class="far fa-calendar-alt"></i> CREAR MESA DE EXAMEN</h4></div>
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
            <form id="formCrearMesa" name="formCrearMesa" method="POST">
                <?= $formulario; ?>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="../js/CrearMesa.js"></script>

