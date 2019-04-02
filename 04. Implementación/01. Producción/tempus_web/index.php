<?php

require_once './app/controladores/Autoload.php';
$autoload = new Autoload();

$ruta = isset($_GET['ruta']) ? $_GET['ruta'] : "home";
$controlador = new ControladorPrincipal($ruta);





