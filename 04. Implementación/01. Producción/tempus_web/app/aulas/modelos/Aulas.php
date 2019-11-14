<?php

class Aulas {

    private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function buscar($campo, $valor) {
        if ($campo) {
            $consulta = "SELECT * FROM aula WHERE {$campo} LIKE '%{$valor}%'";
            $resultado = Conexion::getInstancia()->seleccionar($consulta);
            $this->descripcion = Conexion::getInstancia()->getDescripcion();
            return $resultado;
        }
        $this->descripcion = "El campo es obligatorio";
        return 0;
    }

    public function listar() {
        $consulta = "SELECT * FROM aula";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

    public function listarUltimasCreadas() {
        $consulta = "SELECT * FROM aula ORDER BY idaula DESC LIMIT 10";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

    public function listarAulasDisponibles($dia, $desde, $hasta, $nombre) {
        $consulta = "SELECT * FROM aula WHERE nombre LIKE '%{$nombre}%' AND idaula NOT IN "
                . "(SELECT idaula FROM clase WHERE dia = {$dia} AND "
                . "((desde > '{$desde}' AND desde < '{$hasta}') OR "
                . "(hasta > '{$desde}' AND hasta < '{$hasta}')))";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

    public function listarHorariosClase($id) {
        $consulta = "SELECT DISTINCT idAsignatura, nombreAsignatura, idClase, "
                . "numeroDia, nombreDia, desde, hasta, idAula, fechaMod "
                . "FROM vista_aulascursadas WHERE idAula = {$id} ORDER BY numeroDia, desde";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

}
