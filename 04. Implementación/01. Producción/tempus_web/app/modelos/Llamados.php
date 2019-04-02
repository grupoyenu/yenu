<?php

class Llamados {

    /** @var Llamado */
    private $primero;
    
    /** @var Llamado */
    private $segundo;
    
    private $descripcion;
    
    private $valido;

    function __construct($idprimero = NULL, $idsegundo = NULL) {
        $this->valido = false;
        if ($idprimero || $idsegundo) {
            $this->primero = ($idprimero) ? new Llamado($idprimero) : NULL;
            $this->segundo = ($idsegundo) ? new Llamado($idsegundo) : NULL;
            $this->valido = true;
        }
    }

    public function cargar($primero, $segundo) {
        $this->primero = $primero;
        $this->segundo = $segundo;
    }

    public function getPrimero() {
        return $this->primero;
    }
    
    public function getIdPrimero() {
        if($this->primero && $this->primero->getIdllamado()) {
            return $this->primero->getIdllamado();
        }
        return "NULL";
    }

    public function getSegundo() {
        return $this->segundo;
    }
    
    public function getIdSegundo() {
        if($this->segundo && $this->segundo->getIdllamado()) {
            return $this->segundo->getIdllamado();
        }
        return "NULL";
    }

    public function getEstado() {
        return $this->valido;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function borrar() {
        if (!$this->validarCantidadLlamados()) {
            return 0;
        }
        if ($this->primero) {
            $eliminacion = $this->primero->borrar();
            if ($eliminacion < 2) {
                $this->descripcion = "Primero: " . $this->primero->getDescripcion();
                return $eliminacion;
            }
        }
        if ($this->segundo) {
            $eliminacion = $this->primero->borrar();
            if ($eliminacion < 2) {
                $this->descripcion = "Segundo: " . $this->primero->getDescripcion();
                return $eliminacion;
            }
        }
        return 2;
    }

    public function crear() {
        if (!$this->validarCantidadLlamados()) {
            return 0;
        }
        if ($this->primero) {
            $creacion = $this->primero->crear();
            if ($creacion < 2) {
                $this->descripcion = "Primero: ".$this->primero->getDescripcion();
                return $creacion;
            }
        }
        if ($this->segundo) {
            $creacion = $this->segundo->crear();
            if ($creacion < 2) {
                $this->descripcion = "Segundo: ".$this->segundo->getDescripcion();
                return $creacion;
            }
        }
        return 2;
    }

    public function modificar() {
        if (!$this->validarCantidadLlamados()) {
            return 0;
        }
        if ($this->primero) {
            $modificacion = $this->primero->modificar();
            if ($modificacion < 2) {
                $this->descripcion =  "Primero: ".$this->primero->getDescripcion();
                return $modificacion;
            }
        }
        if ($this->segundo) {
            $modificacion = $this->segundo->modificar();
            if ($modificacion < 2) {
                $this->descripcion =  "Segundo: ".$this->segundo->getDescripcion();
                return $modificacion;
            }
        }
        return 2;
    }

    private function validarCantidadLlamados() {
        if ($this->primero || $this->segundo) {
            return true;
        }
        $this->descripcion = "La mesa de examen debe contener al menos un llamado";
        return false;
    }

    public function obtenerFechasPrimerLlamado() {
        $consulta = "SELECT DISTINCT DATE_FORMAT(ll.fecha, '%d/%m/%Y') FROM mesa_examen me, llamado ll WHERE me.primero=ll.idllamado ORDER BY ll.fecha ASC";
        $rows = Conexion::getInstancia()->executeQuery($consulta);
        return $rows;
    }

    public function obtenerFechasSegundoLlamado() {
        $consulta = "SELECT DISTINCT DATE_FORMAT(ll.fecha, '%d/%m/%Y') FROM mesa_examen me, llamado ll WHERE me.segundo=ll.idllamado ORDER BY ll.fecha ASC";
        $rows = Conexion::getInstancia()->executeQuery($consulta);
        return $rows;
    }

    public function obtenerHorarios() {
        $consulta = "SELECT DISTINCT DATE_FORMAT(ll.hora, '%H:%i') FROM mesa_examen me, llamado ll WHERE me.primero=ll.idllamado OR me.segundo=ll.idllamado ORDER BY ll.hora ASC";
        $rows = Conexion::getInstancia()->executeQuery($consulta);
        return $rows;
    }
    
    function __destruct() {
        unset($this);
    }

}
