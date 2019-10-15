<?php

class Plan {

    private $asignatura;
    private $carrera;
    private $anio;
    private $mesa;
    private $clases;
    private $descripcion;

    public function __construct($parametros = NULL) {
        $asignatura = ($parametros) ? $parametros[0] : NULL;
        $carrera = ($parametros) ? $parametros[1] : NULL;
        $anio = ($parametros) ? $parametros[2] : NULL;
        $mesa = ($parametros) ? $parametros[3] : NULL;
        $clases = ($parametros) ? $parametros[4] : NULL;
        $this->setAsignatura($asignatura);
        $this->setCarrera($carrera);
        $this->setAnio($anio);
        $this->setMesa($mesa);
        $this->setClases($clases);
    }

    public function getAsignatura() {
        return $this->asignatura;
    }

    public function getCarrera() {
        return $this->carrera;
    }

    public function getAnio() {
        return $this->anio;
    }

    public function getMesa() {
        return $this->mesa;
    }

    public function getClases() {
        return $this->clases;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setAsignatura($asignatura) {
        if ($asignatura) {
            $this->asignatura = $asignatura;
        } else {
            $this->descripcion = "No se pudo hacer referencia a la asignatura";
        }
    }

    public function setCarrera($carrera) {
        if ($carrera) {
            $this->carrera = $carrera;
        } else {
            $this->descripcion = "No se pudo hacer referencia a la carrera";
        }
    }

    public function setAnio($anio) {
        $this->anio = $anio;
    }

    public function setMesa($mesa) {
        $this->mesa = $mesa;
    }

    public function setClases($clases) {
        $this->clases = $clases;
    }

    public function crearClases() {
        if ($this->asignatura && $this->carrera && $this->clases) {
            $identificadores = array();
            foreach ($this->clases as $clase) {
                $creacion = $clase->crear();
                if ($creacion != 2) {
                    $this->descripcion = "No se realizó la creación de una o más clases {$clase->getDia()} ({$clase->getDescripcion()})";
                    return $creacion;
                }
                $identificadores[] = $clase->getId();
            }
            return $this->crearRelacionCursada($identificadores);
        }
        return 1;
    }

    private function crearRelacionCursada($identificadores) {
        $values = "";
        foreach ($identificadores as $idClase) {
            $values .= "({$this->asignatura}, {$this->carrera}, {$idClase}),";
        }
        $creacion = Conexion::getInstancia()->insertar("cursada", substr($values, 0, -1));
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $creacion;
    }

    public function crearRelacionPlan() {
        if ($this->asignatura && $this->carrera && $this->anio) {
            $consulta = "INSERT INTO asignatura_carrera (idasignatura, idcarrera, anio) VALUES " . $values;
        }
    }

    public function obtenerDiasCursada() {
        $consulta = "SELECT DISTINCT cl.dia FROM cursada cu INNER JOIN clase cl ON cl.idclase = cu.idclase "
                . "WHERE cu.idasignatura = {$this->asignatura} AND cu.idcarrera = {$this->carrera} ORDER BY cl.dia";
        return Conexion::getInstancia()->seleccionar($consulta);
    }

}
