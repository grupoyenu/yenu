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



            $formulario = '
                <input type="hidden" name="cantidadLlamados" id="cantidadLlamados" value="' . $cantidad . '">
                <div class="card border-dark">
                    <div class="card-header bg-dark text-white">Información básica</div>
                    <div class="card-body">
                        <div class="form-row">
                            <label for="carrera" class="col-sm-2 col-form-label">* Carrera:</label>
                            <div class="col">
                                <input class="form-control mb-2" name="carrera" id="carrera"
                                        value="' . $resultado['nombreCarrera'] . '" disabled>
                            </div>
                            <label for="carrera" class="col-sm-2 col-form-label">* Asignatura:</label>
                            <div class="col">
                                <input class="form-control mb-2" name="asignatura" id="asignatura" 
                                       value="' . $resultado['nombreAsignatura'] . '" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="card border-dark" title="Las modificaciones sobre el tribunal no generan alertas en la APP">
                    <div class="card-header bg-dark text-white">Integrantes del tribunal</div>
                    <div class="card-body">
                        <form method="POST" name="formModificarTribunal" id="formModificarTribunal">
                            <input type="hidden" name="idTribunal" id="idTribunal" value="' . $resultado['idtribunal'] . '">
                            <div class="form-row">
                                <label for="presidente" class="col-sm-2 col-form-label">* Presidente:</label>
                                <div class="col">
                                    <select class="form-control mb-2" name="presidente" id="presidente">
                                        <option value="' . $resultado['idPresidente'] . '">' . $resultado['nombrePresidente'] . '</option>
                                    </select>
                                </div>
                                <label for="vocal1" class="col-sm-2 col-form-label">* Vocal primero:</label>
                                <div class="col">
                                    <select class="form-control mb-2" name="vocal1" id="vocal1">
                                        <option value="' . $resultado['idVocalPri'] . '">' . $resultado['nombreVocalPri'] . '</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <label for="vocal2" class="col-sm-2 col-form-label">Vocal segundo:</label>
                                <div class="col">
                                    <select class="form-control mb-2" name="vocal2" id="vocal2">
                                        <option value="' . $resultado['idVocalSeg'] . '">' . $resultado['nombreVocalSeg'] . '</option>
                                    </select>
                                </div>
                                <label for="suplente" class="col-sm-2 col-form-label">Suplente:</label>
                                <div class="col">
                                    <select class="form-control mb-2" name="suplente" id="suplente">
                                        <option value="' . $resultado['idSuplente'] . '">' . $resultado['nombreSuplente'] . '</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <label class="col-sm-2 col-form-label">Operación:</label>
                                <div class="col">
                                    <button class="btn btn-success mb-2" title="Modificar"
                                            id="btnModificarTribunal" name="btnModificarTribunal" disabled>
                                        <i class="far fa-edit"></i> MODIFICAR
                                    </button>
                                </div>
                                 <label class="col-sm-2 col-form-label"></label>
                                <div class="col"></div>
                            </div>
                        </form>
                    </div>
                </div>
                <br>
                ';
            if ($cantidad == 1) {
                // SE ADAPTAN LAS OPCIONES DEL FORMULARIO PARA UN SOLO LLAMADO
                $opcionesHora = "";
                for ($hora = 10; $hora < 23; ++$hora) {
                    $selected = ($resultado['horaPri'] == $hora . ":00:00") ? "selected" : "";
                    $opcionesHora .= "<option value='{$hora}:00' $selected>{$hora}:00 hs</option>";
                }

                $formulario .= '
                    <div class="card border-dark" title="Las modificaciones sobre el llamado generan alertas en la APP">
                    <div class="card-header bg-dark text-white">Información del primer llamado</div>
                    <div class="card-body">
                        <form method="POST" name="formModificarLlamado1" id="formModificarLlamado1">
                            <input type="hidden" name="numeroLlamado" id="numeroLlamado" value="1">
                            <input type="hidden" name="idLlamado1" id="idLlamado1" value="' . $resultado['idLlamadoPri'] . '">
                            <div class="form-row">
                                <label for="fecha1" class="col-sm-2 col-form-label">* Fecha:</label>
                                <div class="col">
                                    <input type="date" class="form-control mb-2" 
                                           value="' . $fechaHoy . '" min="' . $fechaHoy . '"
                                           name="fecha1" id="fecha1" required>
                                </div>
                                <label for="hora1" class="col-sm-2 col-form-label">* Hora:</label>
                                <div class="col">
                                    <select class="form-control mb-2" id="hora1" name="hora1">' . $opcionesHora . '</select>
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
                                <label class="col-sm-2 col-form-label">Operación:</label>
                                <div class="col">
                                    <button class="btn btn-success mb-2" title="Modificar"
                                            id="btnModificarLlamado1" name="btnModificarLlamado1" disabled>
                                        <i class="far fa-edit"></i> MODIFICAR
                                    </button>
                                </div>
                                 <label class="col-sm-2 col-form-label"></label>
                                <div class="col"></div>
                            </div>
                        </form>
                    </div>
                </div>';
            } else {
                // SE ADAPTA EL FORMULARIO PARA DOS LLAMADOS
                $fechaSegundo = date("Y-m-d", strtotime('+3 days', strtotime($fechaHoy)));

                $opcionesHora1 = $opcionesHora2 = "";
                for ($hora = 10; $hora < 23; ++$hora) {
                    $selected = ($resultado['horaPri'] == $hora . ":00:00") ? "selected" : "";
                    $opcionesHora1 .= "<option value='{$hora}:00' $selected>{$hora}:00 hs</option>";
                }

                for ($hora = 10; $hora < 23; ++$hora) {
                    $selected = ($resultado['horaSeg'] == $hora . ":00:00") ? "selected" : "";
                    $opcionesHora2 .= "<option value='{$hora}:00' $selected>{$hora}:00 hs</option>";
                }

                $formulario .= '
                    <div class="card border-dark" title="Las modificaciones sobre el llamado generan alertas en la APP">
                        <div class="card-header bg-dark text-white">Información del primer llamado</div>
                        <div class="card-body">
                            <form method="POST" name="formModificarLlamado1" id="formModificarLlamado1">
                                <input type="hidden" name="numeroLlamado" id="numeroLlamado" value="1">
                                <input type="hidden" name="idLlamado1" id="idLlamado1" value="' . $resultado['idLlamadoPri'] . '">
                                <div class="form-row">
                                    <label for="fecha1" class="col-sm-2 col-form-label">* Fecha:</label>
                                    <div class="col">
                                        <input type="date" class="form-control mb-2" 
                                               value="' . $fechaHoy . '" min="' . $fechaHoy . '"
                                               name="fecha1" id="fecha1" required>
                                    </div>
                                    <label for="vocal2" class="col-sm-2 col-form-label">* Hora:</label>
                                    <div class="col">
                                        <select class="form-control mb-2" id="hora1" name="hora1">' . $opcionesHora1 . '</select>
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
                                    <label class="col-sm-2 col-form-label">Operación:</label>
                                    <div class="col">
                                        <button class="btn btn-success mb-2" title="Modificar"
                                                id="btnModificarLlamado1" name="btnModificarLlamado1" disabled>
                                            <i class="far fa-edit"></i> MODIFICAR
                                        </button>
                                    </div>
                                     <label class="col-sm-2 col-form-label"></label>
                                    <div class="col"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <br>
                    <div class="card border-dark" title="Las modificaciones sobre el llamado generan alertas en la APP">
                        <div class="card-header bg-dark text-white">Información del segundo llamado</div>
                        <div class="card-body">
                            <form method="POST" name="formModificarLlamado2" id="formModificarLlamado2">
                                <input type="hidden" name="numeroLlamado" id="numeroLlamado" value="2">
                                <input type="hidden" name="idLlamado2" id="idLlamado2" value="' . $resultado['idLlamadoSeg'] . '">
                                <div class="form-row">
                                    <label for="fecha2" class="col-sm-2 col-form-label">* Fecha y hora:</label>
                                    <div class="col">
                                        <input type="date" class="form-control mb-2" 
                                               name="fecha2" id="fecha2"
                                               value="' . $fechaSegundo . '" min="' . $fechaSegundo . '" required>
                                    </div>
                                    <div class="col">
                                        <select class="form-control mb-2" name="hora2" id="hora2">' . $opcionesHora2 . '</select>
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
                                <div class="form-row">
                                    <label class="col-sm-2 col-form-label">Operación:</label>
                                    <div class="col">
                                        <button class="btn btn-success mb-2" title="Modificar"
                                                id="btnModificarLlamado2" name="btnModificarLlamado2" disabled>
                                            <i class="far fa-edit"></i> MODIFICAR
                                        </button>
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