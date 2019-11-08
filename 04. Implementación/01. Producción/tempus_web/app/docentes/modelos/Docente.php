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
        if ($this->nombre) {
            $existe = $this->verificarExistencia();
            if ($existe == 1) {
                $values = "(NULL, '$this->nombre')";
                $creacion = Conexion::getInstancia()->insertar("docente", $values);
                $this->idDocente = ($creacion == 2) ? (Int) Conexion::getInstancia()->insert_id : NULL;
                $this->descripcion = Conexion::getInstancia()->getDescripcion();
                return $creacion;
            }
            return $existe;
        }
        return 0;
    }

    private function verificarExistencia() {
        $consulta = "SELECT iddocente FROM docente WHERE nombre = '{$this->nombre}'";
        $resultado = Conexion::getInstancia()->obtener($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        if (gettype($resultado) == "array") {
            $this->descripcion = "Se verificó la existencia del docente";
            $this->idDocente = $resultado['iddocente'];
            return 2;
        }
        return $resultado;
    }

}
