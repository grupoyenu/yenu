<?php

class Carrera {

    /** @var integer $codigo Codigo de la carrera. */
    private $codigo;

    /** @var string $nombre Nombre de la carrera. */
    private $nombre;

    /** @var array $asignaturas Arreglo de las asignaturas de la carrera */
    private $asignaturas;

    /** @var string Descripcion para mostrar mensajes */
    private $descripcion;

    public function __construct($codigo = NULL, $nombre = NULL) {
        $this->setCodigo($codigo);
        $this->setNombre($nombre);
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getAsignaturas() {
        return $this->asignaturas;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setCodigo($codigo) {
        if (preg_match("/^[0-9]{1,3}$/", $codigo)) {
            $this->codigo = $codigo;
        } else {
            $this->descripcion = "El código no cumple el formato requerido";
        }
    }

    public function setNombre($nombre) {
        if (preg_match("/^[A-Za-zÁÉÍÓÚÑáéíóúñ. ]{10,255}$/", $nombre)) {
            $this->nombre = Utilidades::convertirCamelCase($nombre);
        } else {
            $this->descripcion = "El nombre no cumple con el formato requerido";
        }
    }

    public function setAsignaturas($asignaturas) {
        $this->asignaturas = $asignaturas;
    }

    public function agregarAsignatura($idAsignatura, $anio) {
        if ($this->codigo) {
            $values = "({$idAsignatura}, {$this->codigo}, {$anio})";
            $creacion = Conexion::getInstancia()->insertar("asignatura_carrera", $values);
            $this->idasignatura = ($creacion == 2) ? (Int) Conexion::getInstancia()->insert_id : NULL;
            $this->descripcion = Conexion::getInstancia()->getDescripcion();
            return $creacion;
        }
        return 1;
    }

    public function crear() {
        if ($this->codigo && $this->nombre) {
            $existe = $this->verificarExistencia();
            if ($existe == 1) {
                $values = "($this->codigo, '$this->nombre')";
                $creacion = Conexion::getInstancia()->insertar("carrera", $values);
                $this->descripcion = Conexion::getInstancia()->getDescripcion();
                return $creacion;
            }
            return $existe;
        }
        return 1;
    }

    public function obtener() {
        if ($this->codigo) {
            $consulta = "SELECT * FROM carrera WHERE codigo = {$this->codigo}";
            $fila = Conexion::getInstancia()->obtener($consulta);
            if (!is_null($fila)) {
                $this->nombre = $fila['nombre'];
                $this->asignaturas = $this->obtenerAsignaturas();
                return 2;
            }
            $this->descripcion = Conexion::getInstancia()->getDescripcion();
            return 1;
        }
        return 1;
    }

    public function obtenerAsignaturas() {
        if ($this->codigo) {
            $consulta = "SELECT ma.*, ac.anio "
                    . "FROM asignatura_carrera ac "
                    . "INNER JOIN asignatura ma ON ma.idasignatura = ac.idasignatura "
                    . "WHERE idcarrera = {$this->codigo} ORDER BY ac.anio ASC, ma.nombre ASC";
            return Conexion::getInstancia()->seleccionar($consulta);
        }
        return 1;
    }

    private function verificarExistencia() {
        $consulta = "SELECT codigo FROM carrera WHERE codigo = {$this->codigo} OR nombre = '{$this->nombre}'";
        $resultado = Conexion::getInstancia()->obtener($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        if (gettype($resultado) == "array") {
            $this->descripcion = "Se verificó la existencia de la carrera";
            $this->idAsignatura = $resultado['codigo'];
            return 2;
        }
        return $resultado;
    }

}
