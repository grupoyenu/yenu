<?php

namespace app\seguridad\modelo;

use app\principal\modelo\Conexion;
use app\seguridad\modelo\ColeccionPermisos as Permisos;

class Rol {

    /** @var integer Identificador del rol en la base de datos */
    private $id;

    /** @var string Nombre del rol */
    private $nombre;

    /** @var array() Permisos asociados al rol */
    private $permisos;

    public function __construct($id = NULL, $nombre = NULL, $permisos = NULL) {
        $this->setId($id);
        $this->setNombre($nombre);
        $this->setPermisos($permisos);
    }

    /**
     * Retorna el identificador del rol.
     * @return int Identificador del rol.
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * Retorna el nombre del rol.
     * @return string Nombre del rol.
     */
    public function getNombre(): string {
        return $this->nombre;
    }

    /**
     * Retorna los permisos asociados al rol.
     * @return array Permisos del rol.
     */
    public function getPermisos(): array {
        return $this->permisos;
    }

    /**
     * Modifica el identificador del rol solo si es mayor que cero.
     * @param int $id Identificador del rol.
     */
    public function setId($id) {
        $this->id = ($id > 0) ? $id : NULL;
    }

    /**
     * Modifica el nombre del rol solo si cumple con el formato requerido.
     * @param string $nombre Nombre del rol.
     */
    public function setNombre($nombre) {
        if (preg_match("/^[A-Za-z ]{5,30}$/", $nombre)) {
            $this->nombre = $nombre;
        }
    }

    /**
     * Modifica los permisos del rol.
     * @param array $permisos Permisos del rol.
     */
    public function setPermisos($permisos) {
        $this->permisos = $permisos;
    }

    /**
     * Crear las relaciones entre los permisos y el rol.
     */
    private function agregarPermiso() {
        if (!empty($this->permisos)) {
            $values = "";
            foreach ($this->permisos as $permiso) {
                $values .= "({$this->id}, {$permiso}),";
            }
            $consulta = "INSERT INTO rol_permiso VALUES " . substr($values, 0, -1);
            return Conexion::getInstancia()->insertar($consulta);
        }
        return array(0, "Se debe indicar al menos un permiso para crear el rol");
    }

    /**
     * Eliminar rol. Quita las relaciones del rol con los permisos y luego elimina
     * el rol.
     */
    public function borrar() {
        if ($this->id) {
            $resultado = $this->quitarPermisos();
            if ($resultado[0] == 2) {
                $consulta = "DELETE FROM rol WHERE id = {$this->id}";
                $resultado = Conexion::getInstancia()->borrar($consulta);
            }
            return $resultado;
        }
        return array(0, "No se pudo hacer referencia al rol");
    }

    /**
     * Crear nuevo rol. Crea el rol y luego crea las relaciones entre los permisos
     * asociados y dicho rol.
     */
    public function crear() {
        if ($this->nombre && $this->permisos) {
            $consulta = "INSERT INTO rol VALUES (NULL, '$this->nombre')";
            $resultado = Conexion::getInstancia()->insertar($consulta);
            if ($resultado[0] == 2) {
                $this->id = $resultado[2];
                $resultado = $this->agregarPermiso();
            }
            return $resultado;
        }
        return array(0, "Los campos necesarios para crear el rol no cumplen el formato requerido");
    }

    public function modificar() {
        if ($this->id && $this->nombre) {
            $consulta = "UPDATE rol SET nombre = '{$this->nombre}' WHERE id = {$this->id}";
            $resultado = Conexion::getInstancia()->modificar($consulta);
            if ($resultado[0] == 2) {
                $borrar = $this->quitarPermisos();
                $anadir = $this->agregarPermiso();
                $exito = array(2, "Se modificó el rol correctamente");
                $error = array(1, "No se modificó el rol");
                $resultado = ($borrar[0] == 2 && $anadir[0] == 2) ? $exito : $error;
            }
            return $resultado;
        }
        return array(0, "No se pudo hacer referencia al rol");
    }

    public function obtenerPorIdentificador() {
        if ($this->id) {
            $consulta = "SELECT * FROM rol WHERE id = {$this->id}";
            $resultado = Conexion::getInstancia()->obtener($consulta);
            if (gettype($resultado[0]) == "array") {
                $fila = $resultado[0];
                $this->nombre = $fila['nombre'];
                return $this->obtenerPermisos();
            }
            return array(1, "No se pudo obtener la información del rol");
        }
        return array(0, "No se pudo hacer referencia al rol");
    }

    private function obtenerPermisos() {
        $resultado = Permisos::listarPermisosRol($this->id);
        if ($resultado[0] == 2) {
            $this->permisos = $resultado[1];
            return array(2, "Se obtuvo la información del rol correctamente");
        }
        return $resultado;
    }

    private function quitarPermisos() {
        $consulta = "DELETE FROM rol_permiso WHERE rol_id = {$this->id}";
        $resultado = Conexion::getInstancia()->borrar($consulta);
        return $resultado;
    }

}
