<?php
require_once './app/principal/modelos/Constantes.php';
require_once './app/principal/modelos/AutoCargador.php';
AutoCargador::cargarModulos();

$usuario = unserialize($_SESSION['user']);
$rol = $usuario->getRol();
$permisos = $rol->getPermisos();
$nombres = array_column($permisos, 'nombre');

$filas = '';
if (array_search("CURSADAS", $nombres) !== false) {
    $controladorCursada = new ControladorCursada();
    $resumenCursada = $controladorCursada->listarResumenInicial();
    if (gettype($resumenCursada) == "object") {
        while ($cursada = $resumenCursada->fetch_assoc()) {
            $filas .= "
            <tr>
                <td class='align-middle'>Horarios de cursada</td>
                <td class='align-middle'>" . utf8_encode($cursada['nombre']) . "</td>
                <td class='align-middle'>{$cursada['cantidad']}</td>
            </tr>";
        }
    } else {
        $filas .= "
            <tr>
                <td class='align-middle'>Horarios de cursada</td>
                <td class='align-middle'>Sin información</td>
                <td class='align-middle'></td>
            </tr>";
    }
}

if (array_search("MESAS", $nombres) !== false) {
    $controladorMesa = new ControladorMesa();
    $resumenMesa = $controladorMesa->listarResumenInicial();
    if (gettype($resumenMesa) == "object") {
        while ($mesa = $resumenMesa->fetch_assoc()) {
            $filas .= "
            <tr>
                <td class='align-middle'>Mesas de examen</td>
                <td class='align-middle'>" . utf8_encode($mesa['nombre']) . "</td>
                <td class='align-middle'>{$mesa['cantidad']}</td>
            </tr>";
        }
    } else {
        $filas .= "
            <tr>
                <td class='align-middle'>Mesas de examen</td>
                <td class='align-middle'>Sin información</td>
                <td class='align-middle'></td>
            </tr>";
    }
}

if (array_search("USUARIOS", $nombres) !== false) {
    $controladorUsuario = new ControladorUsuarios();
    $resumenUsuario = $controladorUsuario->listarResumenInicial();
    if (gettype($resumenUsuario) == "object") {
        while ($user = $resumenUsuario->fetch_assoc()) {
            $filas .= "
            <tr>
                <td class='align-middle'>Usuarios</td>
                <td class='align-middle'>" . utf8_encode($user['nombre']) . "</td>
                <td class='align-middle'>{$user['cantidad']}</td>
            </tr>";
        }
    } else {
        $filas .= "
            <tr>
                <td class='align-middle'>Usuarios</td>
                <td class='align-middle'>Sin información</td>
                <td class='align-middle'></td>
            </tr>";
    }
}

if (array_search("ROLES", $nombres) !== false) {
    $controladorRol = new ControladorRoles();
    $resumenRol = $controladorRol->listarResumenInicial();
    if (gettype($resumenRol) == "object") {
        while ($roles = $resumenRol->fetch_assoc()) {
            $filas .= "
            <tr>
                <td class='align-middle'>Roles</td>
                <td class='align-middle'>" . utf8_encode($roles['nombre']) . "</td>
                <td class='align-middle'>{$roles['cantidad']}</td>
            </tr>";
        }
    } else {
        $filas .= "
            <tr>
                <td class='align-middle'>Roles</td>
                <td class='align-middle'>Sin información</td>
                <td class='align-middle'></td>
            </tr>";
    }
}

if (array_search("PERMISOS", $nombres) !== false) {
    $controladorPermiso = new ControladorPermisos();
    $resumenPermiso = $controladorPermiso->listarResumenInicial();
    if (gettype($resumenPermiso) == "object") {
        while ($permiso = $resumenPermiso->fetch_assoc()) {
            $filas .= "
            <tr>
                <td class='align-middle'>Permisos</td>
                <td class='align-middle'>" . utf8_encode($permiso['nombre']) . "</td>
                <td class='align-middle'>{$permiso['cantidad']}</td>
            </tr>";
        }
    } else {
        $filas .= "
            <tr>
                <td class='align-middle'>Permisos</td>
                <td class='align-middle'>Sin información</td>
                <td class='align-middle'></td>
            </tr>";
    }
}


$tabla = '
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Módulo</th>
                    <th>Titulo</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>' . $filas . '</tbody>
        </table>    
    </div>';
?>
<div class="container-fluid" id="FormBuscarAsignatura">
    <div id="seccionSuperior" class="container mt-2 mb-2">
        <div class="row mt-sm-3 mb-4">
            <div class="col align-middle">
                <h3>INICIO</h3>
            </div>
        </div>
    </div>
    <div id="seccionCentral" class="container">
        <div class="card border-dark" title="Información de usuario">
            <div class="card-header bg-dark text-white"><i class="fas fa-user"></i> INFORMACIÓN DE USUARIO</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-2">
                        <img src="<?= $usuario->getImagen(); ?>" class="rounded img-fluid">
                    </div>
                    <div class="col">
                        <div class="form-row mt-2">
                            <div class="col">
                                <p class="card-text">
                                    <b><?= $usuario->getNombre(); ?>:</b>
                                    Le damos la bienvenida a <b>TEMPUS</b>
                                </p>
                            </div>
                        </div>
                        <div class="form-row mt-2">
                            <div class="col">
                                <p class="card-text">
                                    Usted se ha identificado con el correo electrónico 
                                    <b><?= utf8_encode($usuario->getEmail()); ?></b>
                                </p>
                            </div>
                        </div>
                        <div class="form-row mt-2">
                            <div class="col">
                                <p class="card-text">El rol que posee asignado actualmente es:
                                    <b><?= utf8_encode($usuario->getRol()->getNombre()); ?></b>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-dark mt-2 mb-4" title="Información resumida">
            <div class="card-header bg-dark text-white"><i class="fas fa-info-circle"></i> RESUMEN DEL SISTEMA</div>
            <div class="card-body"> <?= $tabla; ?></div>
        </div>
    </div>
</div>