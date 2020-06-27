<?php
/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\aula\modelo\Aula;
use app\principal\controlador\ControladorHTML;
use app\principal\modelo\AutoCargador;

AutoCargador::cargarModulos();

$contenido = $botones = "";
if (isset($_POST['idAula'])) {
    $idAula = $_POST['idAula'];
    $aula = new Aula($idAula);
    $resultado = $aula->obtenerPorIdentificador();
    if ($resultado[0] == 2) {
        $sector = $aula->getSector();
        $nombre = $aula->getNombre();
        $contenido = '
            <input type="hidden" name="idAula" id="idAula" value="' . $idAula . '">
            <div class="form-row">
                <label for="sector" class="col-sm-2 col-form-label text-left" 
                       title="Campo obligatorio">* Sector:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2"
                           id="sector" name="sector" s
                           minlength="1" maxlength="1" pattern="[A-Za-z]"
                           value = "' . $sector . '"
                           title="Escriba el nombre del sector. Longitud mímina: 1. Longitud máxima: 1."
                           placeholder="Nombre del sector" required>
                </div>
                <label for="nombre" class="col-sm-2 col-form-label text-left" 
                       title="Campo obligatorio">* Nombre:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2"
                           id="nombre" name="nombre"
                            pattern="[A-Za-zÁÉÍÓÚÑáéíóúñ0-9 ]{1,40}"
                           minlength="1" maxlength="40" 
                           value = "' . $nombre . '"
                           title = "Escriba el nombre del aula. Longitud mínima: 1. Longitud máxima: 40." 
                           placeholder="Nombre del aula" required>
                </div>
            </div>';
        $botones = '
            <button type="submit" class="btn btn-success" 
                    id="btnModificarAula" title="Guardar datos" disabled>
                    <i class="far fa-save"></i> GUARDAR
            </button>';
    } else {
        $codigo = $resultado[0];
        $mensaje = $resultado[1];
        $contenido = ControladorHTML::mostrarAlertaResultadoBusqueda($codigo, $mensaje);
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $contenido = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}
?>
<div class="container">
    <div class="form-row mt-4 mb-4">
        <div class="col text-left">
            <h4><i class="fas fa-chalkboard"></i> MODIFICAR AULA</h4>
        </div>
        <div class="col text-right">
            <a href="../../principal/vista/home.php">
                <button class="btn btn-sm btn-outline-secondary" 
                        title="Cerrar página actual"> 
                    <i class="fas fa-times"></i> CERRAR
                </button>
            </a>
        </div>
    </div>
    <div id="seccionResultado"></div>
    <div id="seccionFormulario">
        <form id="formModificarAula" name="formModificarAula" method="POST">
            <div class="card border-dark">
                <div class="card-header bg-dark text-white"
                     title="Formulario de modificación">Modifique la información y presione GUARDAR</div>
                <div class="card-body"><?= $contenido; ?></div>
            </div>
            <div class="form-row"> 
                <div class="col text-right mt-2">
                    <?= $botones; ?>
                    <a href="FormBuscarAula.php" title="Ir al formulario de búsqueda">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-search"></i> BUSCAR
                        </button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="../js/ModificarAula.js"></script>