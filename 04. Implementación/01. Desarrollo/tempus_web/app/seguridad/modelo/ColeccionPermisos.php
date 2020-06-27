<?php

namespace app\seguridad\modelo;

use app\principal\modelo\Conexion;

/**
 * 
 * @package app\seguridad\modelo
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
class ColeccionPermisos {

    /**
     * Buscar permisos por nombre y ordenados por nombre.
     * @param string $nombrePermiso Nombre o parte del nombre del permiso.
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public static function buscarPorNombre($nombrePermiso): array {
        $expresion = "/^[a-z ]{0,30}$/";
        if (preg_match($expresion, mb_strtolower($nombrePermiso))) {
            $consulta = "SELECT * FROM vw_permiso WHERE nombre LIKE '%{$nombrePermiso}%' ORDER BY nombre";
            return Conexion::getInstancia()->seleccionar($consulta);
        }
        return array(0, "El nombre no cumple con el formato requerido");
    }

    /**
     * @see vw_informe Consulta cuando modulo es PERMISOS.
     */
    public static function listarInformesPermiso(): array {
        $consulta = "SELECT * FROM vw_informe WHERE modulo = 'PERMISOS'";
        return Conexion::getInstancia()->seleccionar($consulta);
    }

    /**
     * Listar todos los permisos ordernado por nombre. Selecciona el id y nombre
     * de cada uno de los permisos guardados. 
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public static function listarPermisos(): array {
        $consulta = "SELECT * FROM permiso ORDER BY nombre";
        return Conexion::getInstancia()->seleccionar($consulta);
    }

    /**
     * Listar un resumen limitado de permisos. Selecciona el id, nombre y cantidad
     * de roles asociados para uno de los permisos segun el limite establecido.
     * @param int $limite Limite maximo de permisos a seleccionar (LIMIT).
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public static function listarResumenPermisos($limite): array {
        if ($limite > 0) {
            $consulta = "SELECT * FROM vw_permiso ORDER BY id DESC LIMIT {$limite}";
            return Conexion::getInstancia()->seleccionar($consulta);
        }
        return array(0, "No se estableció un limite válido");
    }

    /* Devuelve todos los permisos de un determinado rol */

    public static function listarPermisosRol($idRol): array {
        if ($idRol > 0) {
            $consulta = "SELECT pe.* FROM permiso pe INNER JOIN rol_permiso rp "
                    . "ON rp.permiso_id = pe.id AND rp.rol_id = {$idRol}";
            return Conexion::getInstancia()->seleccionar($consulta);
        }
        return array(0, "No se pudo hacer referencia al rol");
    }

}
