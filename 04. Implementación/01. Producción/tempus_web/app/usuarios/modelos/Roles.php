<?php

/**
 * Description of Roles
 *
 * @author Emanuel
 */
class Roles {

    private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function buscar($nombre) {
        $consulta = "SELECT ROL.*, CAN.cantidad FROM rol ROL "
                . "LEFT JOIN (SELECT idrol, COUNT(*) cantidad FROM rol_permiso GROUP BY idrol) CAN "
                . "ON CAN.idrol = ROL.idrol WHERE ROL.nombre LIKE '%{$nombre}%'";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

    public function listar() {
        $consulta = "SELECT * FROM rol ORDER BY nombre";
        return Conexion::getInstancia()->seleccionar($consulta);
    }

    public function listarUltimosCreados() {
        $consulta = "SELECT ROL.*, CAN.cantidad FROM rol ROL "
                . "LEFT JOIN (SELECT idrol, COUNT(*) cantidad FROM rol_permiso GROUP BY idrol) CAN "
                . "ON CAN.idrol = ROL.idrol ORDER BY ROL.idrol DESC LIMIT 10";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

}
