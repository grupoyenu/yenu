<?php

class MesaExamen {

    private $idMesa;
    private $plan;
    private $tribunal;
    private $primero;
    private $segundo;
    private $descripcion;

    public function __construct($id = NULL, $plan = NULL, $tribunal = NULL, $primero = NULL, $segundo = NULL) {
        $this->setIdMesa($id);
        $this->setPlan($plan);
        $this->setTribunal($tribunal);
        $this->setPrimero($primero);
        $this->setSegundo($segundo);
    }

    public function getIdMesa() {
        return $this->idMesa;
    }

    public function getPlan() {
        return $this->plan;
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

    public function setPlan($plan) {
        $this->plan = $plan;
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
