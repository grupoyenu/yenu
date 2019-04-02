<?php


require_once './app/vistas/header.php';
    echo '
    <meta name="google-signin-client_id" content="356408280239-7airslbg59lt2nped9l4dtqm2rf25aii.apps.googleusercontent.com" />
    <div class="container">
        <h2 class="text-center p-4">SISTEMA TEMPUS</h2>
        <div class="container">
            <div class="row">
                <div class="col">
                    <div>
                        <p>Bienvenido a la aplicación Tempus, a través de la cual podrá importar y consultar horarios de cursada y mesas de examen.</p>

                        <h6>Ingreso al Sistema</h6>
                        <p>Usted puede consultar el sistema si está conectado a su e-mail Institucional. Por favor haga click en el botón a continuación y elija su cuenta institucional.</p>


                        <div id="okgoogle" class="g-signin2" data-onsuccess="onSignIn" title="Acceder al Sistema Tempus"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://apis.google.com/js/platform.js" async defer></script>
    <script type="text/javascript" src="./lib/js/login.js"></script>';
    require_once './app/vistas/footer.php';