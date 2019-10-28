<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();

$contenido = $botones = "";
if (isset($_POST['idCarrera']) && isset($_POST['idAsignatura'])) {
    $cursada = new Cursada($_POST['idAsignatura'], $_POST['idCarrera']);
    $resultado = $cursada->obtener();
    if (gettype($resultado) == "array") {
        $filas = "";
        for ($dia = 1; $dia < 7; ++$dia) {
            $opcionesInicio = $opcionesFin = $operaciones = "";
            for ($horainicio = 10; $horainicio < 23; ++$horainicio) {
                $selected1 = ($resultado['desde' . $dia] == $horainicio . ":00") ? "selected" : "";
                $opcionesInicio .= "<option value='{$horainicio}:00' $selected1>{$horainicio}:00 hs</option>";
                $selected2 = ($resultado['desde' . $dia] == $horainicio . ":30") ? "selected" : "";
                $opcionesInicio .= "<option value='{$horainicio}:30' $selected2>{$horainicio}:30 hs</option>";
            }
            for ($horafin = 11; $horafin < 24; ++$horafin) {
                $selected1 = ($resultado['hasta' . $dia] == $horafin . ":00") ? "selected" : "";
                $opcionesFin .= "<option value='{$horafin}:00' $selected1>{$horafin}:00 hs</option>";
                $selected2 = ($resultado['hasta' . $dia] == $horafin . ":30") ? "selected" : "";
                $opcionesFin .= "<option value='{$horafin}:30' $selected2>{$horafin}:30 hs</option>";
            }

            if ($resultado['idClase' . $dia]) {
                $aula = '<input type="text" class="form-control" 
                                id="aula' . $dia . '" name="aula' . $dia . '" 
                                value="' . $resultado['sector' . $dia] . ' ' . utf8_encode($resultado['aula' . $dia]) . '"
                                placeholder="Nombre de aula" readonly>';
                $operaciones = '
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-info seleccionarAula" 
                                name="' . $dia . '"
                                title="Cambiar aula"><i class="far fa-hand-point-right"></i>
                        </button>
                        <button class="btn btn-outline-danger baja" 
                                name="' . $resultado['idClase' . $dia] . '" 
                                title="Dar de baja"><i class="fas fa-trash"></i>
                        </button>
                    </div>';
            } else {
                $aula = '<input type="text" class="form-control"
                        id="aula' . $dia . '" name="aula' . $dia . '"  
                        placeholder="Nombre de aula" readonly>';
                $operaciones = '
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-info seleccionarAula" 
                                name="' . $dia . '"
                                title="Seleccionar aula"><i class="far fa-hand-point-right"></i>
                        </button>
                        <button class="btn btn-outline-success crear" 
                                    name="" title="Crear clase"><i class="fas fa-plus-circle"></i>
                        </button>
                    </div>';
            }

            $filas .= '
                <tr name="' . $dia . '">
                    <td class="align-middle text-center">
                        <input type="checkbox" class="clases" id="clases" name="cbClases[]" value="' . $dia . '">
                    </td>
                    <td class="align-middle">Lunes</td>
                    <td class="align-middle">
                        <select class="form-control horaInicio" 
                                id="horaInicio' . $dia . '" name="horaInicio' . $dia . '">' . $opcionesInicio . '</select>
                    </td>
                    <td class="align-middle">
                        <select class="form-control horaFin" 
                                id="horaFin' . $dia . '" name="horaFin' . $dia . '">' . $opcionesFin . '</select>
                    </td>
                    <td class="align-middle">' . $aula . '</td>
                    <td class="align-middle text-center">' . $operaciones . '</td>
                </tr>';
        }

        $i = 2;
        $contenido = '
            <div class="card">
                <div class="card-header">Información de la asignatura</div>
                <div class="card-body">
                    <div class="form-row">
                        <label for="carrera" class="col-sm-2 col-form-label">* Carrera:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="nombreCarrera" id="nombreCarrera"
                                   value="' . utf8_encode($resultado['nombreCarrera']) . '"
                                   placeholder="Nombre de carrera" readonly>
                        </div>
                        <label for="nombreAsignatura" class="col-sm-2 col-form-label">* Asignatura:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2" 
                                   name="nombreAsignatura" id="nombreAsignatura"
                                   value="' . utf8_encode($resultado['nombreAsignatura']) . '"
                                   placeholder="Nombre de asignatura" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-2">
                    <div class="card-header">Complete los horarios de cursada</div>
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
                            <tbody>' . $filas . '</tbody>
                        </table>
                    </div>
                </div>';
    } else {
        $contenido = ControladorHTML::mostrarAlertaResultadoOperacion($resultado, $cursada->getDescripcion());
        $botones = ControladorHTML::mostrarBotonBusqueda("cursada_buscar");
    }
} else {
    $contenido = ControladorHTML::mostrarAlertaResultadoOperacion(0, "No se obtuvo la información desde el formulario");
    $botones = ControladorHTML::mostrarBotonBusqueda("cursada_buscar");
}
?>

<div class="container">
    <div class="form-row mt-4 mb-4">
        <div class="col text-left"><h4><i class="far fa-clock"></i> MODIFICAR HORARIO DE CURSADA</h4></div>
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
        <form id="formModificarCursada" name="formModificarCursada" method="POST">
            <?= $contenido; ?>
            <div class="form-row"> 
                <div class="col text-right mt-2"><?= $botones; ?></div>
            </div>
        </form>
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
    <div class="modal fade" id="modalBorrarClase" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center"><i class='fas fa-trash'></i> CONFIRME ELIMINACIÓN</h4>
                </div>
                <div class="modal-body">
                    <form name="formBorrarClase" id="formBorrarClase" method="POST">
                        <input type="hidden" name="modalIdClase" id="modalIdClase">
                        <div class="form-row">
                            <div class="col">
                                <label id="modalDetalle">Presione CONFIRMAR para borrar la clase seleccionada</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <input type='submit' class='btn btn-success' 
                           id='btnConfirmarEliminacion' name='btnConfirmarEliminacion'
                           data-dismiss="modal"
                           title='Confirmar la eliminación del registro seleccionado' value='Confirmar'>
                    <input type='submit' class='btn btn-outline-secondary' 
                           id='btnCancelarEliminacion' name="btnCancelarEliminacion" 
                           data-dismiss="modal" title='Cancelar la eliminación del registro seleccionado'
                           value='Cancelar'>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="./app/cursadas/js/ModificarCursada.js"></script>