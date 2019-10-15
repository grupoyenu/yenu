<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();

$contenido = $botones = "";
if (isset($_POST['idAula'])) {
    $aula = new Aula($_POST['idAula']);
    $obtener = $aula->obtener();
    if ($obtener == 2) {
        $contenido = '
            <input type="hidden" name="idAula" id="idAula" value="' . $aula->getIdAula() . '">
            <div class="form-row">
                <label for="sector" class="col-sm-2 col-form-label text-left" title="Campo obligatorio">* Sector:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2"
                           id="sector" name="sector"  pattern="[A-Za-z]"
                           minlength="1" maxlength="1" 
                           value = "' . $aula->getSector() . '"
                           placeholder="Nombre del sector" title="Nombre del sector: campo obligatorio" required>
                </div>
                <label for="nombre" class="col-sm-2 col-form-label text-left" title="Campo obligatorio">* Nombre:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2"
                           id="nombre" name="nombre" pattern="[A-Za-zÁÉÍÓÚÑáéíóúñ0123456789 ]{1,40}"
                           minlength="1" maxlength="40" 
                           value = "' . $aula->getNombre() . '"
                           placeholder="Nombre del aula" title = "Nombre del aula: campo obligatorio" required>
                </div>
            </div>';
        $botones = '<button type="submit" class="btn btn-success" 
                            id="btnModificarAula" title="Guardar datos" disabled>
                        <i class="far fa-save"></i> GUARDAR
                    </button>
                    <a href="aula_buscar">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-search"></i> BUSCAR
                        </button>
                    </a>';
    } else {
        $contenido = ControladorHTML::mostrarAlertaResultadoBusqueda($obtener, $aula->getDescripcion());
        $botones = '<a href="aula_buscar">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-search"></i> BUSCAR
                        </button>
                    </a>';
    }
} else {
    $contenido = '<div class="alert alert-danger text-center" role="alert"> 
                    <i class="fas fa-exclamation-triangle"></i> 
                    <strong>No se obtuvo la informaciòn desde el formulario</strong>
                </div>';
    $botones = '<a href="aula_buscar">
                    <button type="button" class="btn btn-outline-info">
                        <i class="fas fa-search"></i> BUSCAR
                    </button>
                </a>';
}
?>

<div class="container">
    <div class="form-row mt-4 mb-4">
        <div class="col text-left"><h4><i class="fas fa-chalkboard"></i> MODIFICAR AULA</h4></div>
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
        <form id="formModificarAula" name="formModificarAula" method="POST">
            <div class="card">
                <div class="card-header">Formulario de modificación</div>
                <div class="card-body"><?= $contenido; ?></div>
            </div>
            <div class="form-row"> 
                <div class="col text-right mt-2"><?= $botones; ?></div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="./app/aulas/js/ModificarAula.js"></script>