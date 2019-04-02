<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mesas
 *
 * @author Emanuel
 */
class Mesas {

    function _construct() {
        
    }

    public function crear() {
        
    }

    public function borrar() {
        Conexion::getInstancia()->setAutocommit(false);
        $mesa = Conexion::getInstancia()->executeUpdate("DELETE FROM mesa_examen");
        $llamado = Conexion::getInstancia()->executeUpdate("DELETE FROM llamado");
        $tribunal = Conexion::getInstancia()->executeUpdate("DELETE FROM tribunal");
        $docente = Conexion::getInstancia()->executeUpdate("DELETE FROM docente");
        if ($mesa && $llamado && $tribunal && $docente) {
            Conexion::getInstancia()->executeCommit();
        } else {
            Conexion::getInstancia()->rollback();
        }
    }

    public function buscar($nombreAsignatura = NULL) {
        $consulta = "SELECT me.idmesa, a.idasignatura, a.nombre, c.codigo, c.nombre carrera, me.idtribunal, me.primero, me.segundo  
            FROM mesa_examen me, asignatura a, carrera c WHERE me.idasignatura=a.idasignatura AND me.idcarrera = c.codigo ";
        if ($nombreAsignatura) {
            $consulta = $consulta . "AND a.nombre LIKE '%" . $nombreAsignatura . "%'";
        }
        $rows = Conexion::getInstancia()->executeQuery($consulta);
        if (is_null($rows)) {
            return null;
        }
        $mesas = array();
        if (!empty($rows)) {
            foreach ($rows as $fila) {
                $mesa = new Mesa();
                $plan = new Plan();
                $plan->cargar($fila['idasignatura'], $fila['nombre'],$fila['codigo'], $fila['carrera'], 1);
                $tribunal = new Tribunal($fila['idtribunal']);
                $llamados = new Llamados($fila['primero'], $fila['segundo']);
                $mesa->constructor($plan, $tribunal, $fila['idmesa'], $llamados);
                $mesas[] = $mesa;
            }
        }
        return $mesas;
    }

    public function obtenerCantidadLlamados() {
        $consulta = "SELECT COUNT(idmesa) cantidad FROM mesa_examen WHERE segundo IS NOT NULL";
        $rows = Conexion::getInstancia()->executeQuery($consulta);
        if (is_null($rows) || empty($rows)) {
            return 0;
        }
        if ($rows[0]['cantidad'] > 0) {
            return 2;
        }
        return 1;
    }
    
}
