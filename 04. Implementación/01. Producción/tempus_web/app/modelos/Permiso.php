<?php

/**
 * Permite obtener operar con los registros de Permiso almacenados en la base 
 * de datos. 
 * Relacion con BD: PERMISO.
 * Campos: idpermiso, nombre.
 *
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
class Permiso {

    /** @var integer Identificador del permiso en la base de datos */
    private $idpermiso;

    /** @var string Nombre del permiso */
    private $nombre;

    /** @var string Descripcion para mostrar mensajes */
    private $descripcion;

    /** @var boolean Estado que indica la validez del rol */
    private $valido;

    /**
     * Constructor de la clase Permiso. Cuando se indica un identificador se 
     * busca la informacion en la base de datos y se actualizan los atributos,
     * siendo valido. Cuando no se obtiene un registro el permiso no sera valido. 
     * Al no indicar idpermiso, se crea un objeto vacio.
     * @param integer $idpermiso Identificador del permiso o null.
     */
    function __construct($idpermiso = null) {
        if ($idpermiso) {
            $consulta = "SELECT * FROM permiso WHERE idpermiso=" . $idpermiso;
            $rows = Conexion::getInstancia()->executeQuery($consulta);
            if (!empty($rows)) {
                $permiso = $rows[0];
                $this->idpermiso = $permiso['idpermiso'];
                $this->nombre = $permiso['nombre'];
                $this->valido = true;
            } else {
                $this->valido = false;
            }
        }
    }

    /**
     * Constructor alternativo de la clase Permiso. Permite establecer la 
     * informacion del y la validez del  mismo. Se debe utilizar cuando es 
     * necesario realizar INSERT o UPDATE a la base de datos.
     * @param string $nombre Nombre del permiso.
     * @param integer $idpermiso Identificador del permiso o null.
     */
    public function constructor($nombre, $idpermiso) {
        $this->valido = false;
        if ($this->validarFormatoNombre($nombre)) {
            $this->idpermiso = $idpermiso;
            $this->nombre = strtoupper($nombre);
            $this->valido = true;
        }
        return $this->valido;
    }

    /**
     * Devuelve el identificador de permiso.
     * @return integer $idpermiso
     */
    public function getIdpermiso() {
        return $this->idpermiso;
    }

    /**
     * Devuelve el nombre de permiso.
     * @return integer $nombre
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Devuelve la descripcion sobre el permiso.
     * @return string Descripcion sobre el estado u operacion.
     */
    public function getDescripcion() {
        return $this->descripcion;
    }

    /**
     * Devuelve el estado del permiso para saber su validez o resultado de 
     * operacion.
     * @return boolean Estado del permiso.
     */
    public function getEstado() {
        return $this->valido;
    }

    /**
     * Modifica el identificador de permiso.
     * @param integer $idpermiso
     */
    public function setIdpermiso($idpermiso) {
        $this->idpermiso = $idpermiso;
    }

    /**
     * Modifica el nombre de permiso.
     * @param integer $nombre
     */
    public function setNombre($nombre) {
        if ($this->validarFormatoNombre($nombre)) {
            $this->nombre = strtoupper($nombre);
        }
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
    public function borrar() {
        if ($this->idpermiso) {
            if (!$this->buscarRelacion()) {
                $eliminacion = Conexion::getInstancia()->executeDelete("permiso", "idpermiso={$this->idpermiso}");
                $this->descripcion = Conexion::getInstancia()->getDescripcion() . " del permiso";
                return $eliminacion;
            }
            $this->descripcion = "El permiso no se puede eliminar porque está asociado a un rol";
            return 1;
        }
        $this->descripcion = "El permiso no contiene toda la información";
        return 0;
    }

    /**
     * Realiza la busqueda de un permiso por su nombre solo si es valido. Se 
     * retorna un arreglo asociativo que solo es vacio en caso de no encontrar 
     * registros en la base de datos.
     * @return array() Arreglo asociativo de la tabla permiso.
     */
    private function buscar() {
        if ($this->nombre) {
            $consulta = "SELECT idpermiso FROM permiso WHERE nombre='" . $this->nombre . "'";
            $rows = Conexion::getInstancia()->executeQuery($consulta);
            $this->descripcion = empty($rows) ? "" : "Se encontró un permiso que coincide con el indicado";
            return $rows;
        }
        return null;
    }

    /**
     * Realiza la busqueda de todos los permisos guardados en la base de datos. 
     * Se retorna un arreglo asociativo que solo es vacio en caso de no encontrar 
     * registros en la base de datos. El arreglo es [idpermiso, nombre, roles].
     * @return array() Arreglo asociativo de la tabla permiso.
     */
    public function buscarPermisos() {
        $consulta = "SELECT * FROM permiso ORDER BY nombre";
        $rows = Conexion::getInstancia()->executeQuery($consulta);
        return $rows;
    }

    public function buscarRelacion() {
        $consulta = "SELECT * FROM rol_permiso WHERE idpermiso=" . $this->idpermiso;
        return Conexion::getInstancia()->executeQueryBoolean($consulta);
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
    public function crear() {
        $rows = $this->buscar();
        if (!empty($rows)) {
            $this->idasignatura = $rows[0]['idpermiso'];
            return 3;
        }
        if (!is_null($rows)) {
            $values = "(NULL, '$this->nombre')";
            $creacion = Conexion::getInstancia()->executeInsert("permiso", $values);
            $this->idpermiso = ($creacion == 2) ? (Int) Conexion::getInstancia()->insert_id : NULL;
            $this->descripcion = Conexion::getInstancia()->getDescripcion() . " del permiso";
            return $creacion;
        }
        return 0;
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
    public function modificar() {
        $rows = $this->buscar();
        if (!empty($rows)) {
            return 3;
        }
        if (!is_null($rows)) {
            if ($this->idpermiso && $this->nombre) {
                $set = "nombre='{$this->nombre}'";
                $where = "idpermiso={$this->idpermiso}";
                $modificacion = Conexion::getInstancia()->executeUpdate("permiso", $set, $where);
                $this->descripcion = Conexion::getInstancia()->getDescripcion() . " del permiso";
                return $modificacion;
            }
            $this->descripcion = "El permiso no contiene toda la información";
            return 0;
        }
        $this->descripcion = "No pudo realizar la búsqueda de permiso";
        return 0;
    }

    /**
     * Controla el formato del nombre de un rol. El nombre de rol tiene un rango
     * de 5 a 30 caracteres. Ademas, puede contener espacio en blanco y letras 
     * con acento.
     * @param string $nombre Nombre del rol a validar.
     */
    private function validarFormatoNombre($nombre) {
        $expresion = "/^[A-Z ]{5,30}$/";
        if (preg_match($expresion, $nombre)) {
            return true;
        }
        $this->descripcion = "El nombre del permiso no cumple con el formato";
        return false;
    }

}
