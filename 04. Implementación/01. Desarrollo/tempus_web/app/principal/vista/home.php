<?php
include_once '../vista/header.php';

use app\asignatura\controlador\ControladorAsignatura;
use app\aula\controlador\ControladorAula;
use app\carrera\controlador\ControladorCarrera;
use app\cursada\controlador\ControladorCursada;
use app\mesa\controlador\ControladorMesa;
use app\seguridad\controlador\ControladorPermiso;
use app\seguridad\controlador\ControladorRol;
use app\seguridad\controlador\ControladorUsuario;

$usuario = unserialize($_SESSION['user']);
$rol = $usuario->getRol();
$permisos = $rol->getPermisos();
$nombres = array_column($permisos, 'nombre');

$usuarioImagen = $usuario->getImagen();
$usuarioNombre = $usuario->getNombre();
$usuarioEmail = $usuario->getEmail();
$usuarioRol = $usuario->getRol()->getNombre();

$filas = '';

if (array_search("AULAS", $nombres) !== false) {
    $controlador = new ControladorAula();
    $informes = $controlador->listarInformesAula();
    if ($informes[0] == 2) {
        $aulas = $informes[1];
        foreach ($aulas as $aula) {
            $filas .= "
            <tr>
                <td class='align-middle'>Aulas</td>
                <td class='align-middle'>" . utf8_encode($aula['informe']) . "</td>
                <td class='align-middle'>{$aula['cantidad']}</td>
            </tr>";
        }
    } else {
        $filas .= "
            <tr>
                <td class='align-middle'>Aulas</td>
                <td class='align-middle'>Sin información</td>
                <td class='align-middle'></td>
            </tr>";
    }
}



if (array_search("CURSADAS", $nombres) !== false) {
    /*
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
      } */
}

if (array_search("MESAS", $nombres) !== false) {
    $controlador = new ControladorMesa();
    $informes = $controlador->listarInformesMesaExamen();
    if ($informes[0] == 2) {
        $mesas = $informes[1];
        foreach ($mesas as $mesa) {
            $filas .= "
                <tr>
                    <td class='align-middle'>Mesas de examen</td>
                    <td class='align-middle'>{$mesa['informe']}</td>
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
    $controlador = new ControladorUsuario();
    $informes = $controlador->listarInformesUsuario();
    if ($informes[0] == 2) {
        $usuarios = $informes[1];
        foreach ($usuarios as $usuario) {
            $filas .= "
            <tr>
                <td class='align-middle'>Usuarios</td>
                <td class='align-middle'>" . utf8_encode($usuario['informe']) . "</td>
                <td class='align-middle'>{$usuario['cantidad']}</td>
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
    $controlador = new ControladorRol();
    $informes = $controlador->listarInformesRol();
    if ($informes[0] == 2) {
        $roles = $informes[1];
        foreach ($roles as $rol) {
            $filas .= "
            <tr>
                <td class='align-middle'>Roles</td>
                <td class='align-middle'>" . utf8_encode($rol['informe']) . "</td>
                <td class='align-middle'>{$rol['cantidad']}</td>
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
    $controlador = new ControladorPermiso();
    $informes = $controlador->listarInformesPermiso();
    if ($informes[0] == 2) {
        $permisos = $informes[1];
        foreach ($permisos as $permiso) {
            $filas .= "
            <tr>
                <td class='align-middle'>Permisos</td>
                <td class='align-middle'>" . utf8_encode($permiso['informe']) . "</td>
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
    <div class="table-responsive mt-4 mb-4">
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
                        <img src="<?= $usuarioImagen; ?>" class="rounded img-fluid">
                    </div>
                    <div class="col">
                        <div class="form-row mt-2">
                            <div class="col">
                                <p class="card-text">
                                    <b><?= $usuarioNombre; ?>:</b>
                                    Le damos la bienvenida a <b>TEMPUS</b>
                                </p>
                            </div>
                        </div>
                        <div class="form-row mt-2">
                            <div class="col">
                                <p class="card-text">
                                    Usted se ha identificado con el correo electrónico 
                                    <b><?= $usuarioEmail; ?></b>
                                </p>
                            </div>
                        </div>
                        <div class="form-row mt-2">
                            <div class="col">
                                <p class="card-text">El rol que posee asignado actualmente es:
                                    <b><?= $usuarioRol; ?></b>
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