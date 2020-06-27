<?php

namespace app\mesa\modelo;

use app\mesa\modelo\Llamado;
use app\mesa\modelo\Tribunal;
use app\principal\modelo\Conexion;
use app\principal\modelo\Log;

/**
 * 
 * @package app\mesa\modelo.
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
class MesaExamen {

    private $id;
    private $primerLlamado;
    private $segundoLlamado;
    private $tribunal;
    private $fechaCreacion;
    private $observacion;

    public function __construct($id = NULL, $primerLlamado = NULL, $segundoLlamado = NULL, $tribunal = NULL, $fechaCreacion = NULL, $observacion = NULL) {
        $this->setId($id);
        $this->setPrimerLlamado($primerLlamado);
        $this->setSegundoLlamado($segundoLlamado);
        $this->setTribunal($tribunal);
        $this->setFechaCreacion($fechaCreacion);
        $this->setObservacion($observacion);
    }

    public function getId() {
        return $this->id;
    }

    public function getPrimerLlamado() {
        return $this->primerLlamado;
    }

    public function getSegundoLlamado() {
        return $this->segundoLlamado;
    }

    public function getTribunal() {
        return $this->tribunal;
    }

    public function getFechaCreacion() {
        return $this->fechaCreacion;
    }

    public function getObservacion() {
        return $this->observacion;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setPrimerLlamado($primerLlamado) {
        if ($primerLlamado instanceof Llamado) {
            $this->primerLlamado = $primerLlamado;
        }
    }

    public function setSegundoLlamado($segundoLlamado) {
        if ($segundoLlamado instanceof Llamado) {
            $this->segundoLlamado = $segundoLlamado;
        }
    }

    public function setTribunal($tribunal) {
        if ($tribunal instanceof Tribunal) {
            $this->tribunal = $tribunal;
        }
    }

    public function setFechaCreacion($fechaCreacion) {
        $this->fechaCreacion = $fechaCreacion;
    }

    public function setObservacion($observacion) {
        $this->observacion = ($observacion) ? $observacion : '';
    }

    public function borrar() {
        if ($this->id) {
            $consulta = "DELETE FROM mesa_examen WHERE id = {$this->id}";
            $resultado = Conexion::getInstancia()->borrar($consulta);
            if ($resultado[0] == 2) {
                $rpri = $this->borrarPrimerLlamado();
                $rseg = $this->borrarSegundoLlamado();
                $rtri = $this->tribunal->borrar();
                $exito = array(2, "Se eliminó la mesa de examen correctamente");
                $error = array(1, "No se eliminó la mesa de examen");
                return (($rpri == 2) && ($rseg == 2) && $rtri[0] == 2) ? $exito : $error;
            }
            return $resultado;
        }
        Log::guardar("INF", "MESA --> BORRAR :IDENTIFICADOR INVALIDO");
        return array(0, "No se pudo hacer referencia a la mesa de examen");
    }

    private function borrarPrimerLlamado() {
        if ($this->primerLlamado) {
            $resultado = $this->primerLlamado->borrar();
            return $resultado[0];
        }
        return 2;
    }

    private function borrarSegundoLlamado() {
        if ($this->segundoLlamado) {
            $resultado = $this->segundoLlamado->borrar();
            return $resultado[0];
        }
        return 2;
    }

    public function crear() {
        if (($this->primerLlamado || $this->segundoLlamado) && $this->tribunal) {
            $primero = $this->crearPrimerLlamado();
            $segundo = $this->crearSegundoLlamado();
            $tribunal = $this->crearTribunal();
            $consulta = "INSERT INTO mesa_examen VALUES (NULL, {$primero}, {$segundo}, {$tribunal}, NOW(), '{$this->observacion}')";
            $creacion = Conexion::getInstancia()->insertar($consulta);
            $this->id = ($creacion[0] == 2) ? $creacion[2] : NULL;
            return $creacion;
        }
        Log::guardar("INF", "MESA --> CREAR :IDENTIFICADOR INVALIDO");
        return array(0, "Los campos necesarios para crear la mesa de examen no cumple el formato requerido");
    }

    private function crearPrimerLlamado() {
        if ($this->primerLlamado) {
            if (!$this->primerLlamado->getId()) {
                $creacion = $this->primerLlamado->crear();
                return ($creacion[0] == 2) ? $this->primerLlamado->getId() : NULL;
            }
            return $this->primerLlamado->getId();
        }
        return "NULL";
    }

    private function crearSegundoLlamado() {
        if ($this->segundoLlamado) {
            if (!$this->segundoLlamado->getId()) {
                $creacion = $this->segundoLlamado->crear();
                return ($creacion[0] == 2) ? $this->segundoLlamado->getId() : NULL;
            }
            return $this->segundoLlamado->getId();
        }
        return "NULL";
    }

    private function crearTribunal() {
        if (!$this->tribunal->getId()) {
            $creacion = $this->tribunal->crear();
            return ($creacion[0] == 2) ? $this->tribunal->getId() : NULL;
        }
        return $this->tribunal->getId();
    }

    public function modificar(): array {
        if ($this->id) {
            $consulta = "UPDATE mesa_examen SET observacion = '{$this->observacion}' "
                    . "WHERE id = {$this->id}";
            $rme = Conexion::getInstancia()->modificar($consulta);
            $rpr = $this->modificarPrimerLlamado();
            $rse = $this->modificarSegundoLlamado();
            $rtr = $this->modificarTribunal();
            if (($rme[0] == 2) && ($rpr[0] == 2) && ($rse[0] == 2) && ($rtr[0] == 2)) {
                return array(2, "Se realizó la modificación de la mesa de examen correctamente");
            }
            Log::guardar("WAR", "MESA --> MODIFICAR : RESULTADOS ($rme[0]|$rpr[0]|$rse[0]|$rtr[0])");
            return array(1, "No se realizó la modificacion de la mesa de examen");
        }
        Log::guardar("ERR", "MESA --> MODIFICAR :IDENTIFICADOR INVALIDO");
        return array(0, "No se pudo hacer referencia a la mesa de examen");
    }

    private function modificarPrimerLlamado() {
        return ($this->primerLlamado) ? $this->primerLlamado->modificar() : array(2, "");
    }

    private function modificarSegundoLlamado() {
        return ($this->segundoLlamado) ? $this->segundoLlamado->modificar() : array(2, "");
    }

    private function modificarTribunal() {
        return ($this->tribunal) ? $this->tribunal->modificar() : array(2, "");
    }

    public function obtenerPorIdentificador() {
        if ($this->id) {
            $consulta = "SELECT * FROM mesa_examen WHERE id = {$this->id}";
            $resultado = Conexion::getInstancia()->obtener($consulta);
            if (gettype($resultado[0]) == "array") {
                $fila = $resultado[0];
                $this->id = $fila['id'];
                $this->fechaCreacion = $fila['fechaCreacion'];
                $this->observacion = $fila['observacion'];
                $rtri = $this->obtenerTribunal($fila['idTribunal']);
                $rpri = $this->obtenerPrimerLlamado($fila['idPrimerLlamado']);
                $rseg = $this->obtenerSegundoLlamado($fila['idSegundoLlamado']);
                $exito = array(2, "Se obtuvo la información de la mesa de examen correctamente");
                $error = array(1, "No se obtuvo la información de la mesa de examen");
                return (($rtri == 2) && ($rpri == 2) && ($rseg == 2)) ? $exito : $error;
            }
            return $resultado;
        }
        Log::guardar("INF", "MESA --> OBTENER POR IDENTIFICADOR :IDENTIFICADOR INVALIDO");
        return array(0, "No se pudo hacer referencia a la mesa de examen");
    }

    private function obtenerTribunal($idTribunal) {
        $tribunal = new Tribunal($idTribunal);
        $resultado = $tribunal->obtenerPorIdentificador();
        $this->tribunal = ($resultado[0] == 2) ? $tribunal : NULL;
        return $resultado[0];
    }

    private function obtenerPrimerLlamado($idPrimerLlamado) {
        if ($idPrimerLlamado) {
            $llamado = new Llamado($idPrimerLlamado);
            $resultado = $llamado->obtenerPorIdentificador();
            $this->primerLlamado = ($resultado[0] == 2) ? $llamado : NULL;
            return $resultado[0];
        }
        return 2;
    }

    private function obtenerSegundoLlamado($idSegundoLlamado) {
        if ($idSegundoLlamado) {
            $llamado = new Llamado($idSegundoLlamado);
            $resultado = $llamado->obtenerPorIdentificador();
            $this->segundoLlamado = ($resultado[0] == 2) ? $llamado : NULL;
            return $resultado[0];
        }
        return 2;
    }

}
