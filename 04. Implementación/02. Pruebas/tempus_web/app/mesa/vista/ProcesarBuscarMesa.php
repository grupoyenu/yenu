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
    $datos = "<span class=dropdown-item>Nombre de carrera: <b>{$nombreCarrera}</b></span>";
    $datos .= "<span class=dropdown-item>Nombre de asignatura: <b>{$nombreAsignatura}</b></span>";
    $filtro = "Resultado de la búsqueda";
    $resultado = $controlador->buscarPorCarreraAsignatura($nombreCarrera, $nombreAsignatura);
    $_SESSION['BUSMES'] = array($nombreCarrera, $nombreAsignatura, $datos);
} else {
    if (isset($_SESSION['BUSMES'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BUSMES'];
        $nombreCarrera = $parametros[0];
        $nombreAsignatura = $parametros[1];
        $datos = $parametros[2];
        $filtro = "Última búsqueda realizada";
        $resultado = $controlador->buscarPorCarreraAsignatura($nombreCarrera, $nombreAsignatura);
        $_SESSION['BUSMES'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $limite = 20;
        $resultado = $controlador->listarResumenMesasExamen($limite);
        $datos = "<span class=dropdown-item>Limite: <b>{$limite}</b></span>";
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
                        <td class='align-middle col_codigo_carrera' style='display: none;'>{$codigoCarrera}</td>
                        <td class='align-middle col_nombre_corto_carrera' style='display: none;'>{$nombreCortoCarrera}</td>
                        <td class='align-middle col_nombre_largo_carrera'>{$nombreLargoCarrera}</td>
                        <td class='align-middle col_nombre_corto_asignatura' style='display: none;'>{$nombreCortoAsignatura}</td>
                        <td class='align-middle col_nombre_largo_asignatura'>{$nombreLargoAsignatura}</td>
                        <td class='align-middle col_presidente'>{$nombrePresidente}</td>
                        <td class='align-middle col_vocal1'>{$nombreVocal1}</td>
                        <td class='align-middle col_vocal2'>{$nombreVocal2}</td>
                        <td class='align-middle col_suplente'>{$nombreSuplente}</td>
                        <td class='align-middle col_fecha_primer_llamado'>{$fechaLlamado}</td>
                        <td class='align-middle col_hora_primer_llamado'>{$horaLlamado}</td>
                        <td class='align-middle col_sector' style='display: none;'>{$sectorAula}</td>
                        <td class='align-middle col_aula' style='display: none;'>{$nombreAula}</td>
                        <td class='align-middle col_estado' style='display: none;'>{$estadoLlamado}</td>
                        <td class='align-middle' style='display: none;'>{$fechaEdicionLlamado}</td>
                        <td class='align-middle' style='display: none;'>{$fechaCreacion}</td>
                        <td class='align-middle col_observacion' style='display: none;'>{$observacion}</td>
                        <td class='text-center'>
                            <div class='btn-group btn-group-sm'>
                                <button class='btn btn-outline-info detalle' 
                                        name='{$idPlan}' 
                                        title='Ver detalle ({$nombreLargoCarrera} {$nombreLargoAsignatura})'>
                                        <i class='fas fa-eye'></i>
                                </button>
                                <button class='btn btn-outline-warning editar' 
                                        name='{$idPlan}' 
                                        title='Editar ({$nombreLargoCarrera} {$nombreLargoAsignatura})'>
                                        <i class='far fa-edit'></i>
                                </button>
                                <button class='btn btn-outline-danger borrar' 
                                        name='{$idPlan}' 
                                        title='Borrar ({$nombreLargoCarrera} {$nombreLargoAsignatura})'>
                                        <i class='fas fa-trash'></i>
                                </button>
                            </div>
                        </td>
                    </tr>";
            }
            $cuerpo = '
                <div class="form-row">
                    <div class="col text-left">
                        <div class="btn-group">
                            <button class="btn btn-outline-dark dropdown-toggle"
                                    title="Configurar columnas a visualizar"
                                    type="button" data-toggle="dropdown" 
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-tasks"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item">
                                    <input type="checkbox" class="col_checkbox" value="col_codigo_carrera"/> 
                                    <span class="ml-4">Código de carrera</span>
                                </a>
                                <a class="dropdown-item">
                                    <input type="checkbox" class="col_checkbox" value="col_nombre_corto_carrera"/>
                                    <span class="ml-4">Nombre corto de carrera</span>
                                </a>

                                <a class="dropdown-item">
                                    <input type="checkbox" checked class="col_checkbox" value="col_nombre_largo_carrera"/> 
                                    <span class="ml-4">Nombre largo de carrera</span>
                                </a>
                                <a class="dropdown-item">
                                    <input type="checkbox" class="col_checkbox" value="col_nombre_corto_asignatura"/>
                                    <span class="ml-4">Nombre corto de asignatura</span>
                                </a>
                                <a class="dropdown-item">
                                    <input type="checkbox" checked class="col_checkbox" value="col_nombre_largo_asignatura"/>
                                    <span class="ml-4">Nombre largo de asignatura</span>
                                </a>
                                <a class="dropdown-item">
                                    <input type="checkbox" checked class="col_checkbox" value="col_presidente"/>
                                    <span class="ml-4">Persidente</span>
                                </a>
                                <a class="dropdown-item">
                                    <input type="checkbox" checked class="col_checkbox" value="col_vocal1"/>
                                    <span class="ml-4">Vocal primero</span>
                                </a>
                                <a class="dropdown-item">
                                    <input type="checkbox" checked class="col_checkbox" value="col_vocal2"/>
                                    <span class="ml-4">Vocal segundo</span>
                                </a>
                                <a class="dropdown-item">
                                    <input type="checkbox" checked class="col_checkbox" value="col_suplente"/>
                                    <span class="ml-4">Suplente</span>
                                </a>
                                <a class="dropdown-item">
                                    <input type="checkbox" checked class="col_checkbox" value="col_fecha_primer_llamado"/>
                                    <span class="ml-4">Fecha</span>
                                </a>
                                <a class="dropdown-item">
                                    <input type="checkbox" checked class="col_checkbox" value="col_hora_primer_llamado"/>
                                    <span class="ml-4">Hora</span>
                                </a>
                                <a class="dropdown-item">
                                    <input type="checkbox" class="col_checkbox" value="col_sector"/>
                                    <span class="ml-4">Sector</span>
                                </a>
                                <a class="dropdown-item">
                                    <input type="checkbox" class="col_checkbox" value="col_aula"/>
                                    <span class="ml-4">Aula</span>
                                </a>
                                <a class="dropdown-item">
                                    <input type="checkbox" class="col_checkbox" value="col_estado"/>
                                    <span class="ml-4">Estado</span>
                                </a>
                                <a class="dropdown-item">
                                    <input type="checkbox" class="col_checkbox" value="col_observacion"/>
                                    <span class="ml-4">Observación</span>
                                </a>
                            </div>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-outline-dark dropdown-toggle"
                                    title="Datos del filtro aplicado"
                                    type="button" data-toggle="dropdown" 
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-filter"></i>
                            </button>
                            <div class="dropdown-menu">' . $datos . '</div>
                        </div>   
                    </div>  
                </div>';

            $cuerpo .= '
                <div class="table-responsive mt-4 mb-4">
                    <table id="tablaBuscarMesas" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="col_codigo_carrera" style="display: none;">Código de carrera</th>
                                <th class="col_nombre_corto_carrera" style="display: none;">Nombre corto de carrera</th>
                                <th class="col_nombre_largo_carrera">Carrera</th>
                                <th class="col_nombre_corto_asignatura" style="display: none;">Nombre corto de asignatura</th>
                                <th class="col_nombre_largo_asignatura">Asignatura</th>
                                <th class="col_presidente">Presidente</th>
                                <th class="col_vocal1">Vocal 1</th>
                                <th class="col_vocal2">Vocal 2</th>
                                <th class="col_suplente">Suplente</th>
                                <th class="col_fecha_primer_llamado">Fecha</th>
                                <th class="col_hora_primer_llamado">Hora</th>
                                <th class="col_sector" style="display: none;">Nombre sector</th>
                                <th class="col_aula" style="display: none;">Nombre aula</th>
                                <th class="col_estado" style="display: none;">Estado del llamado</th>
                                <th style="display: none;">Fecha edicion del llamado</th>
                                <th style="display: none;">Fecha creacion mesa</th>
                                <th class="col_observacion" style="display: none;">Observacion</th>
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
                        <td class='align-middle col_codigo_carrera' style='display: none;'>{$codigoCarrera}</td>
                        <td class='align-middle col_nombre_corto_carrera' style='display: none;'>{$nombreCortoCarrera}</td>
                        <td class='align-middle col_nombre_largo_carrera'>{$nombreLargoCarrera}</td>
                        <td class='align-middle col_nombre_corto_asignatura' style='display: none;'>{$nombreCortoAsignatura}</td>
                        <td class='align-middle col_nombre_largo_asignatura'>{$nombreLargoAsignatura}</td>
                        <td class='align-middle col_presidente'>{$nombrePresidente}</td>
                        <td class='align-middle col_vocal1'>{$nombreVocal1}</td>
                        <td class='align-middle col_vocal2'>{$nombreVocal2}</td>
                        <td class='align-middle col_suplente'>{$nombreSuplente}</td>
                        <td class='align-middle col_fecha_primer_llamado'>{$fechaPL}</td>
                        <td class='align-middle col_hora_primer_llamado'>{$horaPL}</td>
                        <td class='align-middle col_sector_primer_llamado' style='display: none;'>{$sectorAulaPL}</td>
                        <td class='align-middle col_aula_primer_llamado' style='display: none;'>{$nombreAulaPL}</td>
                        <td class='align-middle col_estado_primer_llamado' style='display: none;'>{$estadoPL}</td>
                        <td class='align-middle' style='display: none;'>{$fechaEdicionPL}</td>
                        <td class='align-middle col_fecha_segundo_llamado'>{$fechaSL}</td>
                        <td class='align-middle col_hora_segundo_llamado'>{$horaSL}</td>
                        <td class='align-middle col_sector_segundo_llamado' style='display: none;'>{$sectorAulaSL}</td>
                        <td class='align-middle col_aula_segundo_llamado' style='display: none;'>{$nombreAulaSL}</td>
                        <td class='align-middle col_estado_segundo_llamado' style='display: none;'>{$estadoSL}</td>
                        <td class='align-middle' style='display: none;'>{$fechaEdicionSL}</td>
                        <td class='align-middle' style='display: none;'>{$fechaCreacion}</td>
                        <td class='align-middle col_observacion' style='display: none;'>{$observacion}</td>
                        <td class='text-center'>
                            <div class='btn-group btn-group-sm'>
                                <button class='btn btn-outline-info detalle' 
                                        name='{$idPlan}' 
                                        title='Ver detalle ({$nombreLargoCarrera} {$nombreLargoAsignatura})'>
                                        <i class='fas fa-eye'></i>
                                </button>
                                <button class='btn btn-outline-warning editar' 
                                        name='{$idPlan}' 
                                        title='Editar ({$nombreLargoCarrera} {$nombreLargoAsignatura})'>
                                        <i class='far fa-edit'></i>
                                </button>
                                <button class='btn btn-outline-danger borrar' 
                                        name='{$idPlan}'
                                        title='Borrar ({$nombreLargoCarrera} {$nombreLargoAsignatura})'>
                                        <i class='fas fa-trash'></i>
                                </button>
                            </div>
                        </td>
                    </tr>";
            }

            $cuerpo = '
                <div class="form-row">
                    <div class="col text-left">
                        <div class="btn-group">
                            <button class="btn btn-outline-dark dropdown-toggle"
                                    title="Configurar columnas a visualizar"
                                    type="button" data-toggle="dropdown" 
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-tasks"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item">
                                    <input type="checkbox" class="col_checkbox" value="col_codigo_carrera"/> 
                                    <span class="ml-4">Código de carrera</span>
                                </a>
                                <a class="dropdown-item">
                                    <input type="checkbox" class="col_checkbox" value="col_nombre_corto_carrera"/>
                                    <span class="ml-4">Nombre corto de carrera</span>
                                </a>

                                <a class="dropdown-item">
                                    <input type="checkbox" checked class="col_checkbox" value="col_nombre_largo_carrera"/> 
                                    <span class="ml-4">Nombre largo de carrera</span>
                                </a>
                                <a class="dropdown-item">
                                    <input type="checkbox" class="col_checkbox" value="col_nombre_corto_asignatura"/>
                                    <span class="ml-4">Nombre corto de asignatura</span>
                                </a>
                                <a class="dropdown-item">
                                    <input type="checkbox" checked class="col_checkbox" value="col_nombre_largo_asignatura"/>
                                    <span class="ml-4">Nombre largo de asignatura</span>
                                </a>
                                <a class="dropdown-item">
                                    <input type="checkbox" checked class="col_checkbox" value="col_presidente"/>
                                    <span class="ml-4">Persidente</span>
                                </a>
                                <a class="dropdown-item">
                                    <input type="checkbox" checked class="col_checkbox" value="col_vocal1"/>
                                    <span class="ml-4">Vocal primero</span>
                                </a>
                                <a class="dropdown-item">
                                    <input type="checkbox" checked class="col_checkbox" value="col_vocal2"/>
                                    <span class="ml-4">Vocal segundo</span>
                                </a>
                                <a class="dropdown-item">
                                    <input type="checkbox" checked class="col_checkbox" value="col_suplente"/>
                                    <span class="ml-4">Suplente</span>
                                </a>
                                <a class="dropdown-item">
                                    <input type="checkbox" checked class="col_checkbox" value="col_fecha_primer_llamado"/>
                                    <span class="ml-4">Fecha primer llamado</span>
                                </a>
                                <a class="dropdown-item">
                                    <input type="checkbox" checked class="col_checkbox" value="col_hora_primer_llamado"/>
                                    <span class="ml-4">Hora primer llamado</span>
                                </a>
                                <a class="dropdown-item">
                                    <input type="checkbox" class="col_checkbox" value="col_sector_primer_llamado"/>
                                    <span class="ml-4">Sector primer llamado</span>
                                </a>
                                <a class="dropdown-item">
                                    <input type="checkbox" class="col_checkbox" value="col_aula_primer_llamado"/>
                                    <span class="ml-4">Aula primer llamado</span>
                                </a>
                                <a class="dropdown-item">
                                    <input type="checkbox" class="col_checkbox" value="col_estado_primer_llamado"/>
                                    <span class="ml-4">Estado primer llamado</span>
                                </a>
                                <a class="dropdown-item">
                                    <input type="checkbox" checked class="col_checkbox" value="col_fecha_segundo_llamado"/>
                                    <span class="ml-4">Fecha segundo llamado</span>
                                </a>
                                <a class="dropdown-item">
                                    <input type="checkbox" checked class="col_checkbox" value="col_hora_segundo_llamado"/>
                                    <span class="ml-4">Hora segundo llamado</span>
                                </a>
                                <a class="dropdown-item">
                                    <input type="checkbox" class="col_checkbox" value="col_sector_segundo_llamado"/>
                                    <span class="ml-4">Sector segundo llamado</span>
                                </a>
                                <a class="dropdown-item">
                                    <input type="checkbox" class="col_checkbox" value="col_aula_segundo_llamado"/>
                                    <span class="ml-4">Aula segundo llamado</span>
                                </a>
                                <a class="dropdown-item">
                                    <input type="checkbox" class="col_checkbox" value="col_estado_segundo_llamado"/>
                                    <span class="ml-4">Estado segundo llamado</span>
                                </a>
                                <a class="dropdown-item">
                                    <input type="checkbox" class="col_checkbox" value="col_observacion"/>
                                    <span class="ml-4">Observación</span>
                                </a>
                            </div>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-outline-dark dropdown-toggle"
                                    title="Datos del filtro aplicado"
                                    type="button" data-toggle="dropdown" 
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-filter"></i>
                            </button>
                            <div class="dropdown-menu">' . $datos . '</div>
                        </div>   
                    </div>  
                </div>';

            $cuerpo .= '
                <div class="table-responsive mt-4 mb-4">
                    <table id="tablaBuscarMesas" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="col_codigo_carrera" style="display: none;">Código de carrera</th>
                                <th class="col_nombre_corto_carrera" style="display: none;">Nombre corto de carrera</th>
                                <th class="col_nombre_largo_carrera">Carrera</th>
                                <th class="col_nombre_corto_asignatura" style="display: none;">Nombre corto de asignatura</th>
                                <th class="col_nombre_largo_asignatura">Asignatura</th>
                                <th class="col_presidente">Presidente</th>
                                <th class="col_vocal1">Vocal 1</th>
                                <th class="col_vocal2">Vocal 2</th>
                                <th class="col_suplente">Suplente</th>
                                <th class="col_fecha_primer_llamado">Fecha 1°</th>
                                <th class="col_hora_primer_llamado">Hora 1°</th>
                                <th class="col_sector_primer_llamado" style="display: none;">Nombre sector 1°</th>
                                <th class="col_aula_primer_llamado" style="display: none;">Nombre aula 1°</th>
                                <th class="col_estado_primer_llamado" style="display: none;">Estado 1°</th>
                                <th style="display: none;">Fecha edicion 1°</th>
                                <th class="col_fecha_segundo_llamado">Fecha 2°</th>
                                <th class="col_hora_segundo_llamado">Hora 2°</th>
                                <th class="col_sector_segundo_llamado" style="display: none;">Nombre sector 2°</th>
                                <th class="col_aula_segundo_llamado" style="display: none;">Nombre aula 2°</th>
                                <th class="col_estado_segundo_llamado" style="display: none;">Estado 2°</th>
                                <th style="display: none;">Fecha edicion 2°</th>
                                <th style="display: none;">Fecha creacion mesa</th>
                                <th class="col_observacion" style="display: none;">Observacion</th>
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
