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
    $datos = ($nombreCarrera) ? "Carrera : {$nombreCarrera}," : "Carrera: TODAS, ";
    $datos .= ($nombreAsignatura) ? "Asignatura '{$nombreAsignatura}'" : "Asignatura: TODAS";
    $filtro = "Resultado de la búsqueda: " . $datos;
    $resultado = $controlador->buscarPorCarreraAsignatura($nombreCarrera, $nombreAsignatura);
    $_SESSION['BUSCUR'] = array($nombreCarrera, $nombreAsignatura, $datos);
} else {
    if (isset($_SESSION['BUSCUR'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BUSCUR'];
        $nombreCarrera = $parametros[0];
        $nombreAsignatura = $parametros[1];
        $filtro = "Última búsqueda realizada: " . $parametros[2];
        $resultado = $controlador->buscarPorCarreraAsignatura($nombreCarrera, $nombreAsignatura);
        $_SESSION['BUSCUR'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $limite = 20;
        $resultado = $controlador->listarResumenCursadas($limite);
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
                <td style='display: none;'>{$codigoCarrera}</td>
                <td style='display: none;'>{$nombreCortoCarrera}</td>
                <td class='align-middle'>{$nombreLargoCarrera}</td>
                <td style='display: none;'>{$nombreCortoAsignatura}</td>
                <td class='align-middle'>{$nombreLargoAsignatura}</td>
                <td class='align-middle'>{$anio}</td>
                <td class='align-middle'>{$lunes}</td>
                <td style='display: none;'>{$horaInicioLunes}</td>
                <td style='display: none;'>{$horaFinLunes}</td>
                <td style='display: none;'>{$sectorAulaLunes}</td>
                <td style='display: none;'>{$nombreAulaLunes}</td>
                <td style='display: none;'>{$fechaEdicionLunes}</td>
                <td class='align-middle'>{$martes}</td>
                <td style='display: none;'>{$horaInicioMartes}</td>
                <td style='display: none;'>{$horaFinMartes}</td>
                <td style='display: none;'>{$sectorAulaMartes}</td>
                <td style='display: none;'>{$nombreAulaMartes}</td>
                <td style='display: none;''>{$fechaEdicionMartes}</td>
                <td class='align-middle'>{$miercoles}</td>
                <td style='display: none;'>{$horaInicioMiercoles}</td>
                <td style='display: none;'>{$horaFinMiercoles}</td>
                <td style='display: none;'>{$sectorAulaMiercoles}</td>
                <td style='display: none;'>{$nombreAulaMiercoles}</td>
                <td style='display: none;'>{$fechaEdicionMiercoles}</td>
                <td class='align-middle'>{$jueves}</td>
                <td style='display: none;'>{$horaInicioJueves}</td>
                <td style='display: none;'>{$horaFinJueves}</td>
                <td style='display: none;'>{$sectorAulaJueves}</td>
                <td style='display: none;'>{$nombreAulaJueves}</td>
                <td style='display: none;'>{$fechaEdicionJueves}</td>
                <td class='align-middle'>{$viernes}</td>
                <td style='display: none;'>{$horaInicioViernes}</td>
                <td style='display: none;'>{$horaFinViernes}</td>
                <td style='display: none;'>{$sectorAulaViernes}</td>
                <td style='display: none;'>{$nombreAulaViernes}</td>
                <td style='display: none;'>{$fechaEdicionViernes}</td> 
                <td class='align-middle'>{$sabado}</td>
                <td style='display: none;'>{$horaInicioSabado}</td>
                <td style='display: none;'>{$horaFinSabado}</td>
                <td style='display: none;'>{$sectorAulaSabado}</td>
                <td style='display: none;'>{$nombreAulaSabado}</td>
                <td style='display: none;'>{$fechaEdicionSabado}</td>
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>
                        <button class='btn btn-outline-info detalle' 
                                title='Ver detalle'><i class='fas fa-eye'></i>
                        </button>
                        <button class='btn btn-outline-warning editar' 
                                name='$idPlan' id='$idPlan' 
                                title='Editar'><i class='far fa-edit'></i>
                        </button>
                        <button class='btn btn-outline-danger borrar' 
                                name='{$idPlan}' id='{$idPlan}' 
                                title='Borrar'><i class='fas fa-trash'></i>
                        </button>
                    </div>
                </td>
            </tr>";
    }
    $cuerpo = '
        <div class="table-responsive mt-4 mb-4">
            <table id="tablaBuscarCursadas" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th style="display: none;">Código de carrera</th>
                        <th style="display: none;">Nombre corto de carrera</th>
                        <th>Carrera</th>
                        <th style="display: none;">Nombre corto de asignatura</th>
                        <th>Asignatura</th>
                        <th>Año</th>
                        <th title="">Lunes</th>
                        <th style="display: none;">Hora inicio</th>
                        <th style="display: none;">Hora fin</th>
                        <th style="display: none;">Sector</th>
                        <th style="display: none;">Aula</th>
                        <th style="display: none;">Fecha de edición</th>
                        <th title="">Martes</th>
                        <th style="display: none;">Hora inicio</th>
                        <th style="display: none;">Hora fin</th>
                        <th style="display: none;">Sector</th>
                        <th style="display: none;">Aula</th>
                        <th style="display: none;">Fecha de edición</th>
                        <th title="">Miercoles</th>
                        <th style="display: none;">Hora inicio</th>
                        <th style="display: none;">Hora fin</th>
                        <th style="display: none;">Sector</th>
                        <th style="display: none;">Aula</th>
                        <th style="display: none;">Fecha de edición</th>
                        <th title="">Jueves</th>
                        <th style="display: none;">Hora inicio</th>
                        <th style="display: none;">Hora fin</th>
                        <th style="display: none;">Sector</th>
                        <th style="display: none;">Aula</th>
                        <th style="display: none;">Fecha de edición</th>
                        <th title="">Viernes</th>
                        <th style="display: none;">Hora inicio</th>
                        <th style="display: none;">Hora fin</th>
                        <th style="display: none;">Sector</th>
                        <th style="display: none;">Aula</th>
                        <th style="display: none;">Fecha de edición</th>
                        <th title="">Sabado</th>
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
    $mensaje = $resultado[0];
    $cuerpo = ControladorHTML::mostrarAlertaResultadoBusqueda($codigo, $mensaje);
}

echo ControladorHTML::mostrarCardResultadoBusqueda($filtro, $cuerpo);
