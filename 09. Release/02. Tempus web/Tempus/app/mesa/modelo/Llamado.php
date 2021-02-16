<?php

namespace app\mesa\modelo;

use app\aula\modelo\Aula;
use app\principal\modelo\Conexion;
use app\principal\modelo\Log;
use app\util\modelo\Util;

/**
 * 
 * @package app\mesa\modelo.
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
class Llamado
{

    /** @var integer Identificador del llamado en la base de datos. */
    private $id;

    /** @var Aula Aula en la que se dicta la mesa de examen. */
    private $aula;

    /** @var string Estado del llamado. */
    private $estado;

    /** @var string Fecha en la que se dicta la mesa de examen. */
    private $fecha;

    /** @var string Fecha de creación del llamado. */
    private $fechaCreacion;

    /** @var string Fecha de modificacion del llamado. */
    private $fechaEdicion;

    /** @var string Hora en la que se dicta la mesa de examen. */
    private $hora;

    /**
     * Constructor de clase.
     */
    public function __construct($id = NULL, $aula = NULL, $estado = NULL, $fecha = NULL, $hora = NULL, $fechaEdicion = NULL)
    {
        $this->setId($id);
        $this->setAula($aula);
        $this->setEstado($estado);
        $this->setFecha($fecha);
        $this->setFechaEdicion($fechaEdicion);
        $this->setHora($hora);
    }

    /**
     * Retorna el identificador del llamado.
     * @return int Identificador de llamado.
     */
    public function getId()
    {
        return $this->id;
    }

    public function getAula()
    {
        return $this->aula;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function getFechaEdicion()
    {
        return $this->fechaEdicion;
    }

    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    public function getHora()
    {
        return $this->hora;
    }

    public function setId($id)
    {
        $this->id = ($id > 0) ? $id : NULL;
    }

    public function setAula($aula)
    {
        if ($aula instanceof Aula) {
            $this->aula = $aula;
        }
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    public function setFechaEdicion($fechaEdicion)
    {
        $this->fechaEdicion = $fechaEdicion;
    }

    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;
    }

    public function setHora($hora)
    {
        if (Util::validarLlamadoHora($hora)) {
            $this->hora = $hora;
        }
    }

    /**
     * ELiminar llamado. Se realiza la eliminacion del registro en la base de datos
     * y se mantiene en su estado actual el aula asociada (si tuviera).
     */
    public function borrar(): array
    {
        if ($this->id) {
            $consulta = "DELETE FROM llamado WHERE id = {$this->id}";
            return Conexion::getInstancia()->borrar($consulta);
        }
        Log::guardar("INF", "LLAMADO --> BORRAR :IDENTIFICADOR INVALIDO");
        return array(0, "No se pudo hacer referencia al llamado");
    }

    public function crear(): array
    {
        if ($this->fecha && $this->hora) {
            $idAula = $this->crearAula();
            $consulta = "INSERT INTO llamado (id, idAula, estado, fecha, fechaEdicion, hora, fechaCreacion) VALUES (NULL, {$idAula}, 'Activo', '{$this->fecha}', NULL, '{$this->hora}', NOW())";
            $resultado = Conexion::getInstancia()->insertar($consulta);
            $this->id = ($resultado[0] == 2) ? $resultado[2] : NULL;
            return $resultado;
        }
        Log::guardar("INF", "LLAMADO --> CREAR :FECHA U HORA INVALIDA");
        return array(0, "Los campos necesarios para crear el llamado no cumplen el formato requerido");
    }

    private function crearAula()
    {
        if ($this->aula) {
            if (!$this->aula->getId()) {
                $creacion = $this->aula->crear();
                return ($creacion[0] == 2) ? $this->aula->getId() : NULL;
            }
            return $this->aula->getId();
        }
        Log::guardar("INF", "LLAMADO --> CREAR AULA : OBJETO VACIO (NO OBLIGATORIO)");
        return "NULL";
    }

    /**
     * Modificar informacion del llamado. Se modifican los datos del llamado en 
     * la base de datos y se asigna la fecha actual al campo fecha modificacion.
     * @return array Arreglo de dos posiciones [codigo y mensaje].
     */
    public function modificar()
    {
        if ($this->id && $this->fecha && $this->hora && $this->estado) {
            $idAula = ($this->aula) ? $this->aula->getId() : "NULL";
            $consulta = "UPDATE llamado SET fecha = '{$this->fecha}', hora = '{$this->hora}', "
                . "idAula = {$idAula}, estado = '{$this->estado}', fechaEdicion = NOW() "
                . "WHERE id = {$this->id}";
            return Conexion::getInstancia()->modificar($consulta);
        }
        Log::guardar("INF", "LLAMADO --> MODIFICAR : CAMPOS INVALIDOS");
        return array(0, "Los campos no cumplen con el formato requerido");
    }

    /**
     * Obtener informacion del llamado a partir de su identificador. Obtiene los
     * datos del llamado y se los asigna a los atributos de clase.
     * @return array Arreglo de dos posiciones [codigo y mensaje].
     */
    public function obtenerPorIdentificador()
    {
        if ($this->id) {
            $consulta = "SELECT * FROM llamado WHERE id = {$this->id}";
            $resultado = Conexion::getInstancia()->obtener($consulta);
            if (gettype($resultado[0]) == "array") {
                $fila = $resultado[0];
                $this->id = $fila['id'];
                $this->estado = $fila['estado'];
                $this->fecha = $fila['fecha'];
                $this->hora = $fila['hora'];
                $this->fechaCreacion = $fila['fechaCreacion'];
                $this->fechaEdicion = $fila['fechaEdicion'];
                return $this->obtenerAula($fila['idAula']);
            }
            return $resultado;
        }
        Log::guardar("INF", "LLAMADO --> OBTENER POR IDENTIFICADOR :IDENTIFICADOR INVALIDO");
        return array(0, "No se pudo hacer referencia al llamado");
    }

    /**
     * Obtener aula asociada al llamado. Obtiene los datos del aula, si posee, 
     * y se asigna el objeto al atributo aula.
     * @return array Arreglo de dos posiciones [codigo y mensaje].
     */
    private function obtenerAula($idAula)
    {
        if ($idAula > 0) {
            $aula = new Aula($idAula);
            $resultado = $aula->obtenerPorIdentificador();
            $this->aula = ($resultado[0] == 2) ? $aula : NULL;
            return $resultado;
        }
        Log::guardar("INF", "LLAMADO --> OBTENER AULA :IDENTIFICADOR INVALIDO");
        return array(2, "Se obtuvo la informacion del llamado correctamente");
    }
}
