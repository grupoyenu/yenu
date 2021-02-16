<?php
/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\carrera\modelo\Carrera;
use app\principal\controlador\ControladorHTML;
use app\principal\modelo\AutoCargador;

AutoCargador::cargarModulos();

$boton = "";
if (isset($_POST['codigo'])) {
    $id = $_POST['codigo'];
    $carrera = new Carrera($id);
    $resultado = $carrera->obtenerPorIdentificador();
    if ($resultado[0] == 2) {
        $codigo = str_pad($id, 3, "0", STR_PAD_LEFT);
        $nombreCorto = $carrera->getNombreCorto();
        $nombreLargo = $carrera->getNombreLargo();
        $cuerpo = '
            <input type="hidden" name="codigo" id="codigo" value="' . $id . '">
            <div class="form-row">
                <label class="col-sm-2 col-form-label text-left"
                       title="Caracter informativo">Código:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           value="' . $codigo . '" 
                           title="Código de la carrera" disabled>
                </div>
                <label class="col-sm-2 col-form-label text-left"
                       title="Caracter informativo">Nombre corto:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           value="' . $nombreCorto  . '" 
                           title="Nombre corto de la carrera" disabled>
                </div>
            </div>
            <div class="form-row">
                <label class="col-sm-2 col-form-label text-left"
                       title="Caracter informativo">Nombre largo:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           value="' . $nombreLargo  . '" 
                           title="Nombre corto de la carrera" disabled>
                </div>
            </div>
            <hr>
            <div class="form-row">
                <label for="asignatura" class="col-sm-2 col-form-label"
                       title="Caracter obligatorio">* Asignatura:</label>
                <div class="col">
                    <select class="form-control mb-2" 
                            id="asignatura" name="asignatura" 
                            title="Escriba el nombre de la asignatura a seleccionar" required></select>
                </div>
                <label for="anio" class="col-sm-2 col-form-label"
                       title="Caracter obligatorio">* Año:</label>
                <div class="col">
                    <select class="form-control mb-2" id="anio" name="anio" title="Seleccione año de cursada">
                        <option value="1">1°</option>
                        <option value="2">2°</option>
                        <option value="3">3°</option>
                        <option value="4">4°</option>
                        <option value="5">5°</option>
                    </select>
                </div>
            </div>';
        $boton = '<button type="submit" class="btn btn-success" 
                        id="btnAgregarAsignatura" title="Guardar datos">
                    <i class="far fa-save"></i> GUARDAR
                </button>';
    } else {
        $codigo = $resultado[0];
        $mensaje = $resultado[1];
        $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion($codigo, $mensaje);
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}
?>
<div class="container">
    <div class="form-row mt-4 mb-4">
        <div class="col text-left">
            <h4><i class="fas fa-graduation-cap"></i> AGREGAR ASIGNATURA A CARRERA</h4>
        </div>
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
        <form id="formAgregarAsignatura" name="formAgregarAsignatura" method="POST">
            <div class="card border-dark">
                <div class="card-header bg-dark text-white" title="Formulario de creación">Complete el formulario y presione GUARDAR</div>
                <div class="card-body"><?= $cuerpo; ?></div>
            </div>
            <div class="form-row mt-2 mb-4">
                <div class="col text-right">
                    <?= $boton; ?>
                    <a href="FormBuscarCarrera.php" title="Ir al formulario de búsqueda">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-search"></i> BUSCAR
                        </button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="../js/AgregarAsignatura.js"></script>