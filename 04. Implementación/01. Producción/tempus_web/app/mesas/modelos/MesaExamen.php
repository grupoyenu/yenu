<?php

class MesaExamen {

    private $idMesa;
    private $carrera;
    private $asignatura;
    private $tribunal;
    private $primero;
    private $segundo;
    private $descripcion;

    public function __construct($id = NULL, $asignatura = NULL, $carrera = NULL, $tribunal = NULL, $primero = NULL, $segundo = NULL) {
        $this->setIdMesa($id);
        $this->setCarrera($carrera);
        $this->setAsignatura($asignatura);
        $this->setTribunal($tribunal);
        $this->setPrimero($primero);
        $this->setSegundo($segundo);
    }

    public function getIdMesa() {
        return $this->idMesa;
    }

    public function getCarrera() {
        return $this->carrera;
    }

    public function getAsignatura() {
        return $this->asignatura;
    }

    public function getTribunal() {
        return $this->tribunal;
    }

    public function getPrimero() {
        return $this->primero;
    }

    public function getSegundo() {
        return $this->segundo;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setIdMesa($idMesa) {
        $this->idMesa = $idMesa;
    }

    public function setCarrera($carrera) {
        $this->carrera = $carrera;
    }

    public function setAsignatura($asignatura) {
        $this->asignatura = $asignatura;
    }

    public function setTribunal($tribunal) {
        $this->tribunal = $tribunal;
    }

    public function setPrimero($primero) {
        $this->primero = $primero;
    }

    public function setSegundo($segundo) {
        $this->segundo = $segundo;
    }

    public function borrar() {
        if ($this->idMesa) {
            $condicion = "idmesa=" . $this->idMesa;
            $eliminacion = Conexion::getInstancia()->borrar("mesa_examen", $condicion);
            $this->descripcion = Conexion::getInstancia()->getDescripcion();
            if ($eliminacion == 2) {
                $borrarTribunal = $this->borrarTribunal();
                $borrarLlamados = $this->borrarLlamados();
                return ($borrarTribunal == 2 && $borrarLlamados == 2) ? 2 : 0;
            }
            return $eliminacion;
        }
        $this->descripcion = "No se pudo hacer referencia a la mesa de examen";
        return 0;
    }

    private function borrarTribunal() {
        $tribunal = new Tribunal($this->tribunal);
        $eliminacion = $tribunal->borrar();
        if ($eliminacion != 2) {
            $this->descripcion = $tribunal->getDescripcion();
        }
        return $eliminacion;
    }

    private function borrarLlamados() {
        $llamados = new Llamados();
        $eliminacion = $llamados->borrar();
        if ($eliminacion != 2) {
            $this->descripcion = "No se realizó la eliminación del/los llamado/s asociados a la mesa de examen";
        }
        return $eliminacion;
    }

    public function crear() {
        if ($this->carrera && $this->asignatura && $this->tribunal && ($this->primero || $this->segundo)) {
            $primero = ($this->primero) ? $this->primero : "NULL";
            $segundo = ($this->segundo) ? $this->segundo : "NULL";
            $values = "(NULL, {$this->asignatura}, {$this->carrera}, {$this->tribunal}, {$primero}, {$segundo})";
            $creacion = Conexion::getInstancia()->insertar("mesa_examen", $values);
            $this->idasignatura = ($creacion == 2) ? (Int) Conexion::getInstancia()->insert_id : NULL;
            $this->descripcion = Conexion::getInstancia()->getDescripcion();
            return $creacion;
        }
        $this->descripcion = "No se indicaron todos los campos obligatorios";
        return 0;
    }

    public function obtener() {
        if ($this->idMesa) {
            $consulta = "SELECT * FROM vista_mesas WHERE idmesa = {$this->idMesa}";
            $fila = Conexion::getInstancia()->obtener($consulta);
            if (gettype($fila) == "array") {
                return $fila;
            }
            $this->descripcion = "No se obtuvo la infomación de la mesa de examen";
            return 1;
        }
        $this->descripcion = "No se pudo hacer referencia a la mesa de examen";
        return 0;
    }

}
