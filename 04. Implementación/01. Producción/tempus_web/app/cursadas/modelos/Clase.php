<?php

class Clase {

    private $idClase;
    private $dia;
    private $horaInicio;
    private $horaFin;
    private $aula;
    private $fechaModificacion;
    private $descripcion;
    private $TABLA = "clase";

    public function __construct($parametros = NULL) {
        $idClase = ($parametros) ? $parametros[0] : NULL;
        $dia = ($parametros) ? $parametros[1] : NULL;
        $horaInicio = ($parametros) ? $parametros[2] : NULL;
        $horaFin = ($parametros) ? $parametros[3] : NULL;
        $aula = ($parametros) ? $parametros[4] : NULL;
        $fechaModificacion = ($parametros) ? $parametros[5] : NULL;
        $this->setId($idClase);
        $this->setDia($dia);
        $this->setHoraInicio($horaInicio);
        $this->setHoraFin($horaFin);
        $this->setAula($aula);
        $this->setFechaModificacion($fechaModificacion);
    }

    public function getId() {
        return $this->idClase;
    }

    public function getDia() {
        return $this->dia;
    }

    public function getHoraInicio() {
        return $this->horaInicio;
    }

    public function getHoraFin() {
        return $this->horaFin;
    }

    public function getAula() {
        return $this->aula;
    }

    public function getFechaModificacion() {
        return $this->fechaModificacion;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setId($idClase) {
        $this->idClase = $idClase;
    }

    public function setDia($dia) {
        if (preg_match("/^[1-6]$/", $dia)) {
            $this->dia = $dia;
        } else {
            $this->descripcion = "El día no cumple con el formato requerido";
        }
    }

    public function setHoraInicio($horaInicio) {
        if (preg_match("/^(1[0-9]|2[0-3]):[0-5][0-9]$/", $horaInicio)) {
            $this->horaInicio = $horaInicio;
        } else {
            $this->descripcion = "La hora de inicio no cumple con el formato requerido";
        }
    }

    public function setHoraFin($horaFin) {
        if (preg_match("/^(1[0-9]|2[0-3]):[0-5][0-9]$/", $horaFin)) {
            $this->horaFin = $horaFin;
        } else {
            $this->descripcion = "La hora de fin no cumple con el formato requerido";
        }
    }

    public function setAula($aula) {
        if ($aula) {
            $this->aula = $aula;
        } else {
            $this->descripcion = "No se pudo hacer referencia al aula";
        }
    }

    public function setFechaModificacion($fechaModificacion) {
        $this->fechaModificacion = $fechaModificacion;
    }

    public function borrar() {
        if ($this->idClase) {
            $condicion = "idclase = {$this->idClase}";
            $eliminacion = Conexion::getInstancia()->borrar($this->TABLA, $condicion);
            $this->descripcion = Conexion::getInstancia()->getDescripcion();
            return $eliminacion;
        }
        return 1;
    }

    public function crear() {
        if ($this->dia && $this->horaInicio && $this->horaFin && $this->aula) {
            if (!$this->validarHorario() || $this->evaluarSolapamiento()) {
                return 1;
            }
            if ($this->evaluarExistencia() == 2) {
                $this->descripcion = "La clase indicada ya existe";
                return 2;
            }
            $values = "(NULL, {$this->dia}, '{$this->horaInicio}', '{$this->horaFin}', {$this->aula}, NULL)";
            $creacion = Conexion::getInstancia()->insertar($this->TABLA, $values);
            $this->idClase = ($creacion == 2) ? (Int) Conexion::getInstancia()->insert_id : NULL;
            $this->descripcion = Conexion::getInstancia()->getDescripcion();
            return $creacion;
        }
        return 1;
    }

    public function modificar() {
        if ($this->idClase && $this->horaInicio && $this->horaFin && $this->aula) {
            $campos = "desde='{$this->horaInicio}', hasta='{$this->horaFin}', idaula={$this->aula}, fechamod=NOW()";
            $condicion = "idclase={$this->idClase}";
            $modificacion = Conexion::getInstancia()->modificar($this->TABLA, $campos, $condicion);
            $this->descripcion = Conexion::getInstancia()->getDescripcion();
            return $modificacion;
        }
        return 1;
    }

    private function evaluarExistencia() {
        $consulta = "SELECT idclase FROM {$this->TABLA} WHERE dia ={$this->dia} AND desde = '{$this->horaInicio}' AND hasta = '{$this->horaFin}' AND idaula={$this->aula}";
        $fila = Conexion::getInstancia()->obtener($consulta);
        if (!is_null($fila)) {
            $this->idClase = $fila['idclase'];
            return 2;
        }
        return 1;
    }

    private function evaluarSolapamiento() {
        $consulta = "SELECT idclase FROM {$this->TABLA} "
                . "WHERE dia={$this->dia} AND idaula={$this->aula} "
                . "AND ((desde > '{$this->horaInicio}' AND desde < '{$this->horaFin}') "
                . "OR (hasta > '{$this->horaInicio}' AND hasta < '{$this->horaFin}'))";
        $evaluacion = Conexion::getInstancia()->evaluar($consulta);
        if ($evaluacion != 1) {
            $this->descripcion = ($evaluacion == 2) ? "El horario indicado se solapa con una clase existente" : Conexion::getInstancia()->getDescripcion();
            return true;
        }
        return false;
    }

    private function validarHorario() {
        $inicio = substr($this->horaInicio, 0, 2);
        $fin = substr($this->horaFin, 0, 2);
        if ($inicio < $fin) {
            return true;
        }
        if ($inicio == $fin) {
            $minutosInicio = substr($this->horaInicio, 3, 2);
            $minutosFin = substr($this->horaFin, 3, 2);
            $this->descripcion = ($minutosInicio < $minutosFin) ? "" : "La hora de fin debe ser posterior a la hora de inicio";
            return ($minutosInicio < $minutosFin) ? true : false;
        }
        return false;
    }

}
