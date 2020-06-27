<?php

namespace app\docente\modelo;

use app\principal\modelo\Conexion;
use app\principal\modelo\Log;
use app\util\modelo\Util;

/**
 * 
 * @package docente.
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
class Docente {

    /** @var integer $id Identidicador del docente en la base de datos */
    private $id;

    /** @var string $nombre Nombre del docente */
    private $nombre;

    /**
     * Constructor de clase.
     */
    public function __construct($id = NULL, $nombre = NULL) {
        $this->setId($id);
        $this->setNombre($nombre);
    }

    /**
     * Retorna el identificador del docente.
     * @return int Identificador del docente.
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Retorna el nombre del docente.
     * @return string Nombre del docente.
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Modifica el identificador del docente solo si es mayor a cero.
     * @param int $id Identificador del docente.
     */
    public function setId($id) {
        $this->id = ($id > 0) ? $id : NULL;
    }

    /**
     * Modifica el nombre del docente solo si cumple con el formato requerido.
     * @param string $nombre Nombre del docente.
     */
    public function setNombre($nombre) {
        if (Util::validarDocenteNombre($nombre)) {
            $this->nombre = Util::convertirCamelCase($nombre);
        }
    }

    /**
     * Crear nuevo docente. Realiza la creacion del nuevo docente o se obtienen 
     * los datos en caso que ya exista una con el mismo nombre.
     * @return array Arreglo de dos posiciones [codigo y mensaje].
     */
    public function crear() {
        if ($this->nombre) {
            $consulta = "INSERT INTO docente VALUES (NULL, '{$this->nombre}')";
            $resultado = Conexion::getInstancia()->insertar($consulta);
            if ($resultado[0] == 2) {
                $this->id = $resultado[2];
                return $resultado;
            }
            return ($resultado[0] == 1) ? $this->obtenerPorNombre() : $resultado;
        }
        Log::guardar("INF", "DOCENTE --> CREAR :NOMBRE INVALIDO ($this->nombre)");
        return array(0, "El nombre del docente no cumple con el formato requerido");
    }

    /**
     * Obtener informacion del docente a partir de su identificador. Obtiene
     * los datos del docente y se los asigna a los atributos de clase.
     * @return array Arreglo de dos posiciones [codigo y mensaje].
     */
    public function obtenerPorIdentificador() {
        if ($this->id) {
            $consulta = "SELECT * FROM docente WHERE id = {$this->id}";
            $resultado = Conexion::getInstancia()->obtener($consulta);
            if (gettype($resultado[0]) == "array") {
                $fila = $resultado[0];
                $this->id = $fila['id'];
                $this->nombre = $fila['nombre'];
                return array(2, "Se obtuvo la información del docente correctamente");
            }
            return $resultado;
        }
        Log::guardar("INF", "DOCENTE --> OBTENER POR IDENTIFICADOR :IDENTIFICADOR INVALIDO");
        return array(0, "No se pudo hacer referencia al docente");
    }

    /**
     * Obtnener informacion del docente a partir de su nombre. Obtiene los datos 
     * del docente y se los asigna a los atributos de clase.
     * @return array Arreglo de dos posiciones [codigo y mensaje].
     */
    private function obtenerPorNombre() {
        if ($this->nombre) {
            $consulta = "SELECT * FROM docente WHERE nombre = '{$this->nombre}'";
            $resultado = Conexion::getInstancia()->obtener($consulta);
            if (gettype($resultado[0]) == "array") {
                $fila = $resultado[0];
                $this->id = $fila['id'];
                $this->nombre = $fila['nombre'];
                return array(2, "Se obtuvo la información del docente correctamente");
            }
            return $resultado;
        }
        Log::guardar("INF", "DOCENTE --> OBTENER POR NOMBRE :NOMBRE INVALIDO");
        return array(0, "No se pudo hacer referencia al docente");
    }

}
