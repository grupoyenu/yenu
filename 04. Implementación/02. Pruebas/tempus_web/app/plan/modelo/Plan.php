<?php

namespace app\plan\modelo;

use app\asignatura\modelo\Asignatura;
use app\carrera\modelo\Carrera;
use app\cursada\modelo\Cursada;
use app\principal\modelo\Conexion;
use app\principal\modelo\Log;
use app\mesa\modelo\MesaExamen;

/**
 * 
 * @package app\plan\modelo.
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
class Plan {

    /** @var int Identificador del plan. */
    private $id;

    /** @var Asignatura Asignatura relacionada al plan. */
    private $asignatura;

    /** @var Carrera Carrera a la que pertenece la asignatura. */
    private $carrera;

    /** @var array Listado de clases para la cursada. */
    private $cursada;

    /** @var MesaExamen Mesa para la asignatura dentro de la carrera. */
    private $mesa;

    /** @var int Anio en que se dicta la materia dentro de la carrera. */
    private $anio;

    /** @var string Fecha de creacion del plan. */
    private $fechaCreacion;

    public function __construct($id = NULL, $asignatura = NULL, $carrera = NULL, $cursada = NULL, $mesa = NULL, $anio = NULL, $fechaCreacion = NULL) {
        $this->setId($id);
        $this->setAsignatura($asignatura);
        $this->setCarrera($carrera);
        $this->setCursada($cursada);
        $this->setMesa($mesa);
        $this->setAnio($anio);
        $this->setFechaCreacion($fechaCreacion);
    }

    /**
     * Retorna el identificador de la cursada.
     * @return int Identificador de la cursada.
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Retorna la asignatura de la cursada.
     * @return Asignatura Asignatura de cursada.
     */
    public function getAsignatura() {
        return $this->asignatura;
    }

    /**
     * Retorna la carrera de la cursada.
     * @return Carrera Carrera de la cursada.
     */
    public function getCarrera() {
        return $this->carrera;
    }

    public function getMesa() {
        return $this->mesa;
    }

    /**
     * Retorna el anio de la cursada.
     * @return int Anio de cursada.
     */
    public function getAnio() {
        return $this->anio;
    }

    /**
     * Retorna la fecha de creacion de la cursada.
     * @return string Fecha de creacion.
     */
    public function getFechaCreacion() {
        return $this->fechaCreacion;
    }

    public function getCursada() {
        return $this->cursada;
    }

    public function setId($id) {
        $this->id = ($id > 0) ? $id : NULL;
    }

    public function setAsignatura($asignatura) {
        $this->asignatura = ($asignatura instanceof Asignatura) ? $asignatura : NULL;
    }

    public function setCarrera($carrera) {
        $this->carrera = ($carrera instanceof Carrera) ? $carrera : NULL;
    }

    public function setMesa($mesa) {
        $this->mesa = ($mesa instanceof MesaExamen) ? $mesa : NULL;
    }

    public function setAnio($anio) {
        $this->anio = $anio;
    }

    public function setFechaCreacion($fechaCreacion) {
        $this->fechaCreacion = $fechaCreacion;
    }

    public function setCursada($cursada) {
        $this->cursada = ($cursada instanceof Cursada) ? $cursada : NULL;
    }

    /**
     * Asociar la mesa de examen al plan.
     */
    public function asociarMesaExamen(): array {
        $idMesa = $this->crearMesaExamen();
        if (($idMesa) && ($idMesa != "NULL")) {
            $consulta = "UPDATE plan SET idMesaExamen = {$idMesa} WHERE id = {$this->id}";
            $resultado = Conexion::getInstancia()->modificar($consulta);
            $resultado[1] = ($resultado[0] == 2) ? "Se creó la mesa de examen correctamente" : $resultado[1];
            return $resultado;
        }
        Log::guardar("INF", "PLAN --> ASOCIAR MESA DE EXAMEN: IDENTIFICADOR INVALIDO");
        return array(1, "No se pudo asociar la mesa de examen al plan");
    }

    public function crear() {
        if ($this->asignatura && $this->carrera && $this->anio) {
            $idAsignatura = $this->crearAsignatura();
            $idCarrera = $this->crearCarrera();
            $idMesaExamen = $this->crearMesaExamen();
            $consulta = "INSERT INTO plan VALUES (NULL, {$idAsignatura}, '{$idCarrera}', {$idMesaExamen}, {$this->anio}, NOW())";
            $resultado = Conexion::getInstancia()->insertar($consulta);
            if ($resultado[0] == 2) {
                $this->id = $resultado[2];
                return $resultado;
            }
            return ($resultado[0] == 1) ? $this->obtenerPorCarreraAsignatura() : $resultado;
        }
        Log::guardar("INF", "PLAN --> CREAR :CAMPOS INVALIDOS");
        return array(0, "Los campos para crear la cursada no cumplen con el formato requerido");
    }

    /**
     * Crear asignatura nueva u obtener datos. Crea la asignatura, en caso de no 
     * existir, y retorna el identificador relacionado.
     */
    private function crearAsignatura() {
        if (!$this->asignatura->getId()) {
            $creacion = $this->asignatura->crear();
            return ($creacion[0] == 2) ? $this->asignatura->getId() : NULL;
        }
        return $this->asignatura->getId();
    }

    /**
     * Crear carrera nueva u obtener datos. Crea la carrera, en caso de no existir,
     * y retorna el identificador relacionado.
     */
    private function crearCarrera() {
        $creacion = $this->carrera->crear();
        return ($creacion[0] == 2) ? $this->carrera->getId() : NULL;
    }

    /**
     * Crear mesa de examen u obtener datos. Crear la mesa de examen, en caso de
     * no existir, y retorna el identificador relacionado o NULL.
     */
    private function crearMesaExamen() {
        if ($this->mesa) {
            if (!$this->mesa->getId()) {
                $creacion = $this->mesa->crear();
                return ($creacion[0] == 2) ? $this->mesa->getId() : NULL;
            }
            return $this->mesa->getId();
        }
        Log::guardar("INF", "PLAN --> CREAR MESA: OBJETO NULO (NO OBLIGATORIO)");
        return "NULL";
    }

    public function crearCursada() {
        if ($this->cursada) {
            $this->cursada->setPlan($this->id);
            $creacion = $this->cursada->crear();
            return $creacion;
        }
        Log::guardar("INF", "PLAN --> CREAR CURSADA: OBJETO INVALIDO");
        return array(0, "Los campos necesarios para crear la cursada no cumplen el formato requerido");
    }

    /**
     * Obtiener datos del plan por su identificador.
     */
    public function obtenerPorIdentificador() {
        if ($this->id) {
            $consulta = "SELECT * FROM plan WHERE id = {$this->id}";
            $resultado = Conexion::getInstancia()->obtener($consulta);
            if (gettype($resultado[0]) == "array") {
                $fila = $resultado[0];
                $this->id = $fila['id'];
                $this->anio = $fila['anio'];
                $this->fechaCreacion = $fila['fechaCreacion'];
                $this->mesa = (int) $fila['idMesaExamen'];
                $rasi = $this->obtenerAsignatura($fila['idAsignatura']);
                $rcar = $this->obtenerCarrera($fila['idCarrera']);
                $exito = array(2, "Se obtuvo la información del plan correctamente");
                return ($rasi == 2 && $rcar == 2) ? $exito : array(1, "No se obtuvo la información del plan");
            }
            return $resultado;
        }
        Log::guardar("INF", "PLAN --> OBTENER POR IDENTIFICADOR :IDENTIFICADOR INVALIDO");
        return array(0, "No se pudo hacer referencia al plan");
    }

    public function obtenerPorCarreraAsignatura() {
        if ($this->asignatura && $this->carrera && $this->asignatura->getId() && $this->carrera->getId()) {
            $consulta = "SELECT * FROM plan WHERE idAsignatura = {$this->asignatura->getId()} "
                    . "AND idCarrera = {$this->carrera->getId()}";
            $resultado = Conexion::getInstancia()->obtener($consulta);
            if (gettype($resultado[0]) == "array") {
                $fila = $resultado[0];
                $this->id = $fila['id'];
                $this->anio = $fila['anio'];
                $this->fechaCreacion = $fila['fechaCreacion'];
                $this->mesa = (int) $fila['idMesaExamen'];
                $rasi = $this->obtenerAsignatura($fila['idAsignatura']);
                $rcar = $this->obtenerCarrera($fila['idCarrera']);
                $exito = array(2, "Se obtuvo la información del plan correctamente");
                return ($rasi == 2 && $rcar == 2) ? $exito : array(1, "No se obtuvo la información del plan");
            }
            return $resultado;
        }
        Log::guardar("INF", "PLAN --> OBTENER POR CARRERA Y ASIGNATURA :DATOS INVALIDOS");
        return array(0, "No se pudo hacer referencia al plan");
    }

    private function obtenerAsignatura(int $idAsignatura) {
        $asignatura = new Asignatura($idAsignatura);
        $resultado = $asignatura->obtenerPorIdentificador();
        $this->asignatura = ($resultado[0] == 2) ? $asignatura : NULL;
        return $resultado[0];
    }

    private function obtenerCarrera(string $idCarrera) {
        $carrera = new Carrera($idCarrera);
        $resultado = $carrera->obtenerPorIdentificador();
        $this->carrera = ($resultado[0] == 2) ? $carrera : NULL;
        return $resultado[0];
    }

    public function obtenerCursada() {
        $cursada = new Cursada($this->id);
        $resultado = $cursada->obtenerPorIdentificador();
        $this->cursada = ($resultado[0] == 2) ? $cursada : NULL;
        return $resultado;
    }

    public function obtenerMesaExamen() {
        if (gettype($this->mesa) == "integer") {
            $mesa = new MesaExamen($this->mesa);
            $resultado = $mesa->obtenerPorIdentificador();
            $this->mesa = ($resultado[0] == 2) ? $mesa : NULL;
            return $resultado;
        }
        Log::guardar("INF", "PLAN --> OBTENER MESA DE EXAMEN : FORMATO " . gettype($this->mesa));
        return array(1, "No se pudo obtener la información de la mesa de examen");
    }

    public function quitarMesaExamen() {
        if ($this->id && $this->mesa) {
            $consulta = "UPDATE plan SET idMesaExamen = NULL WHERE id = {$this->id}";
            $resultado = Conexion::getInstancia()->modificar($consulta);
            $mensaje = ($resultado[0] == 2) ? "MESA QUITADA" : "MESA NO QUITADA";
            Log::guardar("INF", "PLAN --> {$mensaje}");
            return ($resultado[0] == 2) ? $this->mesa->borrar() : $resultado;
        }
        Log::guardar("INF", "PLAN --> QUITAR MESA DE EXAMEN: DATOS INVALIDOS");
        return array(0, "No se pudo hacer referencia a la mesa de examen del plan");
    }

}
