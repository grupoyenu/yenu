<?php
require_once './app/principal/modelo/Constantes.php';
require_once './app/principal/modelo/Autocargador.php';

use app\principal\controlador\ControladorPrincipal;
use app\principal\modelo\AutoCargador;
use app\principal\modelo\Log;

AutoCargador::cargarModulos();

session_start();

$intentoIngresar = "";
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $googleId = $_POST['googleid'];
    $imagen = $_POST['imagen'];
    $controlador = new ControladorPrincipal();
    $resultado = $controlador->ingresarPorGoogle($email, $googleId, $imagen);
    if ($resultado[0] == 2) {
        Log::guardar("INF", "INGRESO DE USUARIO");
        header("Location: app/principal/vista/home.php");
    } else {
        $email = $_POST['email'];
        $intentoIngresar = '<input type="hidden" name="intentoIngresar" id="intentoIngresar" value="' . $email . '">';
        echo "NO SE INGRESO";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>TEMPUS</title>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="google-signin-client_id" content="1056974432246-kulm9sqknp35v7l9a317al9pmsiejaja.apps.googleusercontent.com" />
        <!-- Hojas de estilo -->
        <link rel="stylesheet" type='text/css' href="./lib/css/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" type='text/css' href="./lib/css/EstiloPrincipal.css">
        <link rel="stylesheet" type='text/css' href="./lib/css/fontAwesome/css/all.min.css">
        <!-- Archivos JavaScript -->
        <script type='text/javascript' src='./lib/js/jquery-3.3.1/jquery-3.3.1.min.js'></script>
        <script type='text/javascript' src='./lib/js/bootstrap/bootstrap.min.js'></script>
        <script type='text/javascript' src="./lib/css/fontAwesome/js/all.min.js"></script>
        <script type='text/javascript' src="./app/principal/js/principal.js"></script>
        <script type="text/javascript" src="https://apis.google.com/js/platform.js" async defer></script>
        <script type="text/javascript" src="./lib/js/login.js"></script>
    </head>
    <body>
        <header id="main-header">
            <a id="logo-header" href="">
                <span class="site-name">TEMPUS</span>
                <span class="site-desc">SIT UNPA-UARG</span>
            </a>
        </header>
        <div class="container-fluid" id="contenido">
            <div class="container">
                <div class="form-row mt-4 mb-4">
                    <div class="col text-left"><h4>TEMPUS</h4></div>
                </div> 
                <div class="mt-4 mb-4">
                    <div class="card border-dark">
                        <div class="card-header bg-dark text-white">Le damos la bienvenida</div>
                        <div class="card-body">
                            <div class="form-row">
                                <p class="card-text">
                                    <b>Estimado agente:</b>
                                </p>
                            </div>
                            <div class="form-row mt-3">
                                <p class="card-text"> Le brindamos la bienvenida a la aplicación 
                                    <b>TEMPUS</b>, a través de la cual puede gestionar los horarios 
                                    de cursada y las mesas de examen.
                                </p>
                            </div>
                            <div class="form-row mt-3">
                                <p class="card-text text-justify"> Usted puede ingresar al sistema si está conectado
                                    a su correo electrónico institucional. Para ello, por favor haga click en el 
                                    botón <b>"Inicia sesión"</b> y a continuación elija su cuenta institucional.
                                </p>
                            </div>
                            <div class="form-row mt-3">
                                <div class="col text-right">
                                    <div id="okgoogle" class="g-signin2" data-onsuccess="onSignIn" 
                                         title="Acceder al Sistema Tempus"></div>
                                </div>
                            </div>
                            <?= $intentoIngresar; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer id="main-footer">
            <p>
                &copy; Servicio de Inform&aacute;tica y Telecomunicaciones (SIT) - UARG <br /> 
                <b>Enlaces</b> .:
                <a href="http://www.uarg.unpa.edu.ar" target="_blank" title="Ir a Portal UARG">Portal UARG</a> :: 
                <a href="../Instructivo.pdf" target="_blank" title="Ver Manual de Uso">Manual de Uso</a> :.
            </p>
        </footer>

    </body>
</html>


