<?php

namespace app\mesa\modelo;

use app\docente\modelo\Docente;
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
class Tribunal {

    /** @var int Identificador del tribunal */
    private $id;

    /** @var array Docentes que componen el tribunal */
    private $docentes;

    /**
     * Constructor de clase
     */
    public function __construct($id = NULL) {
        $this->setId($id);
        $this->docentes = array();
    }

    /**
     * Retorna el identificador del tribunal.
     * @return int Identificador del tribunal.
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Retorna los docentes que componen el tribunal.
     * @return array Docentes del tribunal.
     */
    public function getDocentes() {
        return $this->docentes;
    }

    /**
     * Modifica el identificador del tribunal solo si es mayor que cero.
     * @param int $id Identificador del tribunal.
     */
    public function setId($id) {
        $this->id = ($id > 0) ? $id : NULL;
    }

    /**
     * Agrega un docente al tribunal en la primer posicion disponible solo si no
     * se duplica.
     * @param Docente $docente Docente a agregar.
     * @return boolean True si se agrega o false en caso contrario.
     */
    public function agregarDocente($docente): bool {
        $cantidad = count($this->docentes);
        if (($cantidad < 4) && ($docente instanceof Docente)) {
            if ($this->verificar($docente->getNombre())) {
                $this->docentes[] = $docente;
                return true;
            }
        }
        return false;
    }

    /**
     * Eliminar tribunal. Se realiza la eliminacion del registro en la base de
     * datos y se mantienen en su estado actual los docentes que lo integran. 
     */
    public function borrar(): array {
        if ($this->id) {
            $consulta = "DELETE FROM tribunal WHERE id = {$this->id}";
            return Conexion::getInstancia()->borrar($consulta);
        }
        Log::guardar("INF", "TRIBUNAL --> BORRAR :IDENTIFICADOR INVALIDO");
        return array(0, "No se pudo hacer referencia al tribunal");
    }

    public function crear(): array {
        if (count($this->docentes) >= 2) {
            $valores = $this->crearDocentes();
            if (!$valores) {
                Log::guardar("INF", "TRIBUNAL --> CREAR : NO SE CREARON LOS DOCENTES");
                return array(0, "No se pudo crear el tribunal por un problema al asociar docentes");
            }
            $values = substr($valores, 0, -1);
            $consulta = "INSERT INTO tribunal VALUES (NULL, {$values})";
            $resultado = Conexion::getInstancia()->insertar($consulta);
            if ($resultado[0] == 2) {
                $this->id = $resultado[2];
                return $resultado;
            }
            return $resultado;
        }
        Log::guardar("INF", "TRIBUNAL --> CREAR : CANTIDAD DE DOCENTES INVALIDA");
        return array(0, "Los campos recibidos para crear el tribunal no cumplen con el formato requerido");
    }

    private function crearDocentes() {
        $resultado = NULL;
        for ($index = 0; $index < 4; $index++) {
            $docente = isset($this->docentes[$index]) ? $this->docentes[$index] : NULL;
            if ($docente) {
                $crea = $docente->crear();
                $resultado .= ($crea[0] == 2) ? $docente->getId() . "," : 'NULL,';
            } else {
                $resultado .= 'NULL,';
            }
        }
        return $resultado;
    }

    public function modificar() {
        if ($this->id) {
            if (count($this->docentes) >= 2) {
                $presidente = $this->docentes[0];
                $vocal1 = $this->docentes[1];
                $vocal2 = isset($this->docentes[2]) ? $this->docentes[2] : NULL;
                $suplente = isset($this->docentes[3]) ? $this->docentes[3] : NULL;
                $idPresidente = $presidente->getId();
                $idVocal1 = $vocal1->getId();
                $idVocal2 = ($vocal2) ? $vocal2->getId() : "NULL";
                $idSuplente = ($suplente) ? $suplente->getId() : "NULL";
                $consulta = "UPDATE tribunal SET idPresidente = {$idPresidente},"
                        . " idVocal1 = {$idVocal1}, idVocal2 = {$idVocal2},"
                        . " idSuplente = {$idSuplente} WHERE id = {$this->id}";
                return Conexion::getInstancia()->modificar($consulta);
            }
            Log::guardar("INF", "TRIBUNAL --> MODIFICAR :CANTIDAD DOCENTES INVALIDA");
            return array(1, "Los campos recibidos para modificar el tribunal no cumplen con el formato requerido");
        }
        Log::guardar("INF", "TRIBUNAL --> MODIFICAR :IDENTIFICADOR INVALIDO");
        return array(0, "No se pudo hacer referencia al tribunal");
    }

    public function obtenerPorIdentificador() {
        if ($this->id) {
            $consulta = "SELECT * FROM tribunal WHERE id = {$this->id}";
            $resultado = Conexion::getInstancia()->obtener($consulta);
            if (gettype($resultado[0]) == "array") {
                $fila = $resultado[0];
                $this->id = $fila['id'];
                $rpre = $this->obtenerDocente(TRUE, 0, $fila['idPresidente']);
                $rvop = $this->obtenerDocente(TRUE, 1, $fila['idVocal1']);
                $rvos = $this->obtenerDocente(FALSE, 2, $fila['idVocal2']);
                $rsup = $this->obtenerDocente(FALSE, 3, $fila['idSuplente']);
                $exito = array(2, "Se obtuvo la información del tribunal correctamente");
                $error = array(2, "No obtuvo la información del tribunal");
                return (($rpre == 2) && ($rvop == 2) && ($rvos == 2) && ($rsup == 2)) ? $exito : $error;
            }
            return $resultado;
        }
        Log::guardar("INF", "TRIBUNAL --> OBTENER POR IDENTIFICADOR :IDENTIFICADOR INVALIDO");
        return array(0, "No se pudo hacer referencia al tribunal");
    }

    private function obtenerDocente($obligatorio, $orden, $idDocente) {
        if ($idDocente > 0) {
            $docente = new Docente($idDocente);
            $resultado = $docente->obtenerPorIdentificador();
            $this->docentes[$orden] = ($resultado[0] == 2) ? $docente : NULL;
            return $resultado[0];
        }
        Log::guardar("INF", "TRIBUNAL --> OBTENER DOCENTE: IDENTIFICADOR INVALIDO (CARACTER)");
        return ($obligatorio) ? 1 : 2;
    }

    private function verificar($nombre) {
        $cantidad = count($this->docentes);
        $contador = 0;
        while ($contador < $cantidad) {
            $docente = $this->docentes[$contador];
            if ($nombre == $docente->getNombre()) {
                return false;
            }
            $contador++;
        }
        return true;
    }

}
