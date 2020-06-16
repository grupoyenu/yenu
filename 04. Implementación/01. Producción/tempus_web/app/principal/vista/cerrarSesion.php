<?php
session_unset();
$_SESSION['user'] = null;
include_once '../vista/header.php';
?>
<div class="container-fluid" id="FormBuscarAsignatura">
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
                        <i class="fab fa-google"></i> MI CUENTA INSTITUCIONAL
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>