<?php

/**
 * Permite obtener operar con los registros de Rol almacenados en la base 
 * de datos. 
 * Relacion con BD: ROL.
 * Campos: idrol, nombre.
 *
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
class Rol {

    /** @var integer Identificador del rol en la base de datos */
    private $idrol;

    /** @var string Nombre del rol */
    private $nombre;

    /** @var array() Permisos asociados al rol */
    private $permisos;

    /** @var string Descripcion para mostrar mensajes */
    private $descripcion;

    /** @var boolean Estado que indica la validez del rol */
    private $valido;

    /**
     * Constructor de la clase Rol. Cuando se indica un identificador se 
     * busca la informacion en la base de datos y se actualizan los atributos,
     * siendo valido. Cuando no se obtiene un registro el rol no sera valido. 
     * Al no indicar idrol, se crea un objeto vacio.
     * @param integer $idrol Identificador del rol o null.
     */
    function __construct($idrol = null) {
        $this->valido = false;
        if ($idrol) {
            $consulta = "SELECT r.idrol, r.nombre FROM rol r, rol_permiso rp 
                         WHERE r.idrol = rp.idrol AND r.idrol = $idrol GROUP BY r.idrol";
            $rows = Conexion::getInstancia()->executeQuery($consulta);
            if (!empty($rows)) {
                $rol = $rows[0];
                $this->idrol = $rol['idrol'];
                $this->nombre = $rol['nombre'];
                $this->permisos = $this->buscarPermisos();
                $this->valido = true;
            }
        }
    }

    /**
     * Constructor alternativo de la clase Rol. Permite establecer la informacion 
     * del y la validez del  mismo. Se debe utilizar cuando es necesario realizar 
     * INSERT o UPDATE a la base de datos.
     * @param string $nombre Nombre del rol.
     * @param integer $idrol Identificador del rol o null.
     * @return boolean Retorna true si es valido o false en caso contrario.
     */
    public function constructor($nombre, $idrol = null, $permisos = null) {
        $this->valido = false;
        if ($this->setNombre($nombre)) {
            $this->idrol = $idrol;
            $this->permisos = $permisos;
            $this->valido = true;
        }
        return $this->valido;
    }

    /**
     * Devuelve el identificador del rol.
     * @return integer $idrol
     */
    public function getIdrol() {
        return $this->idrol;
    }

    /**
     * Devuelve el nombre del rol.
     * @return string Devuelve el nombre del rol
     */
    public function getNombre() {
        return $this->nombre;
    }

    public function getPermisos() {
        return $this->permisos;
    }

    /**
     * Devuelve la descripcion sobre el rol.
     * @return string Descripcion sobre el estado u operacion.
     */
    public function getDescripcion() {
        return $this->descripcion;
    }

    /**
     * Devuelve el estado del rol para saber su validez o resultado de operacion.
     * @return boolean Estado del rol.
     */
    public function getEstado() {
        return $this->valido;
    }

    /**
     * Devuelve la cantidad de permisos que el rol tiene asociados.
     * @return integet Numero de permisos asociados.
     */
    public function getNumeroPermisos() {
        return $this->numeroPermisos;
    }

    /**
     * Modifica el identificador del rol.
     * @param integer $idrol
     */
    public function setIdrol($idrol) {
        $this->idrol = $idrol;
    }

    /**
     * Modifica el nombre del rol. Antes de aplicar el cambio realiza el control
     * del formato del nombre. En caso de no cumplirlo el estado del rol no sera
     * valido.
     * @param string $nombre Nombre del rol.
     */
    public function setNombre($nombre) {
        if ($this->validarFormatoNombre($nombre)) {
            $this->nombre = Utilidades::convertirCamelCase($nombre);
            return true;
        }
        return false;
    }

    public function setPermisos($permisos) {
        $this->permisos = $permisos;
    }

    public function agregarPermisos() {
        if (!is_null($this->permisos) && !empty($this->permisos) && $this->idrol) {
            $values = "";
            foreach ($this->permisos as $permiso) {
                $values = $values . " ($this->idrol, $permiso),";
            }
            $values =  substr($values, 0, -1);
            if (Conexion::getInstancia()->executeInsert("rol_permiso", $values)) {
                return 2;
            }
            $this->descripcion = Conexion::getInstancia()->getDescripcion()." de los permisos";
            return 1;
        }
        $this->descripcion = "El rol no contiene toda la información";
        return 0;
    }

    /**
     * Realiza la eliminacion de un rol solo si contiene el idrol. El metodo 
     * retorna un numero del 0 al 3 que indica el resultado de la operacion de 
     * eliminacion. En todos los casos, se obtiene una descripcion que indica un 
     * mensaje a mostrar.
     * 0 si no contiene idpermiso.
     * 1 si no se realiza la eliminacion del permiso.
     * 2 si se realiza la eliminacion del permiso.
     * @return integer Numero que indica resultado (0, 1 o 2).
     */
    public function borrar() {
        if ($this->idrol) {
            if ($this->buscarRelacionUsuario()) {
                $this->descripcion = "El rol no se puede eliminar porque está asociado a un usuario";
                return 1;
            }
            if($this->borrarRelacion() != 2) {
                return 1;
            }
            $eliminacion = Conexion::getInstancia()->executeDelete("rol", "idrol={$this->idrol}");
            $this->descripcion = Conexion::getInstancia()->getDescripcion() . " del rol";
            return $eliminacion;
        }
        $this->descripcion = "El rol no contiene toda la información";
        return 0;
    }

    public function borrarRelacion() {
        $eliminacion = Conexion::getInstancia()->executeDelete("rol_permiso", "idrol={$this->idrol}");
        $this->descripcion = Conexion::getInstancia()->getDescripcion() . " del rol";
        return $eliminacion;
    }

    /**
     * Realiza la busqueda de un rol por su nombre solo si es valido. Se retorna
     * un arreglo asociativo que solo es vacio en caso de no encontrar registros
     * en la base de datos.
     * @return array() Arreglo asociativo de la tabla rol.
     */
    public function buscar() {
        if ($this->nombre) {
            $consulta = "SELECT r.idrol, r.nombre, count(rp.idpermiso) permisos
                        FROM rol r, rol_permiso rp 
                        WHERE r.idrol = rp.idrol AND r.nombre ='$this->nombre'
                        GROUP BY r.idrol";
            $rows = Conexion::getInstancia()->executeQuery($consulta);
            return $rows;
        }
        $this->descripcion = "El rol no contiene toda la información";
        return null;
    }

    public function buscarRoles() {
        $consulta = "SELECT r.idrol, r.nombre, count(rp.idpermiso) permisos 
                    FROM rol r, rol_permiso rp  
                    WHERE r.idrol = rp.idrol GROUP BY r.idrol";
        $rows = Conexion::getInstancia()->executeQuery($consulta);
        return $rows;
    }

    /**
     * Realiza la busqueda de los permisos de un rol por su idrol solo si es 
     * valido. Se retorna un arreglo asociativo que solo es vacio en caso de no 
     * encontrar registros en la base de datos.
     * @return array() Arreglo asociativo de la tabla permiso.
     */
    public function buscarPermisos() {
        if ($this->idrol) {
            $consulta = "SELECT p.idpermiso, p.nombre FROM rol_permiso rp, permiso p 
                        WHERE rp.idpermiso = p.idpermiso AND rp.idrol = $this->idrol ";
            $rows = Conexion::getInstancia()->executeQuery($consulta);
            return $rows;
        }
        $this->descripcion = "El rol no contiene toda la información";
        return null;
    }
    
    private function buscarRelacionUsuario() {
        $consulta = "SELECT * FROM usuario_rol WHERE idrol=".$this->idrol;
        return Conexion::getInstancia()->executeQueryBoolean($consulta);
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
    public function crear() {
        $rows = $this->buscar();
        if (!empty($rows)) {
            $this->descripcion = "Se encontró una rol que coincide con el ingresado";
            $this->idrol = $rows[0]['idrol'];
            return 3;
        }
        if (!is_null($rows)) {
            $values = "(NULL, '$this->nombre')";
            $creacion = Conexion::getInstancia()->executeInsert("rol", $values);
            $this->idrol = ($creacion == 2) ? (Int) Conexion::getInstancia()->insert_id : NULL;
            $this->descripcion = Conexion::getInstancia()->getDescripcion() . " del rol";
            return $this->agregarPermisos();
        }
        return 0;
    }

    /**
     * Realiza la modificacion de un rol solo si contiene el idrol y nombre. El 
     * metodo retorna un numero del 0 al 3 que indica el resultado de la 
     * operacion de modificacion. En todos los casos, se obtiene una descripcion 
     * que indica un mensaje a mostrar.
     * 0 si no contiene idrol o nombre.
     * 1 si no se realiza la modificacion del rol.
     * 2 si se realiza la modificacion del rol.
     * @return integer Numero que indica resultado (0, 1 o 2).
     */
    public function modificar() {
        if ($this->nombre && $this->idrol) {
            $consulta = "UPDATE rol SET nombre='" . $this->nombre . "' WHERE idrol=" . $this->idrol;
            if (Conexion::getInstancia()->executeUpdate($consulta)) {
                $this->descripcion = "Se realizó la modificación del rol";
                return 2;
            }
            $this->descripcion = "No se realizó la modificación del rol";
            return 1;
        }
        $this->descripcion = "El rol no contiene toda la información";
        return 0;
    }

    /**
     * Controla el formato del nombre de un rol. El nombre de rol tiene un rango
     * de 5 a 30 caracteres. Ademas, puede contener espacio en blanco y letras 
     * con acento.
     * @param string $nombre Nombre del rol a validar.
     */
    private function validarFormatoNombre($nombre) {
        $expresion = "/^[A-Za-zÑñ ]{5,30}$/";
        $this->descripcion = "El nombre del rol no cumple con el formato";
        return preg_match($expresion, $nombre) ? true : false;
    }

}
