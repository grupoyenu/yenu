<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Cursadas {

    private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function buscar($campo, $valor) {
        if ($campo) {
            $consulta = "SELECT * FROM vista_cursadas WHERE {$campo} LIKE '%{$valor}%'";
            $resultado = Conexion::getInstancia()->seleccionar($consulta);
            $this->descripcion = Conexion::getInstancia()->getDescripcion();
            return $resultado;
        }
        $this->descripcion = "El campo es obligatorio";
        return 0;
    }

    public function listarUltimasCreadas() {
        $consulta = "SELECT * FROM vista_cursadas ORDER BY idAsignatura DESC LIMIT 10";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

    public function listarResumenInicial() {
        $consulta = "SELECT 'Total de cursadas' nombre,COUNT(DISTINCT idasignatura, idcarrera) cantidad FROM vista_cursadas";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

}
