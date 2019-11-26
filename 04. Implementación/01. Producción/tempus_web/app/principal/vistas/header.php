<?php
$menu = $info = "";
if (isset($_SESSION['user'])) {
    $usuario = unserialize($_SESSION['user']);
    $rol = $usuario->getRol();
    $permisos = $rol->getPermisos();
    $nombres = array_column($permisos, 'nombre');
    $menu .= '
        <li class="nav-item active">
            <a class="nav-link" href="principal_home"> <i class="fas fa-home"></i> Home</a>
        </li>';
    if (array_search("CURSADAS", $nombres) !== false) {
        $menu .= '
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Cursadas
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="cursada_buscar">Buscar</a>
                    <a class="dropdown-item" href="cursada_crear">Crear</a>
                    <a class="dropdown-item" href="cursada_seleccionar">Importar</a>
                    <a class="dropdown-item" href="cursada_informe">Informe</a>
                </div>
            </li>';
    }
    if (array_search("MESAS", $nombres) !== false) {
        $menu .= '
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Mesas de examen
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="mesa_buscar">Buscar</a>
                    <a class="dropdown-item" href="mesa_crear">Crear</a>
                    <a class="dropdown-item" href="mesa_seleccionar">Importar</a>
                    <a class="dropdown-item" href="mesa_informe">Informe</a>
                </div>
            </li>';
    }
    if (array_search("PLANES", $nombres) !== false) {
        $menu .= '
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Carreras
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="carrera_buscar">Buscar</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Asignaturas
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="asignatura_buscar">Buscar</a>
                </div>
            </li>';
    }
    if (array_search("AULAS", $nombres) !== false) {
        $menu .= '
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Aulas
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="aula_buscar">Buscar</a>
                    <a class="dropdown-item" href="aula_crear">Crear</a>
                    <a class="dropdown-item" href="aula_informe">Informe</a>
                </div>
            </li>';
    }
    if (array_search("USUARIOS", $nombres) !== false) {
        $menu .= '
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Usuarios
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="usuario_buscarUsuario">Buscar</a>
                    <a class="dropdown-item" href="usuario_crearUsuario">Crear</a>
                </div>
            </li>';
    }
    if (array_search("ROLES", $nombres) !== false) {
        $menu .= '
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Roles
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="usuario_buscarRol">Buscar</a>
                    <a class="dropdown-item" href="usuario_crearRol">Crear</a>
                </div>
            </li>';
    }
    if (array_search("PERMISOS", $nombres) !== false) {
        $menu .= '
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Permisos
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="usuario_buscarPermiso">Buscar</a>
                    <a class="dropdown-item" href="usuario_crearPermiso">Crear</a>
                </div>
            </li>';
    }

    $info = '<li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-default"
                             aria-labelledby="navbarDropdownMenuLink-333">
                                 <a class="dropdown-item disabled">' . $usuario->getEmail() . '</a>
                                  <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="principal_cerrarSesion">Cerrar sesión</a>
                        </div>
                    </li>';
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>TEMPUS</title>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Hojas de estilo -->
        <link rel="stylesheet" type='text/css' href="./lib/css/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" type='text/css' href="./lib/css/EstiloPrincipal.css">
        <link rel='stylesheet' type='text/css' href='./lib/css/dataTables-1.10.16/jquery.dataTables.min.css'/>
        <link rel='stylesheet' type='text/css' href='./lib/css/buttons-1.4.2/buttons.dataTables.min.css'/>
        <link rel="stylesheet" type='text/css' href="./lib/css/fontAwesome/css/all.min.css">
        <link rel="stylesheet" type='text/css' href="./lib/js/select2/select2.min.css">
        <link rel="stylesheet" type='text/css' href="./lib/js/select2/select2.bootstrap.css">
        <!-- Archivos JavaScript -->
        <script type='text/javascript' src='./lib/js/jquery-3.3.1/jquery-3.3.1.min.js'></script>
        <script type='text/javascript' src='./lib/js/bootstrap/bootstrap.min.js'></script>
        <script type='text/javascript' src='./lib/js/dataTables-1.10.16/jquery.dataTables.min.js'></script>
        <script type='text/javascript' src='./lib/js/buttons-1.4.2/buttons.html5.min.js'></script>
        <script type='text/javascript' src='./lib/js/buttons-1.4.2/buttons.print.min.js'></script>
        <script type='text/javascript' src='./lib/js/buttons-1.4.2/buttons.flash.min.js'></script>
        <script type='text/javascript' src='./lib/js/buttons-1.4.2/jszip.min.js'></script>
        <script type='text/javascript' src='./lib/js/buttons-1.4.2/dataTables.buttons.min.js'></script>
        <script type='text/javascript' src='./lib/js/pdfmake-0.1.32/pdfmake.min.js'></script>
        <script type='text/javascript' src='./lib/js/pdfmake-0.1.32/vfs_fonts.js'></script>
        <script type='text/javascript' src="./lib/js/feather/feather.min.js"></script>
        <script type='text/javascript' src="./lib/js/select2/select2.min.js"></script>
        <script type='text/javascript' src="./lib/css/fontAwesome/js/all.min.js"></script>
        <script type='text/javascript' src="./app/principal/js/principal.js"></script>
    </head>
    <body>
        <header id="main-header">
            <a id="logo-header" href="">
                <span class="site-name">TEMPUS</span>
                <span class="site-desc">SIT UNPA-UARG</span>
            </a>
        </header>
        <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1b1919;">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <?= $menu; ?>
                </ul>
                <ul class="navbar-nav ml-auto nav-flex-icons">
                    <?= $info; ?>
                </ul>
            </div>
        </nav>