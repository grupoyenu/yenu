<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$html = "";
if (isset($_POST['id'])) {

    $idPermiso = $_POST['id'];
    $parametros = array($idPermiso, NULL);
    $permiso = new Permiso($parametros);
} else {
    $html = '<div class="alert alert-danger text-center" role="alert">No se obtuvo la información del formulario</div>';
}

echo $html;
