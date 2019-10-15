<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$controlador = new ControladorAsignaturas();
$rows = $controlador->listar();

$html = "";
if (!empty($rows)) {
    $html = '
        <div class="form-row">
            <label for="asignatura" class="col-form-label text-left" title="Campo obligatorio">* Nombre:</label>
            <div class="col">
                <input name="asignatura" class="form-control mb-2" list="asignaturas" autocomplete="off">
                <datalist id="asignaturas">
            ';
    foreach ($rows as $asignatura) {
        $html .= "<option>{$asignatura['nombre']}</option>";
    }
    $html .= "  </datalist>
            </div>
        </div>";
} else {
    
}

echo $html;
