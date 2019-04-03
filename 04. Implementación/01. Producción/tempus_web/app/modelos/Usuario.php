<?php

/**
 * Permite obtener operar con los registros de Usuario almacenados en la base 
 * de datos. 
 * Relacion con BD: USUARIO.
 * Campos: idusuario, email, nombre, metodo, estado.
 *
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
class Usuario {

    /** @var integer Identificador del usuario en la base de datos */
    private $idusuario;

    /** @var string Correo electronico del usuario */
    private $email;

    /** @var string Nombre del usuario */
    private $nombre;

    /** @var string Metodo de acceso al sistema (Manual o Google) */
    private $metodo;

    /** @var string Estado del usuario (Activo o Inactivo) */
    private $estado;

    /** @var Rol Rol que posee el usuario dentro del sistema */
    private $rol;

    /** @var string Descripcion para mostrar mensajes */
    public $descripcion;

    /** @var boolean Estado que indica la validez del usuario */
    public $valido;

    /**
     * Constructor de la clase Usuario. Cuando se indica un identificador se 
     * busca la informacion en la base de datos y se actualizan los atributos,
     * siendo valido. Cuando no se obtiene un registro el rol no sera valido. 
     * Al no indicar idrol, se crea un objeto vacio.
     * @param integer $idusuario Identificador del usuario o null.
     */
    function __construct($idusuario = null) {
        $this->valido = false;
        if ($idusuario) {
            $consulta = "SELECT u.idusuario, u.email, u.nombre, u.metodologin, u.estado, r.idrol, r.nombre rol 
                        FROM usuario u, usuario_rol ur, rol r
                        WHERE u.idusuario = ur.idusuario AND r.idrol = ur.idrol AND u.idusuario=$idusuario";
            $rows = Conexion::getInstancia()->executeQuery($consulta);
            if (!empty($rows)) {
                $usuario = $rows[0];
                $rol = new Rol();
                $rol->cargar($usuario['rol'], $usuario['idrol']);
                $this->cargar($usuario['idusuario'], $usuario['email'], $usuario['nombre'], $rol, $usuario['metodologin'], $usuario['estado']);
            }
        }
    }

    public function constructor($email, $nombre, $rol, $metodo = "Google", $estado = "Activo", $idusuario = null) {
        $this->valido = true;
        if ($this->setNombre($nombre) && $this->setMetodo($metodo) && $this->setRol($rol)) {
            $this->idusuario = $idusuario;
            $this->email = $email;
            $this->estado = $estado;
            $this->valido = true;
        }
        return $this->valido;
    }

    public function cargar($idusuario, $email, $nombre, $rol, $metodo, $estado) {
        $this->idusuario = $idusuario;
        $this->email = $email;
        $this->nombre = $nombre;
        $this->rol = $rol;
        $this->metodo = $metodo;
        $this->estado = $estado;
        $this->valido = true;
    }

    /**
     * Devuelve el identificador del usuario.
     * @return integer Identificador del usuario en la base de datos.
     */
    public function getIdusuario() {
        return $this->idusuario;
    }

    /**
     * Devuelve correo electronico del usuario.
     * @return string Correo electronico.
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Devuelve el nombre del usuario.
     * @return string Nombre del usuario.
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Devuelve el metodo de acceso del usuario.
     * @return string Metodo de acceso (Manual o Google).
     */
    public function getMetodo() {
        return $this->metodo;
    }

    /**
     * Devuelve el estado del usuario.
     * @return string Estado del usuario (Activo o Inactivo).
     */
    public function getEstado() {
        return $this->estado;
    }

    /**
     * Devuelve el rol del usuario.
     * @return Rol Rol de usuario.
     */
    public function getRol() {
        return $this->rol;
    }

    /**
     * Devuelve la descripcion sobre el usuario.
     * @return string Descripcion sobre el estado u operacion.
     */
    public function getDescripcion() {
        return $this->descripcion;
    }

    /**
     * Indica la validez del usuario.
     * @return boolean Validez del usuario.
     */
    public function getValido() {
        return $this->estado;
    }

    /**
     * Modifica el identificador del usuario.
     * @param integer $idusuario Identificador del usuario.
     */
    public function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
    }

    /**
     * Modifica el correo electronico del usuario.
     * @param string $email Correo electronico del usuario.
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * Modifica el nombre del usuario.
     * @param string $nombre Nombre del usuario.
     */
    public function setNombre($nombre) {
        if ($this->validarNombre($nombre)) {
            $this->nombre = $nombre;
            return true;
        }
        return false;
    }

    public function setMetodo($metodo) {
        if ($this->validarMetodo($metodo)) {
            $this->metodo = $metodo;
            return true;
        }
        return false;
    }

    /**
     * Modifica el estado del usuario.
     * @param string $estado Estado del usuario.
     */
    public function setEstado($estado) {
        $this->estado = $estado;
    }

    /**
     * Modifica el rol del usuario.
     * @param Rol $rol Rol del usuario.
     */
    public function setRol($rol) {
        if ($this->validarRol($rol)) {
            $this->rol = $rol;
            return true;
        }
        return false;
    }

    public function borrar() {
        if ($this->idusuario) {
            $where = "idusuario=" . $this->idusuario;
            $borrar = Conexion::getInstancia()->executeDelete("usuario", $where);
            if($borrar == 2) {
                return $this->borrarRelacionConRol();
            }
            $this->descripcion = Conexion::getInstancia()->getDescripcion . " de usuario";
            return $borrar;
        }
        $this->descripcion = "El usuario no contiene toda la información";
        return 0;
    }

    private function borrarRelacionConRol() {
        $where = "idusuario=" . $this->idusuario;
        $borrar = Conexion::getInstancia()->executeDelete("usuario_rol", $where);
        $this->descripcion = Conexion::getInstancia()->getDescripcion . " de usuario";
        return $borrar;
    }

    public function buscar() {
        if ($this->email && $this->metodo) {
            $consulta = "SELECT u.idusuario, u.email, u.nombre, u.metodologin, u.estado, r.idrol, r.nombre rol 
                        FROM usuario u, usuario_rol ur, rol r 
                        WHERE u.idusuario = ur.idusuario AND r.idrol = ur.idrol AND 
                        u.email = '$this->email' AND u.metodologin = '$this->metodo'";
            $rows = Conexion::getInstancia()->executeQuery($consulta);
            $this->descripcion = (empty($rows)) ? "" : "Se encontró un usuario que coincide con el indicado";
            return $rows;
        }
        $this->descripcion = "El usuario no contiene toda la información";
        return NULL;
    }

    public function crear() {
        $rows = $this->buscar();
        if (!empty($rows)) {
            $this->idusuario = $rows[0]['idusuario'];
            return 3;
        }
        if (!is_null($rows)) {
            $values = "(null,'$this->email','$this->nombre','$this->metodo','Activo')";
            $creacion = Conexion::getInstancia()->executeInsert("usuario", $values);
            if ($creacion == 2) {
                $this->idusuario = (Int) Conexion::getInstancia()->insert_id;
                return $this->crearRelacionConRol();
            }
            $this->descripcion = Conexion::getInstancia()->getDescripcion() . " del usuario";
            return $creacion;
        }
        $this->descripcion = "No se pudo realizar la búsqueda de usuario";
        return 0;
    }

    private function crearRelacionConRol() {
        if ($this->rol) {
            $values = "($this->idusuario , {$this->rol->getIdrol()})";
            $creacion = Conexion::getInstancia()->executeInsert("usuario_rol", $values);
            $this->descripcion = Conexion::getInstancia()->getDescripcion() . " del usuario";
            return $creacion;
        }
        $this->descripcion = "El usuario no contiene la información de rol";
        return 0;
    }

    public function modificar() {
        if ($this->idusuario && $this->nombre && $this->metodo && $this->estado) {
            $this->descripcion = "No se realizó la modificación del usuario";
            $consulta = "UPDATE usuario "
                    . "SET nombre='" . $this->nombre . "', metodo='$this->metodo', estado = '$this->estado'"
                    . "WHERE idusuario=" . $this->idusuario;
            if (Conexion::getInstancia()->executeUpdate($consulta)) {
                $this->descripcion = "Se realizó la modificación del usuario";
                return true;
            }
            return false;
        }
        $this->descripcion = "El usuario no contiene toda la información";
        return false;
    }

    public function modificarRelacionConRol() {
        
    }

    private function validarMetodo($metodo) {
        $this->descripcion = "El método de login no es válido";
        return ($metodo == "Manual" || $metodo = "Google") ? true : false;
    }

    private function validarNombre($nombre) {
        $expresion = "/^[A-Za-zÑñ ]{5,30}$/";
        $this->descripcion = "El nombre del usuario no cumple con el formato";
        return preg_match($expresion, $nombre) ? true : false;
    }

    private function validarRol($rol) {
        return ($rol && $rol->getIdrol()) ? true : false;
    }

}
