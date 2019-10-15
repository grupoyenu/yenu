<?php

class Asignatura {

    /** @var string Identificador de la asignatura en la base de datos */
    private $idAsignatura;

    /** @var string Nombre de la asignatura */
    private $nombre;

    /** @var string Descripcion para mostrar mensajes */
    private $descripcion;
    private $carreras;

    /** @var string Nombre de la tabla en la base de datos. */
    private $TABLA = "asignatura";

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

    public function getCarreras() {
        return $this->carreras;
    }

    public function setIdAsignatura($idAsignatura) {
        $this->idAsignatura = $idAsignatura;
    }

    public function setNombre($nombre) {
        if (preg_match("/^[A-Za-zÑÁÉÍÓÚñáéíóú0123456789,. ]{5,255}$/", $nombre)) {
            $this->nombre = Utilidades::convertirCamelCase($nombre);
        } else {
            $this->descripcion = "El nombre no cumple con el formato requerido";
        }
    }

    public function agregarCarrera($codigo, $anio) {
        if ($this->idAsignatura) {
            $values = "({$this->idAsignatura}, {$codigo}, {$anio})";
            $creacion = Conexion::getInstancia()->insertar("asignatura_carrera", $values);
            $this->idasignatura = ($creacion == 2) ? (Int) Conexion::getInstancia()->insert_id : NULL;
            $this->descripcion = Conexion::getInstancia()->getDescripcion();
            return $creacion;
        }
        return 1;
    }

    public function crear() {
        if ($this->nombre) {
            $values = "(NULL, '$this->nombre')";
            $creacion = Conexion::getInstancia()->insertar($this->TABLA, $values);
            $this->idasignatura = ($creacion == 2) ? (Int) Conexion::getInstancia()->insert_id : NULL;
            $this->descripcion = Conexion::getInstancia()->getDescripcion();
            return $creacion;
        }
        return 1;
    }

    public function obtener() {
        if ($this->idAsignatura) {
            $consulta = "SELECT * FROM {$this->TABLA} WHERE idasignatura = {$this->idAsignatura}";
            $fila = Conexion::getInstancia()->obtener($consulta);
            if (!is_null($fila)) {
                $this->nombre = $fila['nombre'];
                return 2;
            }
            $this->descripcion = Conexion::getInstancia()->getDescripcion();
            return 1;
        }
        $this->descripcion = "No se pudo hacer referencia a la asignatura";
        return 0;
    }

    public function obtenerCarreras() {
        $consulta = "SELECT ac.anio, ac.idcarrera, ca.nombre "
                . "FROM asignatura_carrera ac "
                . "LEFT JOIN carrera ca ON ca.codigo = ac.idcarrera "
                . "WHERE ac.idasignatura = {$this->idAsignatura}";
        $this->carreras = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return (gettype($this->carreras) == 'object') ? 2 : 1;
    }

}
