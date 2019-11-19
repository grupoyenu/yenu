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
                $this->login($_POST['email']);
            } else {
                $this->controladorVista->cargarVista("principal", "ingreso");
            }
        }
    }

    private function acceder($ruta) {
        if ($ruta) {
            $particion = explode("_", $ruta);
            $modulo = $particion[0];
            $vista = $particion[1];
            $this->evaluarModulo($modulo, $vista);
        } else {
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
            $this->controladorVista->cargarVista("principal", "error");
        }
    }

    private function login($email) {
        $usuario = new UsuarioGoogle();
        $usuario->setEmail($email);
        $obtener = $usuario->login();
        if ($obtener == 2) {
            $_SESSION['ok'] = true;
            $_SESSION['user'] = serialize($usuario);
            Log::escribirLineaError("[Login: inicio de sesion ({$email})]");
            $this->controladorVista->cargarVista("principal", "home");
        } else {
            Log::escribirLineaError("[Login: {$usuario->getDescripcion()} ({$email})]");
            $_SESSION['tipoMensaje'] = $obtener;
            $_SESSION['mensaje'] = $usuario->getDescripcion();
            $_POST = array();
            $this->controladorVista->cargarVista("principal", "error");
        }
    }

}
