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

    /** @var integer Rol que posee el usuario dentro del sistema */
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

    public function getRol() {
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

    public function borrar() {
        if ($this->idUsuario) {
            $relacion = $this->borrarRelacionRol();
            if ($relacion == 2) {
                $condicion = "idusuario = {$this->idUsuario}";
                $eliminacion = Conexion::getInstancia()->borrar("usuario", $condicion);
                $this->descripcion = Conexion::getInstancia()->getDescripcion();
                return $eliminacion;
            }
            return $relacion;
        }
        return 0;
    }

    private function borrarRelacionRol() {
        $condicion = "idusuario = {$this->idUsuario}";
        $eliminacion = Conexion::getInstancia()->borrar("usuario_rol", $condicion);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $eliminacion;
    }

    public function crear() {
        if ($this->email && $this->nombre && $this->metodo && $this->rol && $this->estado) {
            $values = "(NULL, '$this->email', '$this->nombre', '$this->metodo', '$this->estado')";
            $creacion = Conexion::getInstancia()->insertar("usuario", $values);
            $this->idUsuario = ($creacion == 2) ? (Int) Conexion::getInstancia()->insert_id : NULL;
            $this->descripcion = $this->nombre . ": " . Conexion::getInstancia()->getDescripcion();
            if ($creacion == 2) {
                $creacion = $this->crearRelacionRol();
            }
            return $creacion;
        }
        $this->descripcion = "No se recibieron los campos obligatorios o no cumplen el formato";
        return 0;
    }

    private function crearRelacionRol() {
        $values = "({$this->idUsuario}, {$this->rol})";
        $creacion = Conexion::getInstancia()->insertar("usuario_rol", $values);
        $this->descripcion = $this->nombre . ": " . Conexion::getInstancia()->getDescripcion();
        return $creacion;
    }

    public function modificar() {
        if ($this->idUsuario && $this->email && $this->nombre && $this->rol && $this->metodo && $this->estado) {
            $campos = "email = '{$this->email}', nombre='{$this->nombre}', metodologin='{$this->metodo}', estado='{$this->estado}'";
            $condicion = "idusuario={$this->idUsuario}";
            $modificacion = Conexion::getInstancia()->modificar("usuario", $campos, $condicion);
            $this->descripcion = $this->nombre . ": " . Conexion::getInstancia()->getDescripcion();
            if ($modificacion == 2) {
                $borrar = $this->borrarRelacionRol();
                $crear = $this->crearRelacionRol();
                $this->descripcion = ($borrar == 2 && $crear == 2) ? $this->nombre . ": Se modificó correctamente" : $this->nombre . ": No se modificó el usuario";
                return ($borrar == 2 && $crear == 2) ? 2 : 1;
            }
            return $modificacion;
        }
        return 0;
    }

    public function obtener() {
        if ($this->idUsuario) {
            $consulta = "SELECT usu.*, rel.idrol FROM usuario usu "
                    . "INNER JOIN usuario_rol rel ON rel.idusuario = usu.idusuario "
                    . "WHERE usu.idusuario = {$this->idUsuario}";
            $fila = Conexion::getInstancia()->obtener($consulta);
            if (gettype($fila) == "array") {
                $this->nombre = $fila['nombre'];
                $this->email = $fila['email'];
                $this->metodo = $fila['metodologin'];
                $this->estado = $fila['estado'];
                $this->rol = $fila['idrol'];
                return 2;
            }
            $this->descripcion = "No se obtuvo la información de la cursada";
            return 1;
        }
        $this->descripcion = "No se pudo hacer referencia al usuario";
        return 0;
    }

}
