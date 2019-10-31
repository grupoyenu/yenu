<?php

class ControladorVista {

    private $vistas;

    public function __construct() {
        $this->vistas = array("home" => "home_principal",
            "FormBuscarAula" => "buscar_aulas",
            "FormCrearAula" => "crear_aulas",
            "FormBuscarCursada" => "buscar_cursadas",
            "FormCrearCursada" => "crear_cursadas",
            "FormSeleccionarCursada" => "seleccionar_cursadas",
            "FormImportarCursada" => "importar_cursadas",
            "FormInformeCursada" => "informe_cursadas",
            "FormBuscarMesa" => "buscar_mesas",
            "FormCrearMesa" => "crear_mesas",
            "FormSeleccionarMesa" => "seleccionar_mesas",
            "FormImportarMesa" => "importar_mesas",
            "FormInformeMesa" => "informe_mesas",
            "FormBuscarCarrera" => "buscar_carreras",
            "FormAgregarAsignatura" => "agregar_carreras",
            "FormBuscarAsignatura" => "buscar_asignaturas",
            "FormCrearPlan" => "crear_planes",
            "FormBuscarUsuario" => "buscarUsuario_usuarios",
            "FormBuscarRol" => "buscarRol_usuarios",
            "FormBuscarPermiso" => "buscarPermiso_usuarios",
            "FormCrearPermiso" => "crearPermiso_usuarios",
            "FormCrearRol" => "crearRol_usuarios",
            "FormCrearUsuario" => "crearUsuario_usuarios");
    }

    public function evaluarVista($modulo, $vista) {
        $nombreVista = $vista . "_" . $modulo;
        $archivo = array_search($nombreVista, $this->vistas);
        if ($archivo) {
            $this->cargarVista($modulo, $archivo);
        } else {
            $this->cargarVista("principal", "error");
        }
    }

    public function cargarVista($modulo, $vista) {
        require_once ("app/principal/modelos/Constantes.php");
        require_once ("app/principal/vistas/header.php");
        require_once ("app/{$modulo}/vistas/{$vista}.php");
        require_once ("app/principal/vistas/footer.php");
    }

}
