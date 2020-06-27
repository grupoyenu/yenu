<?php

namespace app\asignatura\modelo;

use app\carrera\modelo\ColeccionCarreras as Carreras;
use app\principal\modelo\Conexion;
use app\principal\modelo\Log;
use app\util\modelo\Util;

/**
 * 
 * @package app\asignatura\modelo.
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
class Asignatura {

    /** @var string Identificador de la asignatura en la base de datos. */
    private $id;

    /** @var string Nombre abreviado de la asignatura. */
    private $nombreCorto;

    /** @var string Nombre largo de la asignatura. */
    private $nombreLargo;

    /** @var array Carreras asociadas a la asignatura. */
    private $carreras;

    /**
     * Constructor de clase. 
     */
    public function __construct($id = NULL, $nombreCorto = NULL, $nombreLargo = NULL) {
        $this->setId($id);
        $this->setNombreLargo($nombreLargo);
        $this->setNombreCorto($nombreCorto);
    }

    /**
     * Retorna el identificador de la asignatura.
     * @return int Identificador de la asignatura.
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Retorna el nombre abreviado de la asignatura.
     * @return string Nombre abreviado de la asignatura.
     */
    public function getNombreCorto() {
        return $this->nombreCorto;
    }

    /**
     * Retorna el nombre largo de la asignatura.
     * @return string Nombre largo de la asignatura.
     */
    public function getNombreLargo() {
        return $this->nombreLargo;
    }

    /**
     * Retorna las carreras asociadas a la asignatura.
     * @return array Arreglo de carreras.
     */
    public function getCarreras() {
        return $this->carreras;
    }

    /**
     * Modifica el identificador de la asignatura solo si es mayor a cero.
     * @param int $id Identificador de asignatura.
     */
    public function setId($id) {
        $this->id = ($id > 0) ? $id : NULL;
    }

    /**
     * Modifica el nombre corto de la asignatura con la inicial de cada palabra.
     * @param string $nombreCorto Nombre corto de la asignatura.
     */
    public function setNombreCorto($nombreCorto) {
        if (Util::validarAsignaturaNombre($nombreCorto)) {
            $this->nombreCorto = Util::obtenerIniciales($nombreCorto);
        }
    }

    /**
     * Modificar el nombre de la asignatura solo si cumple el formato. 
     * @param string $nombreLargo Nombre de asignatura.
     */
    public function setNombreLargo($nombreLargo) {
        if (Util::validarAsignaturaNombre($nombreLargo)) {
            $this->nombreLargo = Util::convertirCamelCase($nombreLargo);
        }
    }

    /**
     * Crear nueva asignatura. Realiza la creacion de la nueva asignatura o se
     * obtienen los datos en caso que ya exista una con el mismo nombre.
     * @return array Arreglo de dos posiciones (codigo, mensaje).
     */
    public function crear() {
        if ($this->nombreCorto && $this->nombreLargo) {
            $consulta = "INSERT INTO asignatura VALUES (NULL, '{$this->nombreCorto}', '{$this->nombreLargo}')";
            $resultado = Conexion::getInstancia()->insertar($consulta);
            if ($resultado[0] == 2) {
                $this->id = $resultado[2];
                return $resultado;
            }
            return ($resultado[0] == 1) ? $this->obtenerPorNombre() : $resultado;
        }
        Log::guardar("INF", "ASIGNATURA --> CREAR NOMBRE CORTO O LARGO INVALIDO");
        return array(1, "Los campos necesarios para crear la asignatura no cumplen con el formato requerido");
    }

    /**
     * Obtener informacion de la asignatura a partir de su identificador. Obtiene
     * los datos de la asignatura y se los asigna a los atributos de clase.
     * @return array Arreglo de dos posiciones (codigo, mensaje).
     */
    public function obtenerPorIdentificador() {
        if ($this->id) {
            $consulta = "SELECT * FROM asignatura WHERE id = {$this->id}";
            $resultado = Conexion::getInstancia()->obtener($consulta);
            if (gettype($resultado[0]) == "array") {
                $fila = $resultado[0];
                $this->id = $fila['id'];
                $this->nombreCorto = $fila['nombreCorto'];
                $this->nombreLargo = $fila['nombreLargo'];
                return array(2, "Se obtuvo la información de la asignatura correctamente");
            }
            return $resultado;
        }
        Log::guardar("INF", "ASIGNATURA --> OBTENER POR IDENTIFICADOR: IDENTIFICADOR INVALIDO");
        return array(1, "No se pudo hacer referencia a la asignatura");
    }

    /**
     * Obtnener informacion de la asignatura a partir de su nombre. Obtiene  los
     * datos de la asignatura y se los asigna a los atributos de clase.
     * @return array Arreglo de dos posiciones [codigo y mensaje].
     */
    private function obtenerPorNombre() {
        if ($this->nombreLargo) {
            $consulta = "SELECT * FROM asignatura WHERE nombreLargo = '{$this->nombreLargo}'";
            $resultado = Conexion::getInstancia()->obtener($consulta);
            if (gettype($resultado[0]) == "array") {
                $fila = $resultado[0];
                $this->id = $fila['id'];
                $this->nombreCorto = $fila['nombreCorto'];
                $this->nombreLargo = $fila['nombreLargo'];
                return array(2, "Se obtuvo la información de la asignatura correctamente");
            }
            return $resultado;
        }
        Log::guardar("INF", "ASIGNATURA --> OBTENER POR NOMBRE : NOMBRE INVALIDO");
        return array(1, "No se pudo hacer referencia a la asignatura por su nombre");
    }

    /**
     * Obtener las carreras asociadas a la asignatura. Obtiene los datos de la
     * carrera junto con el anio en que se dicta la asignatura y se asigna al 
     * atributo carreras.
     * @return array Arreglo de dos posiciones [codigo y mensaje].
     */
    public function obtenerCarreras() {
        $resultado = Carreras::listarCarrerasDeAsignatura($this->id);
        if ($resultado[0] == 2) {
            $this->carreras = $resultado[1];
            return array(2, "Se obtuvieron las carreras para la asignatura");
        }
        return $resultado;
    }

}
