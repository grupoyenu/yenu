<?php

/**
 * Description of Permisos
 *
 * @author Emanuel
 */
class Permisos {

    private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function buscar($nombre) {
        $consulta = "SELECT PER.*, (CASE WHEN CAN.cantidad IS NULL THEN 0 ELSE CAN.cantidad END) cantidad "
                . "FROM permiso PER LEFT JOIN (SELECT idpermiso, COUNT(*) cantidad FROM rol_permiso GROUP BY idpermiso) CAN "
                . "ON CAN.idpermiso = PER.idpermiso WHERE PER.nombre LIKE '%{$nombre}%'";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

    public function listar() {
        $consulta = "SELECT * FROM permiso ORDER BY nombre";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

    public function listarUltimosCreados() {
        $consulta = "SELECT PER.*, (CASE WHEN CAN.cantidad IS NULL THEN 0 ELSE CAN.cantidad END) cantidad "
                . "FROM permiso PER LEFT JOIN (SELECT idpermiso, COUNT(*) cantidad FROM rol_permiso GROUP BY idpermiso) CAN "
                . "ON CAN.idpermiso = PER.idpermiso ORDER BY PER.idpermiso DESC LIMIT 10";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

    /* Devuelve todos los permisos de un determinado rol */

    public function listarPorRol($idRol) {
        $consulta = "SELECT pe.* FROM permiso pe "
                . "INNER JOIN rol_permiso rp ON rp.idpermiso = pe.idpermiso AND rp.idrol = {$idRol}";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }
    
    public function listarResumenInicial() {
        $consulta = "SELECT 'Total de permisos' nombre, COUNT(*) cantidad FROM permiso";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

}