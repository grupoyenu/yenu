<?php

require_once './app/principal/modelos/Constantes.php';
require_once './app/principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$controlador = new ControladorUsuarios();
if (isset($_POST['btnBuscarUsuario'])) {
    
} else {
    
}