<?php

namespace app\carrera\modelo;

use app\asignatura\modelo\ColeccionAsignaturas as Asignaturas;
use app\principal\modelo\Conexion;
use app\principal\modelo\Log;
use app\util\modelo\Util;

/**
 * 
 * @package app\carrera\modelo.
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
class Carrera
{

    /** @var string $id Codigo de la carrera. */
    private $id;

    /** @var string $nombre Nombre abreviado de la carrera. */
    private $nombreCorto;

    /** @var string $nombre Nombre largo de la carrera. */
    private $nombreLargo;

    /** @var string Fecha de creación del registro. */
    private $fechaCreacion;

    /** @var array $asignaturas Arreglo de las asignaturas de la carrera */
    private $asignaturas;

    /**
     * Constructor de clase.
     */
    public function __construct($id = NULL, $nombreCorto = NULL, $nombreLargo = NULL)
    {
        $this->setId($id);
        $this->setNombreLargo($nombreLargo);
        $this->setNombreCorto($nombreCorto);
    }

    /**
     * Retorna el codigo de la carrera.
     * @return string Codigo de la carrera.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Retorna el nombre abreviado de la carrera.
     * @return string Nombre de la carrera.
     */
    public function getNombreCorto()
    {
        return $this->nombreCorto;
    }

    /**
     * Retorna el nombre largo de la carrera.
     * @return string Nombre de la carrera.
     */
    public function getNombreLargo()
    {
        return $this->nombreLargo;
    }

    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * Retorna las asignaturas de la carrera.
     * @return array Arreglo de asignaturas asocidadas a la carrera.
     */
    public function getAsignaturas()
    {
        return $this->asignaturas;
    }

    /**
     * Modifica el identificador de la carrera solo si cumple el formato.
     * @param string Identificador de la carrera.
     */
    public function setId($id)
    {
        if (Util::validarCarreraCodigo($id)) {
            $this->id = $id;
        }
    }

    /**
     * Modifica el nombre corto de la carrera con la inicial de cada palabra.
     * @param string $nombreCorto Nombre corto de la asignatura.
     */
    public function setNombreCorto($nombreCorto)
    {
        if (Util::validarCarreraNombre($nombreCorto)) {
            $this->nombreCorto = Util::obtenerIniciales($nombreCorto);
        }
    }

    /**
     * Modificar el nombre de la carrera solo si cumple el formato. 
     * @param string $nombreLargo Nombre de carrera.
     */
    public function setNombreLargo($nombreLargo)
    {
        if (Util::validarCarreraNombre($nombreLargo)) {
            $this->nombreLargo = Util::convertirCamelCase($nombreLargo);
        }
    }

    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;
    }

    /**
     * Crear nueva carrera. Realiza la creacion de la nueva carrera o se obtienen
     * los datos en caso que ya exista una con el mismo codigo o nombre. Ademas, 
     * se realiza la creacion de las asignaturas asociadas, en caso de tener, junto
     * con las relaciones entre la asignatura y la carrera.
     * @return array Arreglo de dos posiciones [codigo y mensaje].
     */
    public function crear()
    {
        if ($this->id && $this->nombreCorto && $this->nombreLargo) {
            $consulta = "INSERT INTO carrera (id, nombreCorto, nombreLargo, fechaCreacion) VALUES ({$this->id}, '{$this->nombreCorto}', '{$this->nombreLargo}', NOW())";
            $resultado = Conexion::getInstancia()->insertar($consulta);
            if ($resultado[0] == 2) {
                return $resultado;
            }
            return ($resultado[0] == 1) ? $this->obtenerPorDatos() : $resultado;
        }
        Log::guardar("INF", "CARRERA --> CREAR :CAMPOS INVALIDOS");
        return array(0, "Los campos no cumplen con el formato requerido");
    }

    /**
     * Obtener informacion de la carrera a partir de su identificador. Obtiene
     * los datos de la carrera y se los asigna a los atributos de clase.
     * @return array Arreglo de dos posiciones [codigo y mensaje].
     */
    public function obtenerPorIdentificador()
    {
        if ($this->id) {
            $consulta = "SELECT * FROM carrera WHERE id = {$this->id}";
            $resultado = Conexion::getInstancia()->obtener($consulta);
            if (gettype($resultado[0]) == "array") {
                $fila = $resultado[0];
                $this->id = $fila['id'];
                $this->nombreCorto = $fila['nombreCorto'];
                $this->nombreLargo = $fila['nombreLargo'];
                $this->fechaCreacion = $fila['fechaCreacion'];
                return array(2, "Se obtuvo la información de la carrera correctamente");
            }
            return $resultado;
        }
        Log::guardar("INF", "CARRERA --> OBTENER POR IDENTIFICADOR :CODIGO INVALIDO");
        return array(0, "No se pudo hacer referencia a la carrera");
    }

    /**
     * Obtener los datos de la carrera por su codigo o nombre. Obtiene el codigo
     * de la carrera o su nombre cuando cualquiera de los dos coincida con alguna
     * existente.
     * @return array Arreglo de dos posiciones [codigo y mensaje].
     */
    private function obtenerPorDatos()
    {
        $consulta = "SELECT * FROM carrera WHERE id = {$this->id} OR nombreLargo = '{$this->nombreLargo}'";
        $resultado = Conexion::getInstancia()->obtener($consulta);
        if (gettype($resultado[0]) == "array") {
            $fila = $resultado[0];
            $this->id = $fila['id'];
            $this->nombreCorto = $fila['nombreCorto'];
            $this->nombreLargo = $fila['nombreLargo'];
            $this->fechaCreacion = $fila['fechaCreacion'];
            return array(2, "Se obtuvo la información de la carrera correctamente");
        }
        Log::guardar("INF", "CARRERA --> OBTENER POR DATOS :CODIGO O NOMBRE INVALIDO");
        return $resultado;
    }

    /**
     * Obtener el listado de asignaturas asociadas a la carrera. Obtiene los datos 
     * de la asignatura junto con el anio en que se dicta la misma y se asigna al 
     * atributo asignaturas.
     * @return array Arreglo de dos posiciones [codigo y mensaje].
     */
    public function obtenerAsignaturas()
    {
        $resultado = Asignaturas::listarAsignaturasDeCarrera($this->id);
        if ($resultado[0] == 2) {
            $this->asignaturas = $resultado[1];
            return array(2, "Se obtuvieron las asignaturas de la carrera");
        }
        return $resultado;
    }
}
