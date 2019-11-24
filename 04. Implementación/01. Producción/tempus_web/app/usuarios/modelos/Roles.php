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
        $consulta = "SELECT ROL.*, (CASE WHEN USU.usuarios IS NULL THEN 0 ELSE USU.usuarios END) usuarios, PER.permisos FROM rol ROL "
                . "LEFT JOIN (SELECT idrol, COUNT(*) permisos FROM rol_permiso GROUP BY idrol) PER ON PER.idrol = ROL.idrol "
                . "LEFT JOIN (SELECT idrol, COUNT(*) usuarios FROM usuario_rol GROUP BY idrol) USU ON USU.idrol = ROL.idrol "
                . "WHERE ROL.nombre LIKE '%{$nombre}%'";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

    public function listar() {
        $consulta = "SELECT * FROM rol ORDER BY nombre";
        return Conexion::getInstancia()->seleccionar($consulta);
    }

    public function listarUltimosCreados() {
        $consulta = "SELECT ROL.*, (CASE WHEN USU.usuarios IS NULL THEN 0 ELSE USU.usuarios END) usuarios, PER.permisos FROM rol ROL "
                . "LEFT JOIN (SELECT idrol, COUNT(*) permisos FROM rol_permiso GROUP BY idrol) PER ON PER.idrol = ROL.idrol "
                . "LEFT JOIN (SELECT idrol, COUNT(*) usuarios FROM usuario_rol GROUP BY idrol) USU ON USU.idrol = ROL.idrol "
                . "ORDER BY ROL.idrol DESC LIMIT 10";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

}
