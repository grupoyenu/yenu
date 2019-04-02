<?php

/**
 * Este controlador permite realizar las operaciones que corresponden a los 
 * roles. Funciona como un intermediario entre las vistas y los modelos. Se
 * encarga de relacionar la operacion que se desea realizar con el objeto que 
 * debe llevarla a cabo. Recibe el resultado de una operacion y la devuelve a 
 * traves de una descripcion asociada.
 *
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
class ControladorRol {

    /** @var Rol Rol con el que se va a trabajar */
    private $rol;

    function __construct() {
        $this->rol = new Rol();
    }

    function getDescripcion() {
        return $this->rol->getDescripcion();
    }

    public function borrar($idrol) {
        Conexion::getInstancia()->setAutocommit(false);
        $this->rol->setIdrol($idrol);
        $eliminacion = $this->rol->borrar($idrol);
        $this->transaccion($eliminacion);
        Conexion::getInstancia()->setAutocommit(true);
        return $eliminacion;
    }

    /**
     * Realiza la busqueda de un rol determinado.
     */
    public function buscarRol($nombre) {
        $this->rol->setNombre($nombre);
        return $this->rol->buscar();
    }

    /**
     * Realiza la busqueda de los roles almacaenados en la base de datos.
     */
    public function buscarRoles() {
        return $this->rol->buscarRoles();
    }

    /**
     * Realiza la creacion de un rol solo si no existe ya. El metodo retorna
     * un numero que indica el resultado de la operacion de creacion. En todos 
     * los casos, se obtiene una descripcion que indica un mensaje.
     * 0 si la busqueda falla.
     * 1 si el rol no se crea.
     * 2 si se realiza la creacion del rol.
     * 3 si se encuentran coincidencias en la base de datos.
     * @return integer Numero que indica resultado (0, 1, 2 o 3).
     */
    public function crear($nombre, $permisos) {
        Conexion::getInstancia()->setAutocommit(false);
        $this->rol->constructor($nombre, null, $permisos);
        $creacion = $this->rol->crear();
        $this->transaccion($creacion);
        Conexion::getInstancia()->setAutocommit(true);
        return $creacion;
    }

    /**
     * 
     */
    public function modificar($idrol, $nombre, $permisos) {
        Conexion::getInstancia()->setAutocommit(false);
        
        Conexion::getInstancia()->setAutocommit(true);
    }

    private function transaccion($resultado) {
        switch ($resultado) {
            case 1:
                Conexion::getInstancia()->executeRollback();
                break;
            case 2:
                Conexion::getInstancia()->executeCommit();
                break;
            default:
                Conexion::getInstancia()->executeRollback();
                break;
        }
    }

}
