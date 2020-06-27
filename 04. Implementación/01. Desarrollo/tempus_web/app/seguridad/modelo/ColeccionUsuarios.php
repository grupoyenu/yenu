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
class ColeccionUsuarios {

    /**
     * Buscar usuarios por nombre y ordenados por nombre.
     * @param string $nombreUsuario Nombre o parte del nombre del usuario.
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public static function buscarPorNombre($nombreUsuario): array {
        $expresion = "/^[a-záéíóúñü,. ]{0,30}$/";
        if (preg_match($expresion, mb_strtolower($nombreUsuario))) {
            $consulta = "SELECT * FROM vw_usuario "
                    . "WHERE nombreUsuario LIKE '%{$nombreUsuario}%' "
                    . "ORDER BY nombreUsuario";
            return Conexion::getInstancia()->seleccionar($consulta);
        }
        return array(0, "El nombre no cumple con el formato requerido");
    }

    /**
     * @see vw_informe Consulta cuando modulo es USUARIOS.
     */
    public static function listarInformesUsuario(): array {
        $consulta = "SELECT * FROM vw_informe WHERE modulo = 'USUARIOS'";
        return Conexion::getInstancia()->seleccionar($consulta);
    }

    /**
     * Listar todos los permisos ordernado por nombre. Selecciona el id y nombre
     * de cada uno de los permisos guardados. 
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public static function listarResumenUsuarios($limite): array {
        if ($limite > 0) {
            $consulta = "SELECT * FROM vw_usuario ORDER BY id DESC LIMIT {$limite}";
            return Conexion::getInstancia()->seleccionar($consulta);
        }
        return array(0, "No se estableció un limite válido");
    }

}
