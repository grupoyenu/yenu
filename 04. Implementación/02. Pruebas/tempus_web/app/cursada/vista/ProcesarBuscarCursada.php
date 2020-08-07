<?php

/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\cursada\controlador\ControladorCursada;
use app\principal\controlador\ControladorHTML;
use app\principal\modelo\AutoCargador;

AutoCargador::cargarModulos();

session_start();

$controlador = new ControladorCursada();
if (isset($_POST['peticion'])) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombreCarrera = $_POST['carrera'];
    $nombreAsignatura = $_POST['asignatura'];
    $datos = "<span class=dropdown-item>Nombre de carrera: <b>{$nombreCarrera}</b></span>";
    $datos .= "<span class=dropdown-item>Nombre de asignatura: <b>{$nombreAsignatura}</b></span>";
    $filtro = "Resultado de la búsqueda";
    $resultado = $controlador->buscarPorCarreraAsignatura($nombreCarrera, $nombreAsignatura);
    $_SESSION['BUSCUR'] = array($nombreCarrera, $nombreAsignatura, $datos);
} else {
    if (isset($_SESSION['BUSCUR'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BUSCUR'];
        $nombreCarrera = $parametros[0];
        $nombreAsignatura = $parametros[1];
        $datos = $parametros[2];
        $filtro = "Última búsqueda realizada";
        $resultado = $controlador->buscarPorCarreraAsignatura($nombreCarrera, $nombreAsignatura);
        $_SESSION['BUSCUR'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $limite = 20;
        $resultado = $controlador->listarResumenCursadas($limite);
        $datos = "<span class=dropdown-item>Limite: <b>{$limite}</b></span>";
        $filtro = "Resumen de horarios de cursada";
        $_SESSION['BUSCUR'] = NULL;
    }
}

$cuerpo = "";
if ($resultado[0] == 2) {
    $cursadas = $resultado[1];
    $filas = "";
    foreach ($cursadas as $cursada) {

        $idPlan = $cursada['idPlan'];
        $codigoCarrera = str_pad($cursada['codigoCarrera'], 3, "0", STR_PAD_LEFT);
        $anio = $cursada['anio'];
        $nombreCortoCarrera = $cursada['nombreCortoCarrera'];
        $nombreLargoCarrera = $cursada['nombreLargoCarrera'];
        $nombreCortoAsignatura = $cursada['nombreCortoAsignatura'];
        $nombreLargoAsignatura = $cursada['nombreLargoAsignatura'];

        /* DATOS DE LA CLASE PARA DIA LUNES */
        $horaInicioLunes = ($cursada['horaInicioLunes']) ? substr($cursada['horaInicioLunes'], 0, 5) : "";
        $horaFinLunes = ($cursada['horaFinLunes']) ? substr($cursada['horaFinLunes'], 0, 5) : "";
        $sectorAulaLunes = $cursada['sectorAulaLunes'];
        $nombreAulaLunes = $cursada['nombreAulaLunes'];
        $fechaEdicionLunes = isset($cursada['fechaEdicionLunes']) ? date_format(date_create($cursada['fechaEdicionLunes']), 'd/m/Y H:m') : "";
        $lunes = "$horaInicioLunes $horaFinLunes $sectorAulaLunes $nombreAulaLunes";

        /* DATOS DE LA CLASE PARA DIA MARTES */
        $horaInicioMartes = ($cursada['horaInicioMartes']) ? substr($cursada['horaInicioMartes'], 0, 5) : "";
        $horaFinMartes = ($cursada['horaFinMartes']) ? substr($cursada['horaFinMartes'], 0, 5) : "";
        $sectorAulaMartes = $cursada['sectorAulaMartes'];
        $nombreAulaMartes = $cursada['nombreAulaMartes'];
        $fechaEdicionMartes = isset($cursada['fechaEdicionMartes']) ? date_format(date_create($cursada['fechaEdicionMartes']), 'd/m/Y H:m') : "";
        $martes = "$horaInicioMartes $horaFinMartes $sectorAulaMartes $nombreAulaMartes";

        /* DATOS DE LA CLASE PARA DIA MIERCOLES */
        $horaInicioMiercoles = ($cursada['horaInicioMiercoles']) ? substr($cursada['horaInicioMiercoles'], 0, 5) : "";
        $horaFinMiercoles = ($cursada['horaFinMiercoles']) ? substr($cursada['horaFinMiercoles'], 0, 5) : "";
        $sectorAulaMiercoles = $cursada['sectorAulaMiercoles'];
        $nombreAulaMiercoles = $cursada['nombreAulaMiercoles'];
        $fechaEdicionMiercoles = isset($cursada['fechaEdicionMiercoles']) ? date_format(date_create($cursada['fechaEdicionMiercoles']), 'd/m/Y H:m') : "";
        $miercoles = "$horaInicioMiercoles $horaFinMiercoles $sectorAulaMiercoles $nombreAulaMiercoles";

        /* DATOS DE LA CLASE PARA DIA JUEVES */
        $horaInicioJueves = ($cursada['horaInicioJueves']) ? substr($cursada['horaInicioJueves'], 0, 5) : "";
        $horaFinJueves = ($cursada['horaFinJueves']) ? substr($cursada['horaFinJueves'], 0, 5) : "";
        $sectorAulaJueves = $cursada['sectorAulaJueves'];
        $nombreAulaJueves = $cursada['nombreAulaJueves'];
        $fechaEdicionJueves = isset($cursada['fechaEdicionJueves']) ? date_format(date_create($cursada['fechaEdicionJueves']), 'd/m/Y H:m') : "";
        $jueves = "$horaInicioJueves $horaFinJueves $sectorAulaJueves $nombreAulaJueves";

        /* DATOS DE LA CLASE PARA DIA VIERNES */
        $horaInicioViernes = ($cursada['horaInicioViernes']) ? substr($cursada['horaInicioViernes'], 0, 5) : "";
        $horaFinViernes = ($cursada['horaFinViernes']) ? substr($cursada['horaFinViernes'], 0, 5) : "";
        $sectorAulaViernes = $cursada['sectorAulaViernes'];
        $nombreAulaViernes = $cursada['nombreAulaViernes'];
        $fechaEdicionViernes = isset($cursada['fechaEdicionViernes']) ? date_format(date_create($cursada['fechaEdicionViernes']), 'd/m/Y H:m') : "";
        $viernes = "$horaInicioViernes $horaFinViernes $sectorAulaViernes $nombreAulaViernes";

        /* DATOS DE LA CLASE PARA DIA SABADO */
        $horaInicioSabado = ($cursada['horaInicioSabado']) ? substr($cursada['horaInicioSabado'], 0, 5) : "";
        $horaFinSabado = ($cursada['horaFinSabado']) ? substr($cursada['horaFinSabado'], 0, 5) : "";
        $sectorAulaSabado = $cursada['sectorAulaSabado'];
        $nombreAulaSabado = $cursada['nombreAulaSabado'];
        $fechaEdicionSabado = isset($cursada['fechaEdicionSabado']) ? date_format(date_create($cursada['fechaEdicionSabado']), 'd/m/Y H:m') : "";
        $sabado = "$horaInicioSabado $horaFinSabado $sectorAulaSabado $nombreAulaSabado";

        $filas .= "
            <tr>
                <td class='align-middle col_codigo_carrera' style='display: none;'>{$codigoCarrera}</td>
                <td class='align-middle col_nombre_corto_carrera' style='display: none;'>{$nombreCortoCarrera}</td>
                <td class='align-middle col_nombre_largo_carrera' class='align-middle'>{$nombreLargoCarrera}</td>
                <td class='align-middle col_nombre_corto_asignatura' style='display: none;'>{$nombreCortoAsignatura}</td>
                <td class='align-middle col_nombre_largo_asignatura'>{$nombreLargoAsignatura}</td>
                <td class='align-middle col_anio'>{$anio}</td>
                <td class='align-middle col_dia_lunes'>{$lunes}</td>
                <td class='align-middle' style='display: none;'>{$horaInicioLunes}</td>
                <td class='align-middle' style='display: none;'>{$horaFinLunes}</td>
                <td class='align-middle' style='display: none;'>{$sectorAulaLunes}</td>
                <td class='align-middle' style='display: none;'>{$nombreAulaLunes}</td>
                <td class='align-middle' style='display: none;'>{$fechaEdicionLunes}</td>
                <td class='align-middle col_dia_martes'>{$martes}</td>
                <td class='align-middle' style='display: none;'>{$horaInicioMartes}</td>
                <td class='align-middle' style='display: none;'>{$horaFinMartes}</td>
                <td class='align-middle' style='display: none;'>{$sectorAulaMartes}</td>
                <td class='align-middle' style='display: none;'>{$nombreAulaMartes}</td>
                <td class='align-middle' style='display: none;''>{$fechaEdicionMartes}</td>
                <td class='align-middle col_dia_miercoles'>{$miercoles}</td>
                <td class='align-middle' style='display: none;'>{$horaInicioMiercoles}</td>
                <td class='align-middle' style='display: none;'>{$horaFinMiercoles}</td>
                <td class='align-middle' style='display: none;'>{$sectorAulaMiercoles}</td>
                <td class='align-middle' style='display: none;'>{$nombreAulaMiercoles}</td>
                <td class='align-middle' style='display: none;'>{$fechaEdicionMiercoles}</td>
                <td class='align-middle col_dia_jueves'>{$jueves}</td>
                <td class='align-middle' style='display: none;'>{$horaInicioJueves}</td>
                <td class='align-middle' style='display: none;'>{$horaFinJueves}</td>
                <td class='align-middle' style='display: none;'>{$sectorAulaJueves}</td>
                <td class='align-middle' style='display: none;'>{$nombreAulaJueves}</td>
                <td class='align-middle' style='display: none;'>{$fechaEdicionJueves}</td>
                <td class='align-middle col_dia_viernes'>{$viernes}</td>
                <td class='align-middle' style='display: none;'>{$horaInicioViernes}</td>
                <td class='align-middle' style='display: none;'>{$horaFinViernes}</td>
                <td class='align-middle' style='display: none;'>{$sectorAulaViernes}</td>
                <td class='align-middle' style='display: none;'>{$nombreAulaViernes}</td>
                <td class='align-middle' style='display: none;'>{$fechaEdicionViernes}</td> 
                <td class='align-middle col_dia_sabado'>{$sabado}</td>
                <td class='align-middle' style='display: none;'>{$horaInicioSabado}</td>
                <td class='align-middle' style='display: none;'>{$horaFinSabado}</td>
                <td class='align-middle' style='display: none;'>{$sectorAulaSabado}</td>
                <td class='align-middle' style='display: none;'>{$nombreAulaSabado}</td>
                <td class='align-middle' style='display: none;'>{$fechaEdicionSabado}</td>
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>
                        <button class='btn btn-outline-info detalle' 
                                title='Ver detalle ({$nombreLargoCarrera} {$nombreLargoAsignatura})'>
                                <i class='fas fa-eye'></i>
                        </button>
                        <button class='btn btn-outline-warning editar' 
                                name='$idPlan' id='$idPlan' 
                                title='Editar ({$nombreLargoCarrera} {$nombreLargoAsignatura})'>
                                <i class='far fa-edit'></i>
                        </button>
                        <button class='btn btn-outline-danger borrar' 
                                name='{$idPlan}' id='{$idPlan}' 
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
                            <input type="checkbox" checked class="col_checkbox" value="col_anio"/>
                            <span class="ml-4">Año</span>
                        </a>
                        <a class="dropdown-item">
                            <input type="checkbox" checked class="col_checkbox" value="col_dia_lunes"/>
                            <span class="ml-4">Lunes</span>
                        </a>
                        <a class="dropdown-item">
                            <input type="checkbox" checked class="col_checkbox" value="col_dia_martes"/>
                            <span class="ml-4">Martes</span>
                        </a>
                        <a class="dropdown-item">
                            <input type="checkbox" checked class="col_checkbox" value="col_dia_miercoles"/>
                            <span class="ml-4">Miercoles</span>
                        </a>
                        <a class="dropdown-item">
                            <input type="checkbox" checked class="col_checkbox" value="col_dia_jueves"/>
                            <span class="ml-4">Jueves</span>
                        </a>
                        <a class="dropdown-item">
                            <input type="checkbox" checked class="col_checkbox" value="col_dia_viernes"/>
                            <span class="ml-4">Viernes</span>
                        </a>
                        <a class="dropdown-item">
                            <input type="checkbox" checked class="col_checkbox" value="col_dia_sabado"/>
                            <span class="ml-4">Sabado</span>
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
            <table id="tablaBuscarCursadas" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="col_codigo_carrera" style="display: none;">Código de carrera</th>
                        <th class="col_nombre_corto_carrera" style="display: none;">Nombre corto de carrera</th>
                        <th class="col_nombre_largo_carrera" >Carrera</th>
                        <th class="col_nombre_corto_asignatura" style="display: none;">Nombre corto de asignatura</th>
                        <th class="col_nombre_largo_asignatura" >Asignatura</th>
                        <th class="col_anio">Año</th>
                        <th class="col_dia_lunes">Lunes</th>
                        <th style="display: none;">Hora inicio</th>
                        <th style="display: none;">Hora fin</th>
                        <th style="display: none;">Sector</th>
                        <th style="display: none;">Aula</th>
                        <th style="display: none;">Fecha de edición</th>
                        <th class="col_dia_martes" >Martes</th>
                        <th style="display: none;">Hora inicio</th>
                        <th style="display: none;">Hora fin</th>
                        <th style="display: none;">Sector</th>
                        <th style="display: none;">Aula</th>
                        <th style="display: none;">Fecha de edición</th>
                        <th class="col_dia_miercoles">Miercoles</th>
                        <th style="display: none;">Hora inicio</th>
                        <th style="display: none;">Hora fin</th>
                        <th style="display: none;">Sector</th>
                        <th style="display: none;">Aula</th>
                        <th style="display: none;">Fecha de edición</th>
                        <th class="col_dia_jueves">Jueves</th>
                        <th style="display: none;">Hora inicio</th>
                        <th style="display: none;">Hora fin</th>
                        <th style="display: none;">Sector</th>
                        <th style="display: none;">Aula</th>
                        <th style="display: none;">Fecha de edición</th>
                        <th class="col_dia_viernes">Viernes</th>
                        <th style="display: none;">Hora inicio</th>
                        <th style="display: none;">Hora fin</th>
                        <th style="display: none;">Sector</th>
                        <th style="display: none;">Aula</th>
                        <th style="display: none;">Fecha de edición</th>
                        <th class="col_dia_sabado">Sabado</th>
                        <th style="display: none;">Hora inicio</th>
                        <th style="display: none;">Hora fin</th>
                        <th style="display: none;">Sector</th>
                        <th style="display: none;">Aula</th>
                        <th style="display: none;">Fecha de edición</th>
                        <th title="Operaciones disponibles" class="text-center">Operaciones</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $codigo = $resultado[0];
    $mensaje = $resultado[1];
    $cuerpo = ControladorHTML::mostrarAlertaResultadoBusqueda($codigo, $mensaje);
}

echo ControladorHTML::mostrarCardResultadoBusqueda($filtro, $cuerpo);
