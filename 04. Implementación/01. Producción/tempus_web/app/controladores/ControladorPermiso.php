<?php

/**
 * Este controlador permite realizar las operaciones que corresponden a los 
 * permisos. Funciona como un intermediario entre las vistas y los modelos. Se
 * encarga de relacionar la operacion que se desea realizar con el objeto que 
 * debe llevarla a cabo. Recibe el resultado de una operacion y la devuelve a 
 * traves de una descripcion asociada.
 *
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
class ControladorPermiso {

    /** @var Permiso Permiso con el cual se va a trabajar */
    private $permiso;

    /**
     * Constructor del controlador. Se encarga de crear un nuevo objeto de 
     * Permiso para realizar las operaciones.
     */
    function __construct() {
        $this->permiso = new Permiso();
    }

    /**
     * Realiza la eliminacion de un permiso solo si contiene el idpermiso. El 
     * metodo retorna un numero del 0 al 3 que indica el resultado de la 
     * operacion de eliminacion. En todos los casos, se obtiene una descripcion 
     * que indica un mensaje a mostrar.
     * 0 si no contiene idpermiso.
     * 1 si no se realiza la eliminacion del permiso.
     * 2 si se realiza la eliminacion del permiso.
     * @return integer Numero que indica resultado (0, 1 o 2).
     */
    public function borrar($idpermiso) {
        $this->permiso->setIdpermiso($idpermiso);
        return $this->permiso->borrar();
    }

    /**
     * Realiza la busqueda de todos los permisos guardados en la base de datos. 
     * Se retorna un arreglo asociativo que solo es vacio en caso de no encontrar 
     * registros en la base de datos. El arreglo es [idpermiso, nombre].
     * @return array() Arreglo asociativo de la tabla permiso.
     */
    public function buscarPermisos() {
        return $this->permiso->buscarPermisos();
    }

    /**
     * Realiza la creacion de un permiso solo si tiene nombre. El metodo retorna
     * un numero que indica el resultado de la operacion de creacion. En todos 
     * los casos, se obtiene una descripcion que indica un mensaje.
     * 0 si la busqueda falla.
     * 1 si la asignatura no se crea.
     * 2 si se realiza la creacion del permiso.
     * 3 si se encuentran coincidencias en la base de datos.
     * @return integer Numero que indica resultado (0, 1, 2 o 3).
     */
    public function crear($nombre) {
        $this->permiso->setNombre($nombre);
        return $this->permiso->crear();
    }

    /**
     * Devuelve la descripcion sobre el permiso utilizado en el controlador.
     * @return string Descripcion sobre el estado u operacion.
     */
    public function getDescripcion() {
        return $this->permiso->getDescripcion();
    }

     /**
     * Realiza la modificacion de un permiso solo si contiene el idpermiso y 
     * nombre. El metodo retorna un numero del 0 al 3 que indica el resultado de 
     * la operacion de modificacion. En todos los casos, se obtiene una 
     * descripcion que indica un mensaje a mostrar.
     * 0 si no contiene idpermiso o nombre.
     * 1 si no se realiza la modificacion del permiso.
     * 2 si se realiza la modificacion del permiso.
     * @return integer Numero que indica resultado (0, 1 o 2).
     */
    public function modificar($idpermiso, $nombre) {
        if ($this->permiso->constructor($nombre, $idpermiso)) {
            return $this->permiso->modificar();
        }
        return 0;
    }

}
