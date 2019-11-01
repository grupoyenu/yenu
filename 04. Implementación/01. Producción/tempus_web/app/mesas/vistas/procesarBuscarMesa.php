<?php

require_once './app/principal/modelos/Constantes.php';
require_once './app/principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$controlador = new ControladorMesa();

if (isset($_POST['btnBuscarMesa'])) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $campo = $_POST['campo'];
    $valor = $_POST['valor'];
    $datos = ($campo == "nombreCarrera") ? "Carrera" : "Asignatura";
    $datos .= ($valor) ? ", '{$valor}'" : ", TODAS";
    $filtro = "Resultado de la búsqueda: " . $datos;
    $mesas = $controlador->buscar($campo, $valor);
    $_SESSION['BUSMES'] = array($campo, $valor, $datos);
} else {
    if (isset($_SESSION['BUSMES'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BUSMES'];
        $campo = $parametros[0];
        $valor = $parametros[1];
        $filtro = "Última búsqueda realizada: " . $parametros[2];
        $mesas = $controlador->buscar($campo, $valor);
        $_SESSION['BUSMES'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $mesas = $controlador->listarUltimasCreadas();
        $filtro = "Últimas mesas de examen creadas";
        $_SESSION['BUSMES'] = NULL;
    }
}

$cuerpo = "";
if (gettype($mesas) == "object") {

    $cantidad = $controlador->obtenerCantidadLlamados();
    if ($cantidad > 0) {
        $filas = "";
        if ($cantidad == 1) {
            // CARGA LA TABLA PARA UN SOLO LLAMADO EN EL TURNO DE MESA
            while ($mesa = $mesas->fetch_assoc()) {
                $fechaLlamado = isset($mesa['fechaPri']) ? date_format(date_create($mesa['fechaPri']), 'd/m/Y') : "";
                $hora = substr($mesa['horaPri'], 0, 5);
                $fechaModificacion = isset($mesa['fechaModPri']) ? date_format(date_create($mesa['fechaModPri']), 'd/m/Y H:m') : "";
                $filas .= "
                    <tr>
                        <td style='display: none;'>" . str_pad($mesa['codigoCarrera'], 3, "0", STR_PAD_LEFT) . "</td>
                        <td class='align-middle'>{$mesa['nombreCarrera']}</td>
                        <td class='align-middle'>{$mesa['nombreAsignatura']}</td>
                        <td class='align-middle'>{$mesa['nombrePresidente']}</td>
                        <td class='align-middle'>{$mesa['nombreVocalPri']}</td>
                        <td class='align-middle'>{$mesa['nombreVocalSeg']}</td>
                        <td class='align-middle'>{$mesa['nombreSuplente']}</td>
                        <td class='align-middle'>{$fechaLlamado}</td>
                        <td class='align-middle'>{$hora}</td>
                        <td style='display: none;'>{$mesa['sectorPri']}</td>
                        <td style='display: none;'>{$mesa['aulaPri']}</td>
                        <td style='display: none;'>{$fechaModificacion}</td>
                        <td class='text-center'>
                            <div class='btn-group btn-group-sm'>
                                <button class='btn btn-outline-info detalle' 
                                    name='{$mesa['idmesa']}' title='Ver detalle'><i class='fas fa-eye'></i>
                                </button>
                                <button class='btn btn-outline-warning editar' 
                                        name='{$mesa['idmesa']}' title='Editar'><i class='far fa-edit'></i>
                                </button>
                                <button class='btn btn-outline-danger baja' 
                                        name='{$mesa['idmesa']}' title='Dar de baja'><i class='fas fa-trash'></i>
                                </button>
                            </div>
                        </td>
                    </tr>";
            }
            $cuerpo = '
                <div class="table-responsive mt-4">
                    <table id="tablaBuscarMesas" class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th style="display: none;">Código</th>
                                <th>Carrera</th>
                                <th>Asignatura</th>
                                <th>Presidente</th>
                                <th>Vocal 1</th>
                                <th>Vocal 2</th>
                                <th>Suplente</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th style="display: none;">Sector</th>
                                <th style="display: none;">Aula</th>
                                <th style="display: none;">Modificación</th>
                                <th class="text-center">Operaciones</th>
                            </tr>
                        </thead>
                        <tbody>' . $filas . '</tbody>
                    </table>
                </div>';
        } else {
            // CARGA LA TABLA PARA DOS LLAMADOS EN EL TURNO DE MESA
            while ($mesa = $mesas->fetch_assoc()) {
                $fechaPrimero = isset($mesa['fechaPri']) ? date_format(date_create($mesa['fechaPri']), 'd/m/Y') : "";
                $horaPrimero = substr($mesa['horaPri'], 0, 5);
                $edicionPrimero = isset($mesa['fechaModPri']) ? date_format(date_create($mesa['fechaModPri']), 'd/m/Y H:m') : "";
                $fechaSegundo = isset($mesa['fechaSeg']) ? date_format(date_create($mesa['fechaSeg']), 'd/m/Y') : "";
                $horaSegundo = substr($mesa['horaSeg'], 0, 5);
                $edicionSegundo = isset($mesa['fechaModSeg']) ? date_format(date_create($mesa['fechaModSeg']), 'd/m/Y H:m') : "";
                $filas .= "
                    <tr>
                        <td style='display: none;'>" . str_pad($mesa['codigoCarrera'], 3, "0", STR_PAD_LEFT) . "</td>
                        <td class='align-middle'>{$mesa['nombreCarrera']}</td>
                        <td class='align-middle'>{$mesa['nombreAsignatura']}</td>
                        <td class='align-middle'>{$mesa['nombrePresidente']}</td>
                        <td class='align-middle'>{$mesa['nombreVocalPri']}</td>
                        <td class='align-middle'>{$mesa['nombreVocalSeg']}</td>
                        <td class='align-middle'>{$mesa['nombreSuplente']}</td>
                        <td class='align-middle'>{$fechaPrimero}</td>
                        <td style='display: none;'>{$horaPrimero}</td>
                        <td style='display: none;'>{$mesa['sectorPri']}</td>
                        <td style='display: none;'>{$mesa['aulaPri']}</td>
                        <td style='display: none;'>{$edicionPrimero}</td>
                        <td class='align-middle'>{$fechaSegundo}</td>
                        <td style='display: none;'>{$horaSegundo}</td>
                        <td style='display: none;'>{$mesa['sectorSeg']}</td>
                        <td style='display: none;'>{$mesa['aulaSeg']}</td>
                        <td style='display: none;'>{$edicionSegundo}</td>
                        <td class='text-center'>
                            <div class='btn-group btn-group-sm'>
                                <button class='btn btn-outline-info detalle' 
                                    name='{$mesa['idmesa']}' title='Ver detalle'><i class='fas fa-eye'></i>
                                </button>
                                <button class='btn btn-outline-warning editar' 
                                        name='{$mesa['idmesa']}' title='Editar'><i class='far fa-edit'></i>
                                </button>
                                <button class='btn btn-outline-danger baja' 
                                        name='{$mesa['idmesa']}' title='Dar de baja'><i class='fas fa-trash'></i>
                                </button>
                            </div>
                        </td>
                    </tr>";
            }
            $cuerpo = '
                <div class="table-responsive mt-4">
                    <table id="tablaBuscarMesas" class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th style="display: none;">Código</th>
                                <th>Carrera</th>
                                <th>Asignatura</th>
                                <th>Presidente</th>
                                <th>Vocal 1</th>
                                <th>Vocal 2</th>
                                <th>Suplente</th>
                                <th>Primero</th>
                                <th style="display: none;">Hora</th>
                                <th style="display: none;">Sector</th>
                                <th style="display: none;">Aula</th>
                                <th style="display: none;">Modificación</th>
                                <th>Segundo</th>
                                <th style="display: none;">Hora</th>
                                <th style="display: none;">Sector</th>
                                <th style="display: none;">Aula</th>
                                <th style="display: none;">Modificación</th>
                                <th class="text-center">Operaciones</th>
                            </tr>
                        </thead>
                        <tbody>' . $filas . '</tbody>
                    </table>
                </div>';
        }
    } else {
        // OCURRIO UN ERROR AL REALIZAR LA CONSULTA DE CANTIDAD DE LLAMADOS
        $cuerpo = ControladorHTML::mostrarAlertaResultadoBusqueda(0, $controlador->getDescripcion());
    }
} else {
    $cuerpo = ControladorHTML::mostrarAlertaResultadoBusqueda($mesas, $controlador->getDescripcion());
}

echo ControladorHTML::mostrarCardResultadoBusqueda($filtro, $cuerpo);
