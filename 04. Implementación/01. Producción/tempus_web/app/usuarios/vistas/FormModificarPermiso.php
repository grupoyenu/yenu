<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$cuerpo = $boton = "";
if (isset($_POST['idPermiso'])) {

    $idPermiso = $_POST['idPermiso'];
    $permiso = new Permiso($idPermiso);
    $obtener = $permiso->obtener();
    if ($obtener == 2) {
        $cuerpo = '
            <input type="hidden" name="idPermiso" id="idPermiso" value="' . $permiso->getIdPermiso() . '">
            <div class="form-row"><label for="nombre" class="col-sm-2 col-form-label">* Nombre:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="nombre" id="nombre"
                           value=' . $permiso->getNombre() . '
                           placeholder="Nombre de permiso" required>
                </div>
            </div>';
        $boton = '<button type="submit" class="btn btn-success" 
                            id="btnModificarPermiso" title="Guardar datos" disabled>
                        <i class="far fa-save"></i> GUARDAR
                  </button>';
    } else {
        $cuerpo = ControladorHTML::mostrarAlertaResultadoBusqueda($obtener, $permiso->getDescripcion());
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}
?>
<div class="container">
    <div class="form-row mt-4 mb-4">
        <div class="col text-left"><h4><i class="fas fa-user-lock"></i> MODIFICAR PERMISO</h4></div>
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
        <form id="formModificarPermiso" name="formModificarPermiso" method="POST">
            <div class="card border-dark">
                <div class="card-header bg-dark text-white">Modifique el formulario y presione GUARDAR</div>
                <div class="card-body"><?= $cuerpo; ?></div>
            </div>
            <div class="form-row mt-2 mb-4">
                <div class="col text-right">
                    <?= $boton; ?>
                    <a href="usuario_buscarPermiso">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-search"></i> BUSCAR
                        </button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" src="./app/usuarios/js/ModificarPermiso.js"></script>
