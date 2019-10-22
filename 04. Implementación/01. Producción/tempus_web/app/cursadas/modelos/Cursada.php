<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cursada
 *
 * @author Emanuel
 */
class Cursada {

    private $asignatura;
    private $carrera;
    private $clases;
    private $descripcion;

    public function __construct($asignatura = NULL, $carrera = NULL, $clases = NULL) {
        $this->setAsignatura($asignatura);
        $this->setCarrera($carrera);
        $this->setClases($clases);
    }

    public function getAsignatura() {
        return $this->asignatura;
    }

    public function getCarrera() {
        return $this->carrera;
    }

    public function getClases() {
        return $this->clases;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setAsignatura($asignatura) {
        $this->asignatura = $asignatura;
        $this->descripcion = ($asignatura) ? "No se pudo hacer referencia a la asignatura" : $this->descripcion;
    }

    public function setCarrera($carrera) {
        $this->carrera = $carrera;
        $this->descripcion = ($carrera) ? "No se pudo hacer referencia a la carrera" : $this->descripcion;
    }

    public function setClases($clases) {
        $this->clases = $clases;
        $this->descripcion = empty($clases) ? "No se recibieron clases" : $this->descripcion;
    }

    public function crear() {
        if ($this->asignatura && $this->carrera && $this->clases) {
            $claves = array();
            foreach ($this->clases as $clase) {
                $resultado = $clase->crear();
                if ($resultado != 2) {
                    $this->descripcion = "No se pudo realizar la creación de la clase";
                    return $resultado;
                }
                $claves[] = $resultado;
            }
            return $this->crearCursada($claves);
        }
        return 0;
    }

    private function crearCursada($claves) {
        $values = "";
        foreach ($claves as $idclase) {
            $values .= "({$this->asignatura}, {$this->carrera}, {$idclase}),";
        }
        $creacion = Conexion::getInstancia()->insertar("cursada", substr($values, 0, -1));
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $creacion;
    }

    public function obtener() {
        if ($this->asignatura && $this->carrera) {
            $consulta = "SELECT * FROM vista_cursadas WHERE idCarrera = {$this->carrera} AND idAsignatura = {$this->asignatura}";
            $fila = Conexion::getInstancia()->obtener($consulta);
            if (gettype($fila) == "array") {
                return $fila;
            }
            $this->descripcion = "No se obtuvo la información de la cursada";
            return 1;
        }
        return 0;
    }

}
