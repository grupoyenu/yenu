<?php

/**
 * Description of Roles
 *
 * @author Emanuel
 */
class Roles {

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
        $roles = array();
        if ($nombre) {
            $consulta = "SELECT ro.*, rp.cantidad "
                    . "FROM rol ro LEFT JOIN (SELECT idrol, COUNT(idrol) cantidad "
                    . "FROM rol_permiso GROUP BY idrol) rp ON rp.idrol = ro.idrol "
                    . "WHERE nombre LIKE '%{$nombre}%'";
            $roles = Conexion::getInstancia()->seleccionar($consulta);
            if (!empty($roles)) {
                return $roles;
            }
            $this->descripcion = (is_null($roles)) ? "No se pudo realizar la consulta de roles" : "No se encontraron resultados";
        }
        return $roles;
    }

    public function listar() {
        $consulta = "SELECT * FROM rol";
        return Conexion::getInstancia()->seleccionar($consulta);
    }

}
