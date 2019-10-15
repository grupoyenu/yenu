<?php

class Docente {

    /** @var integer $iddocente */
    private $idDocente;

    /** @var string $nombre */
    private $nombre;

    /** @var string Descripcion para mostrar mensajes */
    private $descripcion;

    /** @var string Nombre de la tabla en la base de datos. */
    private $TABLA = "docente";

    public function __construct($id = NULL, $nombre = NULL) {
        $this->setIdDocente($id);
        $this->setNombre($nombre);
    }

    public function getIdDocente() {
        return $this->idDocente;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setIdDocente($idDocente) {
        if ($idDocente) {
            $this->idDocente = $idDocente;
        } else {
            $this->descripcion = "No se pudo hacer referencia al docente";
        }
    }

    public function setNombre($nombre) {
        if (preg_match("/^[A-Za-zÁÉÍÓÚÑáéíóúñ., ]{4,100}$/", $nombre)) {
            $this->nombre = Utilidades::convertirCamelCase($nombre);
        } else {
            $this->descripcion = "El nombre de docente no cumple con el formato requerido";
        }
    }

    public function crear() {
        $values = "(NULL, '$this->nombre')";
        $creacion = Conexion::getInstancia()->insertar($this->TABLA, $values);
        $this->idDocente = ($creacion == 2) ? (Int) Conexion::getInstancia()->insert_id : NULL;
        $this->descripcion = Conexion::getInstancia()->getDescripcion() . " del docente";
        return $creacion;
    }

    public function buscar() {
        if ($this->nombre) {
            $consulta = "SELECT * FROM {$this->TABLA} WHERE nombre LIKE '%{$this->nombre}%' ";
            return Conexion::getInstancia()->seleccionar($consulta);
        }
        return NULL;
    }

    public function listar() {
        return Conexion::getInstancia()->seleccionarTodo($this->TABLA);
    }

    public function obtener() {
        if ($this->idDocente) {
            $consulta = "SELECT * FROM {$this->TABLA} WHERE iddocente = {$this->idDocente} ";
            $fila = Conexion::getInstancia()->obtener($consulta);
            if (!is_null($fila)) {
                $this->nombre = $fila['nombre'];
                return 2;
            }
            return 1;
        }
        return 0;
    }

}
