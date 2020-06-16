<?php

namespace app\cursada\modelo;

use app\aula\modelo\Aula;
use app\principal\modelo\Conexion;
use app\principal\modelo\Log;
use app\util\modelo\Util;

/**
 * 
 * @package app\cursada\modelo.
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
class Clase {

    /** @var string Identificador de la clase en la base de datos. */
    private $id;

    /** @var string Aula en la que se dicta la clase. */
    private $aula;

    /** @var string Identificador del plan al que pertenece la clase. */
    private $plan;

    /** @var int Numero del dia se la semana en que se dicta la clase. */
    private $diaSemana;

    /** @var string Horario de inicio. */
    private $horaInicio;

    /** @var string Horario de fin. */
    private $horaFin;

    /** @var string Fecha de ultima modificacion realizada. */
    private $fechaEdicion;

    /**
     * Constructor de la clase.
     */
    public function __construct($id = NULL, $aula = NULL, $plan = NULL, $diaSemana = NULL, $horaInicio = NULL, $horaFin = NULL, $fechaEdicion = NULL) {
        $this->setId($id);
        $this->setAula($aula);
        $this->setPlan($plan);
        $this->setDiaSemana($diaSemana);
        $this->setHoraInicio($horaInicio);
        $this->setHoraFin($horaFin);
        $this->setFechaEdicion($fechaEdicion);
    }

    /**
     * Retorna el identificador de la clase.
     * @return int Identificador del aula.
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Retorna el aula asociada a la clase.
     * @return Aula Aula asociada a la clase.
     */
    public function getAula() {
        return $this->aula;
    }

    /**
     * Retorna el plan al que pertence la clase.
     * @return int Identificador del plan.
     */
    public function getPlan() {
        return $this->plan;
    }

    /**
     * Retorna el nombre o numero de dia de la semana.
     * @return string Dia de la semana.
     */
    public function getDiaSemana($formato = "NRO") {
        return ($formato == "NRO") ? $this->diaSemana : Util::obtenerNombreDia($this->diaSemana);
    }

    /**
     * Retorna el horario de inicio de la clase en el formato indicado.
     * @return string Horario de inicio de la clase.
     */
    public function getHoraInicio($formato = "HHMMSS") {
        return ($formato == "HHMMSS") ? $this->horaInicio : substr($this->horaInicio, 0, 5);
    }

    /**
     * Retorna el horario de finalizacion de la clase en el formato indicado.
     * @return string Horario de fin de la clase.
     */
    public function getHoraFin($formato = "HHMMSS") {
        return ($formato == "HHMMSS") ? $this->horaFin : substr($this->horaFin, 0, 5);
    }

    /**
     * Retorna la fecha de ultima modificacion para la clase.
     * @return string Fecha de ultima edicion.
     */
    public function getFechaEdicion() {
        return $this->fechaEdicion;
    }

    /**
     * Modifica el identificado de la clase.
     * @param int Identificador de la clase.
     */
    public function setId($id) {
        $this->idClase = ($id > 0) ? $id : NULL;
    }

    /**
     * Modifica el aula asociada a la clase.
     * @param Aula Aula asociada a la clase.
     */
    public function setAula($aula) {
        if ($aula instanceof Aula) {
            $this->aula = $aula;
        }
    }

    /**
     * Modifica el identificador del plan para la clase.
     * @param int $plan Identificador del plan.
     */
    public function setPlan($plan) {
        $this->plan = $plan;
    }

    /**
     * Modifica el dia en que se dicta la clase.
     * @param string $diaSemana Dia de la semana.
     */
    public function setDiaSemana($diaSemana) {
        $this->diaSemana = $diaSemana;
    }

    /**
     * Modifica el horario de inicio para la clase.
     * @param string $horaInicio Hora de inicio.
     */
    public function setHoraInicio($horaInicio) {
        $this->horaInicio = $horaInicio;
    }

    /**
     * Modifica el horario de fin para la clase.
     * @param string $horaFin Hora de fin.
     */
    public function setHoraFin($horaFin) {
        $this->horaFin = $horaFin;
    }

    /**
     * Modifica la fecha de edicion de la clase.
     * @param string $fechaEdicion Fecha de ultima modificacion.
     */
    public function setFechaEdicion($fechaEdicion) {
        $this->fechaEdicion = $fechaEdicion;
    }

    public function borrar(): array {
        if ($this->id) {
            $consulta = "DELETE FROM clase WHERE id = {$this->id}";
            return Conexion::getInstancia()->borrar($consulta);
        }
        return array(0, "No se pudo hacer referencia a la clase");
    }

    public function crear(): array {
        if ($this->diaSemana && $this->plan && $this->horaInicio && $this->horaFin && $this->aula) {
            $idAula = $this->crearAula();
            $disponibilidad = $this->verificarDisponibilidad($idAula);
            if ($disponibilidad[0] != 2) {
                return $disponibilidad;
            }
            $consulta = "INSERT INTO clase VALUES (NULL, {$idAula}, {$this->plan}, {$this->diaSemana}, '{$this->horaInicio}', '{$this->horaFin}', NULL)";
            $resultado = Conexion::getInstancia()->insertar($consulta);
            if ($resultado[0] == 2) {
                $this->id = $resultado[2];
                Log::guardar("INFO", "CLASE --> NUEVA ({$this->id}, {$this->plan}, {$this->diaSemana}, '{$this->horaInicio}', '$this->horaFin)");
            }
            return $resultado;
        }
        return array(0, "Los campos necesarios para crear la clase no cumplen con el formato requerido");
    }

    /**
     * Crear u obtener aula. Si el aula no tiene identificador se realiza la creación
     * del aula y se obtienen los datos corresponientes. En caso contrario, solo
     * se retorna el id del aula.
     * @return int Identificador del aula.
     */
    private function crearAula() {
        if (!$this->aula->getId()) {
            $creacion = $this->aula->crear();
            return ($creacion[0] == 2) ? $this->aula->getId() : NULL;
        }
        return $this->aula->getId();
    }

    /**
     * Verificar la disponibilidad del aula para asignar la clase. El aula se considera
     * disponible cuando la clase coincide en horario con otra clase pero no cuando
     * inicia o termina durante la franja horaria de otra clase.
     * @return array Arreglo de dos posiciones (codigo, mensaje).
     */
    private function verificarDisponibilidad($idAula): array {
        if ($idAula) {
            $consulta = "SELECT idAula FROM clase WHERE idAula = {$idAula} AND "
                    . "diaSemana = {$this->diaSemana} AND "
                    . "((horaInicio >= '{$this->horaInicio}' AND horaFin < '{$this->horaFin}') OR "
                    . "(horaFin > '{$this->horaInicio}' AND horaFin < '{$this->horaFin}') OR "
                    . "(horaInicio > '{$this->horaInicio}' AND horaInicio < '{$this->horaFin}'))";
            $resultado = Conexion::getInstancia()->obtener($consulta);
            if ($resultado[0] == 1) {
                return array(2, "Aula disponible");
            }
            return ($resultado[0] == 0) ? $resultado : array(1, "El aula seleccionada está ocupada por otra clase");
        }
        return array(0, "No se pudo hacer referencia al aula de clase");
    }

    public function modificar(): array {
        if ($this->idClase && $this->horaInicio && $this->horaFin && $this->aula) {
            $idAula = $this->aula->getId();
            $consulta = "UPDATE clase SET "
                    . " horaInicio = '{$this->horaInicio}',"
                    . " horaFin = '{$this->horaFin}', "
                    . " idAula = {$idAula}, "
                    . " fechaEdicion = NOW() WHERE id = {$this->idClase}";
            return Conexion::getInstancia()->modificar($consulta);
        }
        return array(0, "Los campos necesarios para modificar la clase no cumplen con el formato requerido");
    }

    public function obtenerPorIdentificador(): array {
        if ($this->idClase) {
            $consulta = "SELECT * FROM clase WHERE id = {$this->idClase}";
            $resultado = Conexion::getInstancia()->obtener($consulta);
            if (gettype($resultado[0]) == "array") {
                $fila = $resultado[0];
                $this->id = $fila['id'];
                $this->diaSemana = $fila['diaSemana'];
                $this->horaInicio = $fila['horaInicio'];
                $this->horaFin = $fila['horaFin'];
                $this->fechaEdicion = $fila['fechaEdicion'];
                return $this->obtenerAula($fila['idAula']);
            }
            return $resultado;
        }
        return array(0, "No se pudo hacer referencia a la clase");
    }

    private function obtenerAula($idAula): array {
        $this->aula = NULL;
        $aula = new Aula($idAula);
        $resultado = $aula->obtenerPorIdentificador();
        if ($resultado[0] == 2) {
            $this->aula = $aula;
            $resultado[1] = "Se obtuvo la información de la clase correctamente";
        }
        return $resultado;
    }

}
