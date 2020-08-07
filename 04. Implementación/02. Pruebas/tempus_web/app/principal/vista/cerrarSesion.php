<?php
session_start();

/* REDIRECCIONA CUANDO SE INTENTA ACCEDER DIRECTAMENTE A LA URL */
if (!isset($_SESSION['user'])) {
    header("Location: ../../../index.php");
}

/* DESTRUYE TODAS LAS VARIABLES DE LA SESION */

$_SESSION = array();

/* BORRA LA COOKIE DE LA SESION */

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]
    );
}

/* DESTRUYE LA SESION */
session_destroy();

include_once '../vista/header.php';
?>
<div class="container-fluid">
    <div id="seccionSuperior" class="container mt-2 mb-2">
        <div class="row mt-sm-3 mb-4">
            <div class="col align-middle">
                <h3>¡HASTA LUEGO!</h3>
            </div>
        </div>
    </div>
    <div id="seccionCentral" class="container">
        <div class="card border-dark" title="Información sobre el cierre de sesión">
            <div class="card-header bg-dark text-white"><i class="fas fa-info-circle"></i> INFORMACIÓN DE SALIDA</div>
            <div class="card-body">
                <div class="form-row mt-2">
                    <div class="col">
                        <p class="card-text">Usted ha cerrado sesión en <b>TEMPUS</b> pero su correo electrónico institucional aún continua abierto</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-row mt-2 mb-4">
            <div class="col text-right">
                <a href="../../../index.php" title="Ingresar a TEMPUS">
                    <button type="button" class="btn btn-success" >
                        <i class="fas fa-sign-in-alt"></i> INGRESAR
                    </button>
                </a>
                <a href="http://www.gmail.com" title="Ir a mi cuenta de GMAIL">
                    <button type="button" class="btn btn-info" >
                        <i class="fab fa-google"></i> MI CUENTA GMAIL
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>