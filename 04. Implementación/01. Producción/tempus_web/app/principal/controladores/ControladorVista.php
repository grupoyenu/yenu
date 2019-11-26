<?php

class ControladorVista {

    private $vistas;

    public function __construct() {
        $this->vistas = array("home" => "home_principal",
            "cerrarSesion" => "cerrarSesion_principal",
            "FormBuscarAula" => "buscar_aulas",
            "FormCrearAula" => "crear_aulas",
            "FormInformeAula" => "informe_aulas",
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
        if ($this->evaluarPermiso($modulo)) {
            $nombreVista = $vista . "_" . $modulo;
            $archivo = array_search($nombreVista, $this->vistas);
            if ($archivo) {
                $this->cargarVista($modulo, $archivo);
            } else {
                Log::escribirLineaError("[Evaluar vista: No se encontró la página indicada]");
                $_SESSION['tipoMensaje'] = 1;
                $_SESSION['mensaje'] = "No se encontró la página indicada";
                $this->cargarVista("principal", "error");
            }
        } else {
            Log::escribirLineaError("[Evaluar vista: No posee permisos para acceder a la página ingresada]");
            $_SESSION['tipoMensaje'] = 0;
            $_SESSION['mensaje'] = "No posee permisos para acceder a la página ingresada";
            $this->cargarVista("principal", "error");
        }
    }

    private function evaluarPermiso($modulo) {
        switch ($modulo) {
            case "asignaturas":
                $modulo = "PLANES";
                break;
            case "carreras":
                $modulo = "PLANES";
                break;
            default:
                $modulo = strtoupper($modulo);
                break;
        }
        $usuario = unserialize($_SESSION['user']);
        $rol = $usuario->getRol();
        $permisosUsuario = $rol->getPermisos();
        $nombres = array_column($permisosUsuario, 'nombre');
        return ((array_search($modulo, $nombres) !== false) || ($modulo == "PRINCIPAL")) ? true : false;
    }

    public function cargarVista($modulo, $vista) {
        require_once ("app/principal/modelos/Constantes.php");
        require_once ("app/principal/vistas/header.php");
        require_once ("app/{$modulo}/vistas/{$vista}.php");
        require_once ("app/principal/vistas/footer.php");
    }

}
