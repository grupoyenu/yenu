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
                $this->idusuario = $usuario['idusuario'];
                $this->email = $usuario['email'];
                $this->nombre = $usuario['nombre'];
                $this->metodo = $usuario['metodologin'];
                $this->estado = $usuario['estado'];
                $rol = new Rol();
                $rol->constructor($usuario['rol'], $usuario['idrol']);
                $this->rol = $rol;
                $this->valido = true;
            }
        }
    }

    public function constructor($email, $nombre, $rol, $metodo = "Google", $estado = "Activo", $idusuario = null) {
        $this->idusuario = $idusuario;
        $this->email = $email;
        $this->nombre = $nombre;
        $this->rol = $rol;
        $this->metodo = $metodo;
        $this->estado = $estado;
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
        return $this->valido;
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
        $this->nombre = $nombre;
    }

    public function setMetodo($metodo) {
        if ($this->validarMetodo($metodo)) {
            $this->metodo = $metodo;
        }
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
        $this->rol = $rol;
    }

    public function borrar() {
        if ($this->idusuario) {
            $this->descripcion = "No se realizó la eliminación del usuario";
            $consulta = "DELETE FROM usuario WHERE idusuario=" . $this->idusuario;
            $this->valido = Conexion::getInstancia()->executeUpdate($consulta);
            if ($this->valido) {
                $this->descripcion = "Se realizó la eliminación del usuario";
            }
            return $this->valido;
        }
        $this->descripcion = "El usuario no contiene toda la información";
        return false;
    }

    public function buscar() {
        if ($this->email && $this->metodo) {
            $consulta = "SELECT u.idusuario, u.email, u.nombre, u.metodologin, u.estado, r.idrol, r.nombre rol 
                        FROM usuario u, usuario_rol ur, rol r 
                        WHERE u.idusuario = ur.idusuario AND r.idrol = ur.idrol AND 
                        u.email = '$this->email' AND u.metodologin = '$this->metodo'";
            $rows = Conexion::getInstancia()->executeQuery($consulta);
            return $rows;
        }
        $this->descripcion = "El usuario no contiene toda la información";
        return null;
    }
    
    
    private function creacion() {
        if (!$this->rol || !$this->rol->getIdrol()) {
            return false;
        }
        Conexion::getInstancia()->setAutocommit(false);
        $consulta = "INSERT INTO usuario VALUES (null,'$this->email','$this->nombre','$this->metodo','Activo')";
        echo $consulta;
        if (Conexion::getInstancia()->executeUpdate($consulta)) {
            $this->idusuario = (Int) Conexion::getInstancia()->insert_id;
            $consulta = "INSERT INTO usuario_rol VALUES ($this->idusuario, {$this->rol->getIdrol()})";
            if (Conexion::getInstancia()->executeUpdate($consulta)) {
                Conexion::getInstancia()->executeCommit();
                return true;
            }
        }
        Conexion::getInstancia()->executeRollback();
        return false;
    }
    

    public function crear() {
        $rows = $this->buscar();
        if (!is_null($rows)) {
            if (!empty($rows)) {
                $this->descripcion = "Se encontró un usuario que coincide con el indicado";
                $this->idusuario = $rows[0]['idusuario'];
                return 3;
            }
            $this->descripcion = "No se realizó la creación del usuario";
            if($this->creacion()) {
                $this->descripcion = "Se realizó la creación del usuario";
                return 2;
            }
            return 1;
        }
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

    private function validarMetodo($metodo) {
        if ($metodo == "Manual" || $metodo = "Google") {
            return true;
        }
        $this->descripcion = "El método de login no es válido";
        return false;
    }

}
