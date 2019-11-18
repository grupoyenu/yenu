<?php

class Asignatura {

    /** @var string Identificador de la asignatura en la base de datos */
    private $idAsignatura;

    /** @var string Nombre de la asignatura */
    private $nombre;

    /** @var string Descripcion para mostrar mensajes */
    private $descripcion;

    public function __construct($id = NULL, $nombre = NULL) {
        $this->setIdAsignatura($id);
        $this->setNombre($nombre);
    }

    public function getIdAsignatura() {
        return $this->idAsignatura;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setIdAsignatura($idAsignatura) {
        $this->idAsignatura = $idAsignatura;
    }

    public function setNombre($nombre) {
        if (preg_match("/^[A-Za-zÁÉÍÓÚÑüáéíóúñ0-9,. ]{5,60}$/", $nombre)) {
            $this->nombre = Utilidades::convertirCamelCase($nombre);
        }
    }

    public function crear() {
        if ($this->nombre) {
            $existe = $this->verificarExistencia();
            if ($existe == 1) {
                $values = "(NULL, '$this->nombre')";
                $creacion = Conexion::getInstancia()->insertar("asignatura", $values);
                $this->idAsignatura = ($creacion == 2) ? (Int) Conexion::getInstancia()->insert_id : NULL;
                $this->descripcion = Conexion::getInstancia()->getDescripcion();
                return $creacion;
            }
            return $existe;
        }
        $this->descripcion = "No se recibió el nombre de la asignatura o no cumple el formato requerido";
        return 1;
    }

    public function obtener() {
        if ($this->idAsignatura) {
            $consulta = "SELECT * FROM asignatura WHERE idasignatura = {$this->idAsignatura}";
            $fila = Conexion::getInstancia()->obtener($consulta);
            if (!is_null($fila)) {
                $this->nombre = $fila['nombre'];
                return 2;
            }
            $this->descripcion = Conexion::getInstancia()->getDescripcion();
            return 1;
        }
        $this->descripcion = "No se pudo hacer referencia a la asignatura";
        return 1;
    }

    private function verificarExistencia() {
        $consulta = "SELECT idasignatura FROM asignatura WHERE nombre = '{$this->nombre}'";
        $resultado = Conexion::getInstancia()->obtener($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        if (gettype($resultado) == "array") {
            $this->descripcion = "Se verificó la existencia de la asignatura";
            $this->idAsignatura = $resultado['idasignatura'];
            return 2;
        }
        return $resultado;
    }

}
