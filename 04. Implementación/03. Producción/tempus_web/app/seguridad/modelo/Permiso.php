<?php

namespace app\seguridad\modelo;

use app\principal\modelo\Conexion;

class Permiso {

    /** @var integer Identificador del permiso en la base de datos */
    private $id;

    /** @var string Nombre del permiso */
    private $nombre;

    /**
     * Constructor de clase.
     */
    public function __construct($id = NULL, $nombre = NULL) {
        $this->setId($id);
        $this->setNombre($nombre);
    }

    /**
     * Retorna el identificador del permiso.
     * @return int Identificador del permiso.
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Retorna el nombre del permiso.
     * @return string Nombre del permiso.
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Modifica el identificador del permiso solo si es mayor que cero.
     * @param int $id Identificador del permiso.
     */
    public function setId($id) {
        $this->id = ($id > 0) ? $id : NULL;
    }

    /**
     * Modifica el nombre del permiso solo si cumple con el formato requerido.
     * @param string $nombre Nombre del permiso.
     */
    public function setNombre($nombre) {
        if (preg_match("/^[A-Za-z_]{5,15}$/", $nombre)) {
            $this->nombre = strtoupper($nombre);
        }
    }

    public function borrar(): array {
        if ($this->id) {
            $consulta = "DELETE FROM permiso WHERE id = {$this->id}";
            $resultado = Conexion::getInstancia()->borrar($consulta);
            return $resultado;
        }
        return array(0, "No se pudo hacer referencia al permiso");
    }

    public function crear(): array {
        if ($this->nombre) {
            $consulta = "INSERT INTO permiso VALUES (NULL, '$this->nombre')";
            $creacion = Conexion::getInstancia()->insertar($consulta);
            $this->id = ($creacion[0] == 2) ? $creacion[2] : NULL;
            return $creacion;
        }
        return array(0, "Los datos necesarios para crear el permiso no cumplen con el formato requerido");
    }

    public function modificar(): array {
        if ($this->id && $this->nombre) {
            $consulta = "UPDATE permiso SET nombre = '{$this->nombre}' WHERE id = {$this->id}";
            $edicion = Conexion::getInstancia()->modificar($consulta);
            return $edicion;
        }
        return array(0, "Los datos necesarios para modificar el permiso no cumplen con el formato requerido");
    }

    public function obtener() {
        if ($this->id) {
            $consulta = "SELECT * FROM permiso WHERE id = {$this->id}";
            $resultado = Conexion::getInstancia()->obtener($consulta);
            if (gettype($resultado[0]) == "array") {
                $fila = $resultado[0];
                $this->nombre = $fila['nombre'];
                return array(2, "Se obtuvo la información del permiso correctamente");
            }
            return $resultado;
        }
        return array(0, "No se pudo hacer referencia al permiso");
    }

}
