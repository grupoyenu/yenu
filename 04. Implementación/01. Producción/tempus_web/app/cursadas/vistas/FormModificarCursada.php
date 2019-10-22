<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();

$contenido = $botones = "";
if (isset($_POST['idCarrera']) && isset($_POST['idAsignatura'])) {
    
} else {
    $contenido = '<div class="alert alert-danger text-center" role="alert"> 
                    <i class="fas fa-exclamation-triangle"></i> 
                    <strong>No se obtuvo la información desde el formulario</strong>
                </div>';
    $botones = '<a href="cursada_buscar">
                    <button type="button" class="btn btn-outline-info">
                        <i class="fas fa-search"></i> BUSCAR
                    </button>
                </a>';
}
?>

<div class="container">
    <div class="form-row mt-4 mb-4">
        <div class="col text-left"><h4><i class="far fa-clock"></i> MODIFICAR HORARIO DE CURSADA</h4></div>
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
        <form id="formModificarCursada" name="formModificarCursada" method="POST">
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
<script type="text/javascript" src="./app/cursadas/js/ModificarCursada.js"></script>