<?php

/* Incluye el archivo con las constantes del sistema y el autocargador */
require_once './app/principal/modelos/Constantes.php';
require_once './app/principal/modelos/AutoCargador.php';

session_start();

/* Se cargan los modulos que sean necesarios */
AutoCargador::cargarModulos();

/* Define la ruta a la cual se redirecciona */
$ruta = isset($_GET['ruta']) ? $_GET['ruta'] : "principal_home";

/* El controlador principal continua con el flujo de tareas */
$controlador = new ControladorPrincipal($ruta);
