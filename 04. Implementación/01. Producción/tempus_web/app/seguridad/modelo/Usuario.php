<?php

namespace app\seguridad\modelo;

use app\principal\modelo\Conexion;

/**
 * Description of Usuario
 *
 * @author Emanuel
 */
class Usuario {

    /** @var integer Identificador del usuario en la base de datos */
    private $id;

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

    public function __construct($id = NULL, $email = NULL, $nombre = NULL, $metodo = NULL, $estado = NULL, $rol = NULL) {
        $this->setId($id);
        $this->setEmail($email);
        $this->setNombre($nombre);
        $this->setMetodo($metodo);
        $this->setEstado($estado);
        $this->setRol($rol);
    }

    public function getId() {
        return $this->id;
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

    public function setId($id) {
        $this->id = ($id > 0) ? $id : NULL;
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
        if ($this->id) {
            $relacion = $this->borrarRelacionRol();
            if ($relacion == 2) {
                $consulta = "DELETE usuario WHERE id = {$this->id}";
                return Conexion::getInstancia()->borrar($consulta);
            }
            return array($relacion, "No se realizo la eliminación del usuario");
        }
        return array(0, "No se pudo hacer referencia al usuario");
    }

    private function borrarRelacionRol() {
        $consulta = "DELETE usuario_rol WHERE idusuario = {$this->id}";
        $resultado = Conexion::getInstancia()->borrar($consulta);
        return $resultado[0];
    }

    public function crear() {
        if ($this->email && $this->nombre && $this->metodo && $this->rol && $this->estado) {
            $consulta = "INSERT INTO usuario VALUES (NULL, '$this->email', '$this->nombre', '$this->metodo', '$this->estado')";
            $resultado = Conexion::getInstancia()->insertar($consulta);
            if ($resultado[0] == 2) {
                $this->id = $resultado[2];
                $creacion = $this->crearRelacionRol();
                $resultado[1] = ($creacion == 2) ? "Se creó el usuario correctamente" : "No se creó el usuario";
            }
            return $resultado;
        }
        return array(0, "No se recibieron los campos obligatorios o no cumplen el formato");
    }

    private function crearRelacionRol() {
        $consulta = "INSERT INTO rol_usuario VALUES ({$this->rol}, {$this->id})";
        $resultado = Conexion::getInstancia()->insertar($consulta);
        return $resultado[0];
    }

    public function modificar() {
        if ($this->id && $this->email && $this->nombre && $this->rol && $this->metodo && $this->estado) {
            $consulta = "UPDATE usuario SET email = '{$this->email}', "
                    . "nombre='{$this->nombre}', metodoLogin='{$this->metodo}', "
                    . "estado='{$this->estado}' WHERE id = {$this->id}";
            $resultado = Conexion::getInstancia()->modificar($consulta);
            if ($resultado[0] == 2) {
                $rbor = $this->borrarRelacionRol();
                $rcre = $this->crearRelacionRol();
                $exito = array(2, "Se modificó el usuario correctamente");
                $error = array(1, "No se modificó el usuario");
                return ($rbor == 2 && $rcre == 2) ? $exito : $error;
            }
            return $resultado;
        }
        return array(0, "Los campos necesarios para modificar el usuario no cumplen con el formato requerido");
    }

    public function obtenerPorIdentificador() {
        if ($this->id) {
            $consulta = "SELECT usu.*, rel.rol_id FROM usuario usu "
                    . "INNER JOIN rol_usuario rel ON rel.usuario_id = usu.id "
                    . "WHERE usu.id = {$this->id}";
            $resultado = Conexion::getInstancia()->obtener($consulta);
            if (gettype($resultado[0]) == "array") {
                $fila = $resultado[0];
                $this->nombre = $fila['nombre'];
                $this->email = $fila['email'];
                $this->metodo = $fila['metodoLogin'];
                $this->estado = $fila['estado'];
                return $this->obtenerRol($fila['rol_id']);
            }
            return $resultado;
        }
        return array(0, "No se pudo hacer referencia al usuario");
    }

    private function obtenerRol($idRol) {
        $rol = new Rol($idRol);
        $resultado = $rol->obtenerPorIdentificador();
        $this->rol = ($resultado[0] == 2) ? $rol : NULL;
        return $resultado;
    }

    public function login() {
        if ($this->email) {
            $consulta = "SELECT usu.*, rel.rol_id FROM usuario usu "
                    . "INNER JOIN rol_usuario rel ON rel.usuario_id = usu.id "
                    . "WHERE usu.email = '{$this->email}'";
            $resultado = Conexion::getInstancia()->obtener($consulta);
            if (gettype($resultado[0]) == "array") {
                $fila = $resultado[0];
                $this->id = $fila['id'];
                $this->nombre = $fila['nombre'];
                $this->email = $fila['email'];
                $this->metodo = $fila['metodoLogin'];
                $this->estado = $fila['estado'];
                return $this->obtenerRol($fila['rol_id']);
            }
            return array(1, "El usuario '{$this->email}' no se encuentra registrado en el sistema");
        }
        return array(0, "No se pudo hacer referencia al usuario con su email");
    }

}
