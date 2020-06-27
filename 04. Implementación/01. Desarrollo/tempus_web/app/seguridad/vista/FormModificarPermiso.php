<?php
/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\seguridad\modelo\Permiso;
use app\principal\controlador\ControladorHTML;
use app\principal\modelo\AutoCargador;

AutoCargador::cargarModulos();

/* INICIALIZA LA SESION PARA GUARDAR EL LOG */

session_start();

/* INICIO DEL CODIGO PROPIO DEL ARCHIVO */

$cuerpo = $boton = "";
if (isset($_POST['idPermiso'])) {
    $idPermiso = $_POST['idPermiso'];
    $permiso = new Permiso($idPermiso);
    $obtener = $permiso->obtener();
    if ($obtener[0] == 2) {
        $nombre = $permiso->getNombre();
        $cuerpo = '
            <input type="hidden" name="idPermiso" id="idPermiso" value="' . $idPermiso . '">
            <div class="form-row">
                <label for="nombre" class="col-sm-2 col-form-label"
                       title="Campo obligatorio">* Nombre:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="nombre" id="nombre" 
                           maxlength="15" minlength="5" 
                           pattern="[A-Za-z_]{5,15}" value=' . $nombre . ' 
                           title="Escriba el nombre del permiso a crear. Longitud mínima: 5. Longitud máxima: 15."
                           placeholder="Nombre del permiso" required>
                </div>
            </div>';
        $boton = '
            <button type="submit" class="btn btn-success" 
                    id="btnModificarPermiso" title="Guardar datos" disabled>
                    <i class="far fa-save"></i> GUARDAR
            </button>';
    } else {
        $codigo = $obtener[0];
        $mensaje = $obtener[1];
        $cuerpo = ControladorHTML::mostrarAlertaResultadoBusqueda($codigo, $mensaje);
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}
?>
<div class="container">
    <div class="form-row mt-4 mb-4">
        <div class="col text-left">
            <h4><i class="fas fa-user-lock"></i> MODIFICAR PERMISO</h4>
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
        <form id="formModificarPermiso" name="formModificarPermiso" method="POST">
            <div class="card border-dark">
                <div class="card-header bg-dark text-white"
                     title="Formulario de modificación">Modifique la información y presione GUARDAR</div>
                <div class="card-body"><?= $cuerpo; ?></div>
            </div>
            <div class="form-row mt-2 mb-4">
                <div class="col text-right">
                    <?= $boton; ?>
                    <a href="FormBuscarPermiso.php" title="Ir al formulario de búsqueda">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-search"></i> BUSCAR
                        </button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" src="../js/ModificarPermiso.js"></script>
