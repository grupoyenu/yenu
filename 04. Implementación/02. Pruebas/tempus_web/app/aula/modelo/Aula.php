<?php

namespace app\aula\modelo;

use app\mesa\modelo\ColeccionMesasExamen as Mesas;
use app\cursada\modelo\ColeccionClases as Clases;
use app\principal\modelo\Conexion;
use app\principal\modelo\Log;
use app\util\modelo\Util;

/**
 * 
 * @package app\aula\modelo.
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
class Aula {

    /** @var integer Identificador del aula en la base de datos. */
    private $id;

    /** @var string Nombre del aula. */
    private $nombre;

    /** @var string Sector donde se ubica el aula. */
    private $sector;
    private $clases;
    private $mesas;

    public function __construct($id = NULL, $nombre = NULL, $sector = NULL) {
        $this->setId($id);
        $this->setNombre($nombre);
        $this->setSector($sector);
    }

    /**
     * Retorna el identificador del aula.
     * @return int Identificador del aula.
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Retorna el nombre del aula.
     * @return string Nombre del aula.
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Retorna el nombre del sector donde se encuentra el aula.
     * @return string Nombre del sector.
     */
    public function getSector() {
        return $this->sector;
    }

    public function getClases() {
        return $this->clases;
    }

    public function getMesas() {
        return $this->mesas;
    }

    /**
     * Modificar el identificador del aula solo si es mayor que cero.
     * @param int $id Identificador del aula.
     */
    public function setId($id) {
        $this->id = ($id > 0) ? $id : NULL;
    }

    /**
     * Modificar el nombre del aula solo si cumple el formato. 
     * @param string $nombre Nombre de aula.
     */
    public function setNombre($nombre) {
        if (Util::validarAulaNombre($nombre)) {
            $this->nombre = Util::convertirCamelCase($nombre);
        }
    }

    /**
     * Modificar el nombre del sector solo si cumple el formato. 
     * @param string $sector Nombre del sector.
     */
    public function setSector($sector) {
        if (Util::validarAulaSector($sector)) {
            $this->sector = Util::convertirCamelCase($sector);
        }
    }

    public function setClases($clases) {
        $this->clases = $clases;
    }

    public function setMesas($mesas) {
        $this->mesas = $mesas;
    }

    /**
     * Borrar aula. Se realiza la eliminacion del aula a partir de su identificador.
     * @return array Arreglo de dos posiciones (codigo, mensaje).
     */
    public function borrar() {
        if ($this->id) {
            $consulta = "DELETE FROM aula WHERE id = {$this->id}";
            $resultado = Conexion::getInstancia()->borrar($consulta);
            return $resultado;
        }
        Log::guardar("INF", "AULA --> BORRAR :IDENTIFICADOR INVALIDO");
        return array(0, "No se pudo hacer referencia al aula");
    }

    /**
     * Crear nueva aula. Realiza la creacion de la nueva aula o se obtienen los 
     * datos en caso que ya exista una con el mismo nombre.
     * @return array Arreglo de dos posiciones (codigo, mensaje).
     */
    public function crear() {
        if ($this->nombre && $this->sector) {
            $consulta = "INSERT INTO aula VALUES (NULL, '{$this->nombre}', '{$this->sector}')";
            $resultado = Conexion::getInstancia()->insertar($consulta);
            if ($resultado[0] == 2) {
                $this->id = $resultado[2];
                return $resultado;
            }
            return ($resultado[0] == 1) ? $this->obtenerPorDatos() : $resultado;
        }
        Log::guardar("INF", "AULA --> CREAR :NOMBRE O SECTOR INVALIDO ($this->nombre, $this->sector)");
        return array(0, "Los campos recibidos para crear el aula no cumplen con el formato requerido");
    }

    /**
     * Modificar aula. Realiza la modificacion de un aula a partir de su identificador.
     * Los datos que se actualizan son el nombre y sector.
     */
    public function modificar() {
        if ($this->id && $this->nombre && $this->sector) {
            $consulta = "UPDATE aula SET nombre='{$this->nombre}', sector='{$this->sector}' WHERE id = {$this->id}";
            return Conexion::getInstancia()->modificar($consulta);
        }
        Log::guardar("INF", "AULA --> MODIFICAR :CAMPOS INVALIDOS");
        return array(0, "Los campos recibidos para modificar el aula no cumplen con el formato requerido");
    }

    /**
     * Obtener informacion del aula a partir de su identificador. Obtiene
     * los datos del aula y se los asigna a los atributos de clase.
     * @return array Arreglo de dos posiciones (codigo, mensaje).
     */
    public function obtenerPorIdentificador() {
        if ($this->id) {
            $consulta = "SELECT * FROM aula WHERE id = {$this->id}";
            $resultado = Conexion::getInstancia()->obtener($consulta);
            if (gettype($resultado[0]) == "array") {
                $fila = $resultado[0];
                $this->id = $fila['id'];
                $this->nombre = $fila['nombre'];
                $this->sector = $fila['sector'];
                return array(2, "Se obtuvo la informacion del aula correctamente");
            }
            return $resultado;
        }
        Log::guardar("INF", "AULA --> OBTENER POR IDENTIFICADOR :IDENTIFICADOR INVALIDO");
        return array(0, "No se pudo hacer referencia al aula");
    }

    /**
     * Obtener informacion del aula a partir de su sector y nombre. Obtiene los
     * datos del aula y se los asigna a los atributos de clase.
     * @return array Arreglo de dos posiciones (codigo, mensaje).
     */
    private function obtenerPorDatos() {
        if ($this->nombre && $this->sector) {
            $consulta = "SELECT * FROM aula WHERE nombre='{$this->nombre}' AND sector='{$this->sector}'";
            $resultado = Conexion::getInstancia()->obtener($consulta);
            if (gettype($resultado[0]) == "array") {
                $fila = $resultado[0];
                $this->id = $fila['id'];
                $this->nombre = $fila['nombre'];
                $this->sector = $fila['sector'];
                return array(2, "Se obtuvo la información del aula correctamente");
            }
            return $resultado;
        }
        Log::guardar("INF", "AULA --> OBTENER POR DATOS :NOMBRE O SECTOR INVALIDO");
        return array(0, "No se pudo hacer referencia al aula por su nombre y sector");
    }

    public function obtenerClases() {
        if ($this->id) {
            $resultado = Clases::listarClasesAula($this->id);
            $this->clases = ($resultado[0] == 2) ? $resultado[1] : NULL;
            return $resultado;
        }
        return array(0, "No se pudo hacer referencia al aula");
    }

    public function obtenerMesasExamen() {
        if ($this->id) {
            $resultado = Mesas::listarMesasDeAula($this->id);
            $this->mesas = ($resultado[0] == 2) ? $resultado[1] : NULL;
            return $resultado;
        }
        return array(0, "No se pudo hacer referencia al aula");
    }

}
