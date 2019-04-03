<?php

/**
 * Permite llevar el control del sistema. Controla el flujo de los eventos y la
 * comunicacion entre las partes del sistema. Se encarga de inicializar la 
 * sesion y redireccionar segun corresponda. Hace uso de la variable ruta para 
 * establecer a que pagina se desea acceder.
 *
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
class ControladorPrincipal {

    /** @var string Ruta a manejar. */
    public $ruta;

    /**
     * Constructor del Controlador Principal.
     * @param string $ruta Ruta a la que se quiere acceder.
     */
    function __construct($ruta) {
        if (!isset($_SESSION)) {
            /* INICIA LA SESION Y COLOCA EL ESTADO DE AUTENTICACION EN FALSO */
            session_start();
        }
        if (!isset($_SESSION['ok'])) {
            $_SESSION['ok'] = false;
        }

        if ($_SESSION['ok']) {

            $this->ruta = isset($_GET['ruta']) ? $_GET['ruta'] : 'home';
            $controlador = new ControladorVista();

            switch ($this->ruta) {
                case 'home':
                    $controlador->cargarVista('home');
                    break;
                case 'cursada_buscar':
                    $controlador->cargarVista('FormBuscarCursada');
                    break;
                case 'cursada_crear':
                    $controlador->cargarVista('FormCrearCursada');
                    break;
                case 'cursada_seleccionar':
                    $controlador->cargarVista('FormSeleccionarCursada');
                    break;
                case 'cursada_importar':
                    $controlador->cargarVista('FormImportarCursada');
                    break;
                case 'cursada_informe':
                    $controlador->cargarVista('FormInformeCursada');
                    break;
                case 'mesa_buscar':
                    $controlador->cargarVista('FormBuscarMesa');
                    break;
                case 'mesa_crear':
                    $controlador->cargarVista('FormCrearMesa');
                    break;
                case 'mesa_seleccionar':
                    $controlador->cargarVista('FormSeleccionarMesa');
                    break;
                case 'mesa_importar':
                    $controlador->cargarVista('FormImportarMesa');
                    break;
                case 'mesa_informe':
                    $controlador->cargarVista('FormInformeMesa');
                    break;
                case 'plan_crear':
                    $controlador->cargarVista('FormCrearPlan');
                    break;
                case 'asignatura_buscar':
                    $controlador->cargarVista('FormBuscarAsignatura');
                    break;
                case 'carrera_buscar':
                    $controlador->cargarVista('FormBuscarCarrera');
                    break;
                case 'aula_buscar':
                    $controlador->cargarVista('FormBuscarAula');
                    break;
                case 'aula_crear':
                    $controlador->cargarVista('FormCrearAula');
                    break;
                case 'usuario_buscar':
                    $controlador->cargarVista('FormBuscarUsuario');
                    break;
                case 'usuario_crear':
                    $controlador->cargarVista('FormCrearUsuario');
                    break;
                case 'rol_crear':
                    $controlador->cargarVista('FormCrearRol');
                    break;
                case 'rol_buscar':
                    $controlador->cargarVista('FormBuscarRol');
                    break;
                case 'permiso_buscar':
                    $controlador->cargarVista('FormBuscarPermiso');
                    break;
                case 'permiso_crear':
                    $controlador->cargarVista('FormCrearPermiso');
                    break;
                case 'salir':
                    break;
                default:
                    $controlador->cargarVista('error');
                    break;
            }
        } else {
            if (isset($_POST['email'])) {
                $this->login($_POST['email']);
            } else {
                $controlador = new ControladorVista();
                $controlador->cargarVista('ingreso');
            }
        }
    }
    
    /** 
     * Realiza la busqueda del usuario a partir del email ingresado. Si se encuentra
     * se actualiza el index. En caso contrario lo redirecciona al ingreso.
     * @param string $email Correo electronico con el que se ingresa.
     */
    private function login($email) {
        $usuario = new UsuarioGoogle();
        $usuario->setEmail($email);
        if ($usuario->buscar()) {
            $_SESSION['ok'] = true;
            $_SESSION['user'] = $usuario;
            header("Location: ./");
        } else {
            $controlador = new ControladorVista();
            $controlador->cargarVista('ingreso');
        }
    }

}
