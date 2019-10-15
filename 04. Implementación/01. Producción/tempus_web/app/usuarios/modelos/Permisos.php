<?php

/**
 * Description of Permisos
 *
 * @author Emanuel
 */
class Permisos {

    private $descripcion;

    public function __construct() {
        ;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function buscar($nombre) {
        $permisos = array();
        if ($nombre) {
            $consulta = "SELECT pe.*, ro.cantidad "
                    . "FROM permiso pe "
                    . "LEFT JOIN (SELECT idpermiso, COUNT(*) cantidad "
                    . "FROM rol_permiso GROUP BY idpermiso) ro ON ro.idpermiso = pe.idpermiso "
                    . "WHERE nombre LIKE '%{$nombre}%'";
            $permisos = Conexion::getInstancia()->seleccionar($consulta);
            if (!empty($permisos)) {
                return $permisos;
            }
            $this->descripcion = (is_null($permisos)) ? "No se pudo realizar la consulta de permisos" : "No se encontraron resultados";
        }
        return $permisos;
    }

    public function listar() {
        $consulta = "SELECT * FROM permiso";
        return Conexion::getInstancia()->seleccionar($consulta);
    }

}
