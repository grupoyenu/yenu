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

}
