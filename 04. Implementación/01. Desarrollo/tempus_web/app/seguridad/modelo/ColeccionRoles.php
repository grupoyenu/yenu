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
class ColeccionRoles {

    /**
     * Buscar roles por nombre y ordenados por nombre.
     * @param string $nombreRol Nombre o parte del nombre del rol.
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public static function buscarPorNombre($nombreRol): array {
        $expresion = "/^[a-z_ ]{0,15}$/";
        if (preg_match($expresion, mb_strtolower($nombreRol))) {
            $consulta = "SELECT * FROM vw_rol WHERE nombre LIKE '%{$nombreRol}%' ORDER BY nombre";
            return Conexion::getInstancia()->seleccionar($consulta);
        }
        return array(0, "El nombre no cumple con el formato requerido");
    }

    /**
     * @see vw_informe Consulta cuando modulo es ROLES.
     */
    public static function listarInformesRol(): array {
        $consulta = "SELECT * FROM vw_informe WHERE modulo = 'ROLES'";
        return Conexion::getInstancia()->seleccionar($consulta);
    }

    /**
     * Listar todos los roles ordernados por nombre. Selecciona el id y nombre
     * de cada uno de los roles guardados. 
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public static function listarRoles(): array {
        $consulta = "SELECT * FROM rol ORDER BY nombre";
        return Conexion::getInstancia()->seleccionar($consulta);
    }

    /**
     * Listar un resumen limitado de roles. Selecciona el id, nombre, cantidad
     * de usuarios asociados y cantidad de permisos asociados para uno de los roles 
     * segun el limite establecido.
     * @param int $limite Limite maximo de roles a seleccionar (LIMIT).
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public static function listarResumenRoles($limite): array {
        if ($limite > 0) {
            $consulta = "SELECT * FROM vw_rol ORDER BY id DESC LIMIT {$limite}";
            return Conexion::getInstancia()->seleccionar($consulta);
        }
        return array(0, "No se estableció un limite válido");
    }

    /**
     * Seleccionar rol por su nombre.
     * @param string $nombreRol Nombre del rol o parte del nombre (LIKE).
     * @return array Arreglo de dos posiciones (codigo, mensaje).
     */
    public static function seleccionar($nombreRol): array {
        $consulta = "SELECT * FROM rol WHERE nombre LIKE '%{$nombreRol}%' ORDER BY nombre";
        return Conexion::getInstancia()->seleccionar($consulta);
    }

}
