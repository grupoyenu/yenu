<?php

/**
 * Description of Usuario
 *
 * @author Emanuel
 */
class Usuario {

    /** @var integer Identificador del usuario en la base de datos */
    private $idUsuario;

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

    public function __construct($id = NULL, $email = NULL, $nombre = NULL, $metodo = NULL, $estado = NULL, $rol = NULL) {
        $this->setIdUsuario($id);
        $this->setEmail($email);
        $this->setNombre($nombre);
        $this->setMetodo($metodo);
        $this->setEstado($estado);
        $this->setRol($rol);
    }

    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getMetodo() {
        return $this->metodo;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getRol(): Rol {
        return $this->rol;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setMetodo($metodo) {
        $this->metodo = $metodo;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setRol($rol) {
        $this->rol = $rol;
    }

    public function crear() {
        if ($this->email && $this->nombre && $this->metodo && $this->rol && $this->estado) {
            $values = "(NULL, '$this->email', '$this->nombre', '$this->metodo', '$this->estado')";
            $creacion = Conexion::getInstancia()->insertar("usuario", $values);
            $this->idPermiso = ($creacion == 2) ? (Int) Conexion::getInstancia()->insert_id : NULL;
            $this->descripcion = $this->nombre . ": " . Conexion::getInstancia()->getDescripcion();
            return $creacion;
        }
        return 0;
    }

    public function modificar() {
        if ($this->idUsuario && $this->email && $this->nombre && $this->metodo && $this->rol && $this->estado) {
            $campos = "email = '{$this->email}', nombre='{$this->nombre}', metodo='{$this->metodo}', rol={$this->rol}, estado='{$this->estado}'";
            $condicion = "idusuario={$this->idUsuario}";
            $modificacion = Conexion::getInstancia()->modificar("usuario", $campos, $condicion);
            $this->descripcion = Conexion::getInstancia()->getDescripcion();
            return $modificacion;
        }
        return 0;
    }

}
