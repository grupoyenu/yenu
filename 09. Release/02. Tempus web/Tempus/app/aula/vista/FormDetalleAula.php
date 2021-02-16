<?php
/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\aula\modelo\Aula;
use app\principal\controlador\ControladorHTML;
use app\principal\modelo\AutoCargador;
use app\util\modelo\Util;

AutoCargador::cargarModulos();

if (isset($_POST['idAula'])) {
    $idAula = $_POST['idAula'];
    $aula = new Aula($idAula);
    $datosAula = $aula->obtenerPorIdentificador();
    if ($datosAula[0] == 2) {
        $sector = $aula->getSector();
        $nombre = $aula->getNombre();
        $fechaCreacion = date_format(date_create($aula->getFechaCreacion()), 'd/m/Y');
        $horaCreacion = date_format(date_create($aula->getFechaCreacion()), 'H:m');
        $datosClase = $aula->obtenerClases();
        $datosMesa = $aula->obtenerMesasExamen();
        $formulario = '
            <div class="card border-dark mb-2 mt-2">
                <div class="card-header bg-dark text-white">Información básica</div>
                <div class="card-body">
                    <div class="form-row">
                        <label for="sector" class="col-sm-2 col-form-label">Sector:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"
                                   value="' . $sector . '"
                                   placeholder="Nombre del sector"
                                   title="Nombre del sector" disabled>
                        </div>
                        <label for="nombre" class="col-sm-2 col-form-label">Nombre:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"
                                   value="' . $nombre . '"
                                   title = "Nombre del aula" disabled>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="sector" class="col-sm-2 col-form-label">Fecha de creación:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"
                                   value="' . $fechaCreacion . '"
                                   title="Fecha de creación" disabled>
                        </div>
                        <label for="nombre" class="col-sm-2 col-form-label">Hora de creación:</label>
                        <div class="col">
                            <input type="text" class="form-control mb-2"
                                   value="' . $horaCreacion . '"
                                   title = "Hora de creación" disabled>
                        </div>
                    </div>
                </div>
            </div>';

        if ($datosClase[0] == 2) {
            $filas = "";
            $clases = $aula->getClases();
            foreach ($clases as $clase) {
                $codigoCarrera = str_pad($clase['idCarrera'], 3, "0", STR_PAD_LEFT);
                $nombreCarrera = utf8_encode($clase['nombreLargoCarrera']);
                $nombreAsignatura = utf8_encode($clase['nombreLargoAsignatura']);
                $diaSemana = $clase['diaSemana'];
                $nombreDiaSemana = Util::obtenerNombreDia($diaSemana);
                $horaInicio = substr($clase['horaInicio'], 0, 5);
                $horaFin = substr($clase['horaFin'], 0, 5);
                $filas .= "
                    <tr>
                        <td class='align-middle'>{$nombreDiaSemana}</td>
                        <td class='align-middle'>{$codigoCarrera}</td>
                        <td class='align-middle'>{$nombreCarrera}</td>
                        <td class='align-middle'>{$nombreAsignatura}</td>
                        <td class='align-middle'>{$horaInicio}</td>
                        <td class='align-middle'>{$horaFin}</td>
                    </tr>";
            }
            $formulario .= '
                <div class="card border-dark mb-2 mt-2">
                    <div class="card-header bg-dark text-white">Horarios de clase asignados</div>
                    <div class="card-body">
                        <div class="table-responsive mb-4 mt-4">
                            <table id="tablaCursadasAula" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Día</th>
                                        <th>Código de carrera</th>
                                        <th>Nombre de carrera</th>
                                        <th>Asignatura</th>
                                        <th>Hora de inicio</th>
                                        <th>Hora de fin</th>
                                    </tr>
                                </thead>
                                <tbody>' . $filas . '</tbody>
                            </table>
                        </div>
                    </div>
                </div>';
        } 

        if ($datosMesa[0] == 2) {
            $filas = "";
            $mesasExamen = $aula->getMesas();
            foreach ($mesasExamen as $mesa) {
                $codigoCarrera = str_pad($mesa['codigoCarrera'], 3, "0", STR_PAD_LEFT);
                $nombreCarrera = utf8_encode($mesa['nombreLargoCarrera']);
                $nombreAsignatura = utf8_encode($mesa['nombreLargoAsignatura']);
                $estado = $mesa['estado'];
                $fecha = date_format(date_create($mesa['fecha']), 'd/m/Y');
                $hora = substr($mesa['hora'], 0, 5);
                $filas .= "
                    <tr>
                        <td class='align-middle'>{$codigoCarrera}</td>
                        <td class='align-middle'>{$nombreCarrera}</td>
                        <td class='align-middle'>{$nombreAsignatura}</td>
                        <td class='align-middle'>{$fecha}</td>
                        <td class='align-middle'>{$hora}</td>
                        <td class='align-middle'>{$estado}</td>
                    </tr>";
            }
            $formulario .= '
                <div class="card border-dark mb-2 mt-2">
                    <div class="card-header bg-dark text-white">Mesas de examen asignadas</div>
                    <div class="card-body">
                        <div class="table-responsive mb-4 mt-4">
                            <table id="tablaMesasAula" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Código Carrera</th>
                                        <th>Nombre Carrera</th>
                                        <th>Nombre Asignatura</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>' . $filas . '</tbody>
                            </table>
                        </div>
                    </div>
                </div>';
        }

    } else {
        $codigo = $datosAula[0];
        $mensaje = $datosAula[1];
        $formulario = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $formulario = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}
?>

<div class="container">
    <div class="form-row mt-4 mb-4">
        <div class="col text-left">
            <h4><i class="fas fa-chalkboard"></i> DETALLE AULA</h4>
        </div>
        <div class="col text-right">
            <a href="../../principal/vista/home.php">
                <button class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-times"></i> CERRAR
                </button>
            </a>
        </div>
    </div>
    <div id="seccionFormulario">
        <?= $formulario; ?>
        <div class="form-row mt-2 mb-4">
            <div class="col text-right">
                <a href="FormBuscarAula.php" title="Ir al formulario de búsqueda">
                    <button type="button" class="btn btn-outline-info">
                        <i class="fas fa-search"></i> BUSCAR
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="./js/DetalleAula.js"></script>