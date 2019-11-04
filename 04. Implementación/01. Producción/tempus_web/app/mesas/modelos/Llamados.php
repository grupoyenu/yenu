<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Llamados {

    /** @var string Descripcion sobre el resultado de alguna operacion. */
    private $descripcion;

    /**
     * Retorna la descripcion de la ultima operacion que se haya realizado.
     * @return string Descripcion de la operacion realizada.
     */
    public function getDescripcion() {
        return $this->descripcion;
    }

    /**
     * Realiza la eliminacion de todos los llamados en la base de datos. Tiene
     * como objetivo limpiar la tabla de llamados cuando se importan las nuevas
     * mesas de examen.
     * @return integer 0 cuando falla la operacion, 2 correcta.
     */
    public function borrar() {
        $consulta = "DELETE FROM llamado WHERE 1";
        $eliminacion = Conexion::getInstancia()->borrarConSubconsulta($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $eliminacion;
    }

    /**
     * Elimina de la base de datos a los llamados que no pertenecen a ninguna 
     * mesa de examen. El objetivo es quitar todos los llamados sin mesa asociada
     * cuando se realiza de la eliminacion de una mesa, dado que un llamado puede
     * estar asociado a mas de una mesa. Al quitar una mesa, solo se quita el 
     * llamado si no esta asociado a otra.
     * @return integer 0 cuando falla la operacion, 2 correcta.
     */
    public function borrarSinMesa() {
        $consulta = "DELETE LLA FROM llamado LLA JOIN (SELECT idllamado FROM llamado "
                . "WHERE idllamado NOT IN (SELECT DISTINCT primero idllamado FROM mesa_examen "
                . "WHERE primero IS NOT NULL UNION SELECT DISTINCT segundo idllamado "
                . "FROM mesa_examen WHERE segundo IS NOT NULL)) CAN ON CAN.idllamado = LLA.idllamado";
        $eliminacion = Conexion::getInstancia()->borrarConSubconsulta($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $eliminacion;
    }

    /**
     * Obtiene la cantidad de llamados que tiene el turno de mesa de examen. El
     * objetivo es conocer cuantos llamados tiene el turno que se cargo al importar
     * el archivo de mesas. Cuando existe al menos una mesa con dos llamados, se
     * devuelve 2. En caso contrario, se retorna 1.
     * @return integer 0 cuando falla la operacion, 1 o 2.
     */
    public function obtenerNumeroLlamados() {
        $consulta = "SELECT COUNT(segundo) cantidad FROM mesa_examen WHERE segundo IS NOT NULL";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        if (gettype($resultado) == "object") {
            $fila = $resultado->fetch_assoc();
            return ($fila['cantidad'] > 0) ? 2 : 1;
        }
        return 0;
    }

    /**
     * Obtiene las distintas fechas de examen que se cargaron. El objetivo es 
     * listar todas las fechas de examen para mostrar en el momento de generar el
     * informe de mesas.
     * @return integer 0 cuando falla la consulta, 1 sin resultados o 2 correcta.
     */
    public function listarFechas() {
        $consulta = "SELECT DISTINCT fecha FROM llamado ORDER BY fecha";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

}
