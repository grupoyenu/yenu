<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorLlamados {

    /** @var string Descripcion sobre alguna de las operaciones que se realiza. */
    private $descripcion;

    /**
     * Retorna la descripcion que se ha cargado luego de realizar alguna de las 
     * operaciones de la clase.
     * @return string Descripcion de la ultima operacion realizada.
     */
    public function getDescripcion() {
        return $this->descripcion;
    }

    /**
     * Realiza la modificacion de un determinado llamado en la base de datos.
     * @param integer $id Identificador del registro en la base de datos.
     * @param string $fecha Fecha del llamado.
     * @param string $hora Hora del llamado en formato HH:MM.
     * @param integer $aula Identificador del registro de aula en la base de datos.
     * @return integer 0 para error, 1 para advertencia o 2 para exito.
     */
    public function modificar($id, $fecha, $hora, $aula) {
        $llamado = new Llamado($id, $fecha, $hora, $aula);
        $modificacion = $llamado->modificar();
        $this->descripcion = $llamado->getDescripcion();
        return $modificacion;
    }

    /**
     * Realiza la eliminacion de un determinado llamado en la base de datos.
     * @param integer $id Identificador del registro en la base de datos.
     * @return integer 0 para error, 1 para advertencia o 2 para exito.
     */
    public function borrar($id) {
        $llamado = new Llamado($id);
        $eliminacion = $llamado->borrar();
        $this->descripcion = $llamado->getDescripcion();
        return $eliminacion;
    }

    /**
     * Realiza la busqueda de todas las distintas fechas que se encuentran cargadas
     * en la base de datos. Permite cargar aquellos elementos que requieran de
     * seleccionar las fechas para mesas de examen.
     * @return Retorna un recurso de mysqli o un integer (0 error o 1 advertencia).
     */
    public function listarFechas() {
        $llamados = new Llamados();
        $resultado = $llamados->listarFechas();
        $this->descripcion = $llamados->getDescripcion();
        return $resultado;
    }

}
