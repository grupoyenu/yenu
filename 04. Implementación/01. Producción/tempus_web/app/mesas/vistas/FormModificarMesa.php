<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$contenido = $botones = "";
if (isset($_POST['idMesa'])) {

    $controlador = new ControladorMesa();
    $cantidad = $controlador->obtenerCantidadLlamados();
    if ($cantidad > 0) {

        $mesaExamen = new MesaExamen($_POST['idMesa']);
        $resultado = $mesaExamen->obtener();

        if (gettype($resultado) == "array") {

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
                <div class="card border-dark">
                    <div class="card-header bg-dark text-white">Seleccione asignatura</div>
                    <div class="card-body">
                        <div class="form-row">
                            <label for="carrera" class="col-sm-2 col-form-label">* Carrera:</label>
                            <div class="col">
                                <select class="form-control mb-2" name="carrera" id="carrera" disabled></select>
                            </div>
                            <label for="carrera" class="col-sm-2 col-form-label">* Asignatura:</label>
                            <div class="col">
                                <select class="form-control mb-2" name="asignatura" id="asignatura" disabled></select>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="card border-dark">
                    <div class="card-header bg-dark text-white">Seleccione los integrantes del tribunal</div>
                    <div class="card-body">
                        <form method="POST" name="formModificarTribunal" id="formModificarTribunal">
                            <input type="hidden" name="idTribunal" id="idTribunal" value="">
                            <div class="form-row">
                                <label for="presidente" class="col-sm-2 col-form-label">* Presidente:</label>
                                <div class="col">
                                    <select class="form-control mb-2" name="presidente" id="presidente"></select>
                                </div>
                                <label for="vocal1" class="col-sm-2 col-form-label">* Vocal primero:</label>
                                <div class="col">
                                    <select class="form-control mb-2" name="vocal1" id="vocal1" disabled></select>
                                </div>
                            </div>
                            <div class="form-row">
                                <label for="vocal2" class="col-sm-2 col-form-label">Vocal segundo:</label>
                                <div class="col">
                                    <select class="form-control mb-2" name="vocal2" id="vocal2" disabled></select>
                                </div>
                                <label for="suplente" class="col-sm-2 col-form-label">Suplente:</label>
                                <div class="col">
                                    <select class="form-control mb-2" name="suplente" id="suplente" disabled></select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <br>
                <div class="card border-dark">
                    <div class="card-header bg-dark text-white">Complete los datos del primer llamado</div>
                    <div class="card-body">
                        <form method="POST" name="formModificarLlamado1" id="formModificarLlamado1">
                            <input type="hidden" name="numeroLlamado" id="numeroLlamado" value="1">
                            <input type="hidden" name="idLlamado1" id="idLlamado1" value="">
                            <div class="form-row">
                                <label for="fecha1" class="col-sm-2 col-form-label">* Fecha:</label>
                                <div class="col">
                                    <input type="date" class="form-control mb-2" 
                                           value="' . $fechaHoy . '" min="' . $fechaHoy . '"
                                           name="fecha1" id="fecha1" required>
                                </div>
                                <label for="vocal2" class="col-sm-2 col-form-label">* Hora:</label>
                                <div class="col">
                                    <select class="form-control mb-2">' . $opcionesHora . '</select>
                                </div>
                            </div>
                            <div class="form-row">
                                <label for="aula1" class="col-sm-2 col-form-label">Aula:</label>
                                <div class="col">
                                    <select class="form-control mb-2" name="aula1" id="aula1"></select>
                                </div>
                                 <label class="col-sm-2 col-form-label"></label>
                                <div class="col"></div>
                            </div>
                            <div class="form-row">
                                <label class="col-sm-2 col-form-label">Operaciones:</label>
                                <div class="col">
                                    <select class="form-control mb-2" name="aula1" id="aula1"></select>
                                </div>
                                 <label class="col-sm-2 col-form-label"></label>
                                <div class="col"></div>
                            </div>
                        </form>
                    </div>
                </div>';
            if ($cantidad == 2) {
                $fechaSegundo = date("Y-m-d", strtotime('+3 days', strtotime($fechaHoy)));
                $formulario .= '<br>
                    <div class="card border-dark">
                        <div class="card-header bg-dark text-white">Complete los datos del segundo llamado</div>
                        <div class="card-body">
                            <form method="POST" name="formModificarLlamado2" id="formModificarLlamado2">
                                <input type="hidden" name="numeroLlamado" id="numeroLlamado" value="2">
                                <input type="hidden" name="idLlamado2" id="idLlamado2" value="">
                                <div class="form-row">
                                    <label for="fecha2" class="col-sm-2 col-form-label">* Fecha y hora:</label>
                                    <div class="col">
                                        <input type="date" class="form-control mb-2" 
                                               name="fecha2" id="fecha2"
                                               value="' . $fechaSegundo . '" min="' . $fechaSegundo . '" required>
                                    </div>
                                    <div class="col">
                                        <select class="form-control mb-2" name="hora2" id="hora2">' . $opcionesHora . '</select>
                                    </div>
                                    <div class="col-1 text-right"></div>
                                </div>
                                <div class="form-row">
                                    <label for="aula2" class="col-sm-2 col-form-label">Aula:</label>
                                    <div class="col">
                                        <select class="form-control mb-2" name="aula2" id="aula2"></select>
                                    </div>
                                     <label class="col-sm-2 col-form-label"></label>
                                    <div class="col"></div>
                                </div>
                            </form>
                        </div>
                    </div>';
            }
            $formulario .= '
                <div class="form-row mt-2 mb-4">
                    <div class="col text-right">
                        <button type="submit" class="btn btn-success" 
                                id="btnCrearMesa" title="Guardar datos">
                            <i class="far fa-save"></i> GUARDAR
                        </button>
                        <a href="mesa_buscar">
                            <button type="button" class="btn btn-outline-info">
                                <i class="fas fa-search"></i> BUSCAR
                            </button>
                        </a>
                    </div>
                </div>';
        } else {
            $titulo = "Información básica";
            $contenido = ControladorHTML::mostrarAlertaResultadoOperacion(0, $controlador->getDescripcion());
            $formulario = ControladorHTML::mostrarCard($titulo, $contenido);
        }
    } else {
        $titulo = "Información básica";
        $contenido = ControladorHTML::mostrarAlertaResultadoOperacion(0, $controlador->getDescripcion());
        $formulario = ControladorHTML::mostrarCard($titulo, $contenido);
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
        <div class="col text-left"><h4><i class="far fa-calendar-alt"></i> MODIFICAR MESA DE EXAMEN</h4></div>
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
        <?= $formulario; ?>
    </div>
</div>
<script type="text/javascript" src="./app/mesas/js/ModificarMesa.js"></script>