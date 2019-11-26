<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorPrincipal {

    private $modulos;
    private $controladorVista;

    public function __construct($ruta) {
        $this->controladorVista = new ControladorVista();
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['ok'])) {
            $_SESSION['ok'] = false;
        }
        if ($_SESSION['ok']) {
            $this->acceder($ruta);
        } else {
            if (isset($_POST['email'])) {
                $this->login($_POST['email'], $_POST['googleid'], $_POST['imagen']);
            } else {
                $this->controladorVista->cargarVista("principal", "ingreso");
            }
        }
    }

    private function acceder($ruta) {
        if ($ruta && (strpos($ruta, "_") !== false)) {
            $particion = explode("_", $ruta);
            $modulo = $particion[0];
            $vista = $particion[1];
            $this->evaluarModulo($modulo, $vista);
        } else {
            $_SESSION['tipoMensaje'] = 1;
            $_SESSION['mensaje'] = "No se detectó una página válida a la cual ingresar ({$ruta})";
            $this->controladorVista->cargarVista("principal", "error");
        }
    }

    private function evaluarModulo($modulo, $vista) {
        $this->modulos = array("aulas" => "aula",
            "cursadas" => "cursada",
            "mesas" => "mesa",
            "carreras" => "carrera",
            "asignaturas" => "asignatura",
            "planes" => "plan",
            "principal" => "principal",
            "usuarios" => "usuario");
        $archivo = array_search($modulo, $this->modulos);
        if ($archivo) {
            $this->controladorVista->evaluarVista($archivo, $vista);
        } else {
            $_SESSION['tipoMensaje'] = 1;
            $_SESSION['mensaje'] = "No se detectó una página válida a la cual ingresar";
            $this->controladorVista->cargarVista("principal", "error");
        }
    }

    private function login($email, $idGoogle, $imagen) {
        $usuario = new UsuarioGoogle();
        $usuario->setEmail($email);
        $obtener = $usuario->login();
        if ($obtener == 2 && $usuario->getEstado() == "Activo") {
            $_SESSION['ok'] = true;
            $_SESSION['user'] = serialize($usuario);
            if (!$usuario->getGoogleid()) {
                $usuario->setGoogleid($idGoogle);
                $usuario->setImagen($imagen);
                $usuario->crear();
            }
            Log::escribirLineaError("[Login: inicio de sesion ({$email})]");
            $this->controladorVista->cargarVista("principal", "home");
        } else {
            if ($usuario->getEstado() == "Inactivo") {
                Log::escribirLineaError("[Login: usuario inactivo ({$email})]");
                $_SESSION['tipoMensaje'] = 1;
                $_SESSION['mensaje'] = "Su estado actual no permite el ingreso al sistema";
                $this->controladorVista->cargarVista("principal", "error");
            } else {
                Log::escribirLineaError("[Login: {$usuario->getDescripcion()} ({$email})]");
                $_SESSION['tipoMensaje'] = $obtener;
                $_SESSION['mensaje'] = $usuario->getDescripcion();
                $this->controladorVista->cargarVista("principal", "error");
            }
        }
    }

}
