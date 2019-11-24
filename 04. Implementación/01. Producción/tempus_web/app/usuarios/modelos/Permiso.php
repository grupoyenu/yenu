<?php

/**
 * Description of Permiso
 *
 * @author Emanuel
 */
class Permiso {

    /** @var integer Identificador del permiso en la base de datos */
    private $idPermiso;

    /** @var string Nombre del permiso */
    private $nombre;

    /** @var string Descripcion para mostrar mensajes */
    private $descripcion;

    public function __construct($id = NULL, $nombre = NULL) {
        $this->setIdPermiso($id);
        $this->setNombre($nombre);
    }

    public function getIdPermiso() {
        return $this->idPermiso;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setIdPermiso($idPermiso) {
        $this->idPermiso = $idPermiso;
    }

    public function setNombre($nombre) {
        if (preg_match("/^[A-Za-z_]{5,15}$/", $nombre)) {
            $this->nombre = strtoupper($nombre);
        } else {
            $this->descripcion = "El nombre del permiso no cumple con el formato requerido";
        }
    }

    public function borrar() {
        if ($this->idPermiso) {
            $condicion = "idpermiso = {$this->idPermiso}";
            $eliminacion = Conexion::getInstancia()->borrar("permiso", $condicion);
            $this->descripcion = Conexion::getInstancia()->getDescripcion();
            return $eliminacion;
        }
        $this->descripcion = "No se pudo hacer referencia al permiso";
        return 0;
    }

    public function crear() {
        if ($this->nombre) {
            $values = "(NULL, '$this->nombre')";
            $creacion = Conexion::getInstancia()->insertar("permiso", $values);
            $this->idPermiso = ($creacion == 2) ? (Int) Conexion::getInstancia()->insert_id : NULL;
            $this->descripcion = $this->nombre . ": " . Conexion::getInstancia()->getDescripcion();
            return $creacion;
        }
        return 0;
    }

    public function modificar() {
        if ($this->idPermiso && $this->nombre) {
            $campos = "nombre = '{$this->nombre}'";
            $condicion = "idpermiso={$this->idPermiso}";
            $modificacion = Conexion::getInstancia()->modificar("permiso", $campos, $condicion);
            $this->descripcion = $this->nombre . ": " . Conexion::getInstancia()->getDescripcion();
            return $modificacion;
        }
        $this->descripcion = "No se recibieron todos los campos obligatorios";
        return 0;
    }

    public function obtener() {
        if ($this->idPermiso) {
            $consulta = "SELECT * FROM permiso WHERE idpermiso = {$this->idPermiso}";
            $fila = Conexion::getInstancia()->obtener($consulta);
            if (gettype($fila) == "array") {
                $this->nombre = $fila['nombre'];
                return 2;
            }
            $this->descripcion = "No se obtuvo la información del permiso";
            return 1;
        }
        $this->descripcion = "No se pudo hacer referencia al permiso";
        return 0;
    }

}
