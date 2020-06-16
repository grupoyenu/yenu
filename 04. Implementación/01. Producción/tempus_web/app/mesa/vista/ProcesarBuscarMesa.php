<?php

/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\mesa\controlador\ControladorMesa;
use app\principal\controlador\ControladorHTML;
use app\principal\modelo\AutoCargador;

AutoCargador::cargarModulos();

/* INICIALIZA LA SESION PARA GUARDAR LOG */

session_start();

/* INICIA EL CODIGO PROPIO DEL ARCHIVO */

$controlador = new ControladorMesa();
if (isset($_POST['peticion'])) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombreCarrera = $_POST['carrera'];
    $nombreAsignatura = $_POST['asignatura'];
    $datos = ($nombreCarrera) ? "Carrera : {$nombreCarrera}," : "Carrera: TODAS, ";
    $datos .= ($nombreAsignatura) ? "Asignatura '{$nombreAsignatura}'" : "Asignatura: TODAS";
    $filtro = "Resultado de la búsqueda: " . $datos;
    $resultado = $controlador->buscarPorCarreraAsignatura($nombreCarrera, $nombreAsignatura);
    $_SESSION['BUSMES'] = array($nombreCarrera, $nombreAsignatura, $datos);
} else {
    if (isset($_SESSION['BUSMES'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BUSMES'];
        $nombreCarrera = $parametros[0];
        $nombreAsignatura = $parametros[1];
        $filtro = "Última búsqueda realizada: " . $parametros[2];
        $resultado = $controlador->buscarPorCarreraAsignatura($nombreCarrera, $nombreAsignatura);
        $_SESSION['BUSMES'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $limite = 20;
        $resultado = $controlador->listarResumenMesasExamen($limite);
        $filtro = "Resumen de mesas de examen";
        $_SESSION['BUSMES'] = NULL;
    }
}

$cuerpo = "";
if ($resultado[0] == 2) {
    $mesas = $resultado[1];
    $cantidadLlamados = $controlador->obtenerNumeroDeLlamados();
    if ($cantidadLlamados > 0) {
        $filas = "";
        if ($cantidadLlamados == 1) {
            /* CARGA LA TABLA PARA UN SOLO LLAMADO EN EL TURNO DE MESA */
            foreach ($mesas as $mesa) {
                $idPlan = $mesa['idPlan'];
                $idMesaExamen = $mesa['idMesaExamen'];
                $codigoCarrera = str_pad($mesa['codigoCarrera'], 3, "0", STR_PAD_LEFT);
                $nombreCortoCarrera = $mesa['nombreCortoCarrera'];
                $nombreLargoCarrera = $mesa['nombreLargoCarrera'];
                $nombreCortoAsignatura = $mesa['nombreCortoAsignatura'];
                $nombreLargoAsignatura = $mesa['nombreLargoAsignatura'];
                $sectorAula = $mesa['sectorAulaPrimerLlamado'];
                $nombreAula = $mesa['nombreAulaPrimerLlamado'];
                $estadoLlamado = $mesa['estadoPrimerLlamado'];
                $fechaLlamado = date_format(date_create($mesa['fechaPrimerLlamado']), 'd/m/Y');
                $fechaEdicionLlamado = isset($mesa['fechaEdicionPrimerLlamado']) ? date_format(date_create($mesa['fechaEdicionPrimerLlamado']), 'd/m/Y H:m') : "";
                $horaLlamado = substr($mesa['horaPrimerLlamado'], 0, 5);
                $nombrePresidente = $mesa['nombrePresidente'];
                $nombreVocal1 = $mesa['nombreVocalPrimero'];
                $nombreVocal2 = $mesa['nombreVocalSegundo'];
                $nombreSuplente = $mesa['nombreSuplente'];
                $fechaCreacion = date_format(date_create($mesa['fechaCreacionMesaExamen']), 'd/m/Y');
                $observacion = $mesa['observacionMesaExamen'];

                $filas .= "
                    <tr>
                        <td style='display: none;'>{$codigoCarrera}</td>
                        <td style='display: none;'>{$nombreCortoCarrera}</td>
                        <td class='align-middle'>{$nombreLargoCarrera}</td>
                        <td style='display: none;'>{$nombreCortoAsignatura}</td>
                        <td class='align-middle'>{$nombreLargoAsignatura}</td>
                        <td class='align-middle'>{$nombrePresidente}</td>
                        <td class='align-middle'>{$nombreVocal1}</td>
                        <td class='align-middle'>{$nombreVocal2}</td>
                        <td class='align-middle'>{$nombreSuplente}</td>
                        <td class='align-middle'>{$fechaLlamado}</td>
                        <td class='align-middle'>{$horaLlamado}</td>
                        <td style='display: none;'>{$sectorAula}</td>
                        <td style='display: none;'>{$nombreAula}</td>
                        <td style='display: none;'>{$estadoLlamado}</td>
                        <td style='display: none;'>{$fechaEdicionLlamado}</td>
                        <td style='display: none;'>{$fechaCreacion}</td>
                        <td style='display: none;'>{$observacion}</td>
                        <td class='text-center'>
                            <div class='btn-group btn-group-sm'>
                                <button class='btn btn-outline-info detalle' 
                                        name='{$idPlan}' title='Ver detalle'>
                                        <i class='fas fa-eye'></i>
                                </button>
                                <button class='btn btn-outline-warning editar' 
                                        name='{$idPlan}' title='Editar'>
                                        <i class='far fa-edit'></i>
                                </button>
                                <button class='btn btn-outline-danger borrar' 
                                        name='{$idPlan}' title='Borrar'>
                                        <i class='fas fa-trash'></i>
                                </button>
                            </div>
                        </td>
                    </tr>";
            }
            $cuerpo = '
                <div class="table-responsive mt-4 mb-4">
                    <table id="tablaBuscarMesas" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="display: none;">Código de carrera</th>
                                <th style="display: none;">Nombre corto de carrera</th>
                                <th>Carrera</th>
                                <th style="display: none;">Nombre corto de asignatura</th>
                                <th>Asignatura</th>
                                <th>Presidente</th>
                                <th>Vocal 1</th>
                                <th>Vocal 2</th>
                                <th>Suplente</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th style="display: none;">Nombre sector</th>
                                <th style="display: none;">Nombre aula</th>
                                <th style="display: none;">Estado del llamado</th>
                                <th style="display: none;">Fecha edicion del llamado</th>
                                <th style="display: none;">Fecha creacion mesa</th>
                                <th style="display: none;">Observacion</th>
                                <th class="text-center">Operaciones</th>
                            </tr>
                        </thead>
                        <tbody>' . $filas . '</tbody>
                    </table>
                </div>';
        } else {
            // CARGA LA TABLA PARA DOS LLAMADOS EN EL TURNO DE MESA
            foreach ($mesas as $mesa) {

                $idPlan = $mesa['idPlan'];
                $idMesaExamen = $mesa['idMesaExamen'];
                $codigoCarrera = str_pad($mesa['codigoCarrera'], 3, "0", STR_PAD_LEFT);
                $nombreCortoCarrera = $mesa['nombreCortoCarrera'];
                $nombreLargoCarrera = $mesa['nombreLargoCarrera'];
                $nombreCortoAsignatura = $mesa['nombreCortoAsignatura'];
                $nombreLargoAsignatura = $mesa['nombreLargoAsignatura'];

                /* DATOS DEL PRIMER LLAMADO (PL) PARA LA MESA */

                $sectorAulaPL = $mesa['sectorAulaPrimerLlamado'];
                $nombreAulaPL = $mesa['nombreAulaPrimerLlamado'];
                $estadoPL = $mesa['estadoPrimerLlamado'];
                $fechaPL = date_format(date_create($mesa['fechaPrimerLlamado']), 'd/m/Y');
                $fechaEdicionPL = isset($mesa['fechaEdicionPrimerLlamado']) ? date_format(date_create($mesa['fechaEdicionPrimerLlamado']), 'd/m/Y H:m') : "";
                $horaPL = substr($mesa['horaPrimerLlamado'], 0, 5);

                /* DATOS DEL SEGUNDO LLAMADO (SL) PARA LA MESA */

                $sectorAulaSL = $mesa['sectorAulaSegundoLlamado'];
                $nombreAulaSL = $mesa['nombreAulaSegundoLlamado'];
                $estadoSL = $mesa['estadoSegundoLlamado'];
                $fechaSL = date_format(date_create($mesa['fechaSegundoLlamado']), 'd/m/Y');
                $fechaEdicionSL = isset($mesa['fechaEdicionSegundoLlamado']) ? date_format(date_create($mesa['fechaEdicionSegundoLlamado']), 'd/m/Y H:m') : "";
                $horaSL = substr($mesa['horaSegundoLlamado'], 0, 5);

                $nombrePresidente = $mesa['nombrePresidente'];
                $nombreVocal1 = $mesa['nombreVocalPrimero'];
                $nombreVocal2 = $mesa['nombreVocalSegundo'];
                $nombreSuplente = $mesa['nombreSuplente'];
                $fechaCreacion = date_format(date_create($mesa['fechaCreacionMesaExamen']), 'd/m/Y');
                $observacion = $mesa['observacionMesaExamen'];
                $filas .= "
                    <tr>
                        <td style='display: none;'>{$codigoCarrera}</td>
                        <td style='display: none;'>{$nombreCortoCarrera}</td>
                        <td class='align-middle'>{$nombreLargoCarrera}</td>
                        <td style='display: none;'>{$nombreCortoAsignatura}</td>
                        <td class='align-middle'>{$nombreLargoAsignatura}</td>
                        <td class='align-middle'>{$nombrePresidente}</td>
                        <td class='align-middle'>{$nombreVocal1}</td>
                        <td class='align-middle'>{$nombreVocal2}</td>
                        <td class='align-middle'>{$nombreSuplente}</td>
                        <td class='align-middle'>{$fechaPL}</td>
                        <td class='align-middle'>{$horaPL}</td>
                        <td style='display: none;'>{$sectorAulaPL}</td>
                        <td style='display: none;'>{$nombreAulaPL}</td>
                        <td style='display: none;'>{$estadoPL}</td>
                        <td style='display: none;'>{$fechaEdicionPL}</td>
                        <td class='align-middle'>{$fechaSL}</td>
                        <td class='align-middle'>{$horaSL}</td>
                        <td style='display: none;'>{$sectorAulaSL}</td>
                        <td style='display: none;'>{$nombreAulaSL}</td>
                        <td style='display: none;'>{$estadoSL}</td>
                        <td style='display: none;'>{$fechaEdicionSL}</td>
                        <td style='display: none;'>{$fechaCreacion}</td>
                        <td style='display: none;'>{$observacion}</td>
                        <td class='text-center'>
                            <div class='btn-group btn-group-sm'>
                                <button class='btn btn-outline-info detalle' 
                                        name='{$idPlan}' title='Ver detalle'>
                                        <i class='fas fa-eye'></i>
                                </button>
                                <button class='btn btn-outline-warning editar' 
                                        name='{$idPlan}' title='Editar'>
                                        <i class='far fa-edit'></i>
                                </button>
                                <button class='btn btn-outline-danger borrar' 
                                        name='{$idPlan}' title='Borrar'>
                                        <i class='fas fa-trash'></i>
                                </button>
                            </div>
                        </td>
                    </tr>";
            }
            $cuerpo = '
                <div class="table-responsive mt-4 mb-4">
                    <table id="tablaBuscarMesas" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="display: none;">Código de carrera</th>
                                <th style="display: none;">Nombre corto de carrera</th>
                                <th>Carrera</th>
                                <th style="display: none;">Nombre corto de asignatura</th>
                                <th>Asignatura</th>
                                <th>Presidente</th>
                                <th>Vocal 1</th>
                                <th>Vocal 2</th>
                                <th>Suplente</th>
                                <th>Fecha 1°</th>
                                <th>Hora 1°</th>
                                <th style="display: none;">Nombre sector 1°</th>
                                <th style="display: none;">Nombre aula 1°</th>
                                <th style="display: none;">Estado 1°</th>
                                <th style="display: none;">Fecha edicion 1°</th>
                                <th>Fecha 2°</th>
                                <th>Hora 2°</th>
                                <th style="display: none;">Nombre sector 2°</th>
                                <th style="display: none;">Nombre aula 2°</th>
                                <th style="display: none;">Estado 2°</th>
                                <th style="display: none;">Fecha edicion 2°</th>
                                <th style="display: none;">Fecha creacion mesa</th>
                                <th style="display: none;">Observacion</th>
                                <th class="text-center">Operaciones</th>
                            </tr>
                        </thead>
                        <tbody>' . $filas . '</tbody>
                    </table>
                </div>';
        }
    } else {
        // OCURRIO UN ERROR AL REALIZAR LA CONSULTA DE CANTIDAD DE LLAMADOS
        $mensaje = "No se pudo obtener la cantidad de llamados para el turno de examen";
        $cuerpo = ControladorHTML::mostrarAlertaResultadoBusqueda(0, $mensaje);
    }
} else {
    $codigo = $resultado[0];
    $mensaje = $resultado[1];
    $cuerpo = ControladorHTML::mostrarAlertaResultadoBusqueda($codigo, $mensaje);
}

echo ControladorHTML::mostrarCardResultadoBusqueda($filtro, $cuerpo);
