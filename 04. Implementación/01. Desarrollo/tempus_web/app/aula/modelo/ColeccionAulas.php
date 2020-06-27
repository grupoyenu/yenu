<?php

namespace app\aula\modelo;

use app\principal\modelo\Conexion;

/**
 * Description of Aulas
 * 
 * @package app\aula\modelo
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
class ColeccionAulas {

    /**
     * Buscar aulas por sector o nombre y ordenadas por sector y nombre.
     * @param string $sector Nombre del sector.
     * @param string $nombre Nombre del aula.
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public static function buscarPorSectorNombre($sector, $nombre): array {
        $consulta = "SELECT * FROM vw_aula "
                . "WHERE sector LIKE '%{$sector}%' AND nombre LIKE '%{$nombre}%'"
                . "ORDER BY sector, nombre";
        return Conexion::getInstancia()->seleccionar($consulta);
    }

    /**
     * Listar todas las aulas a partir de su nombre.
     * @param string $nombre Nombre del aula.
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public static function listarAulas($nombre) {
        $consulta = "SELECT * FROM aula WHERE nombre LIKE '%{$nombre}%' ORDER BY sector, nombre";
        return Conexion::getInstancia()->seleccionar($consulta);
    }

    /**
     * Buscar aulas por su nombre y que se encuentren disponibles un determinado
     * dia en una franja horaria.
     * @param int $dia Dia de la semana.
     * @param string $desde Horario de inicio.
     * @param string $hasta Horario de fin.
     * @param strin $nombre Nombre o parte del nombre del aula.
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public static function listarAulasDisponibles($dia, $desde, $hasta, $nombre): array {
        if ($dia && $desde && $hasta && $nombre) {
            $consulta = "SELECT * FROM aula WHERE nombre LIKE '%{$nombre}%' AND id NOT IN "
                    . "(SELECT idAula FROM clase WHERE diaSemana = {$dia} AND "
                    . "((horaInicio >= '{$desde}' AND horaFin < '{$hasta}') OR "
                    . "(horaFin > '{$desde}' AND horaFin < '{$hasta}') OR "
                    . "(horaInicio > '{$desde}' AND horaInicio < '{$hasta}')))";
            return Conexion::getInstancia()->seleccionar($consulta);
        }
        return array(0, "Los datos recibidos no cumplen con el formato requerido");
    }

    public static function listarHorariosClase($idAula) {
        if ($idAula) {
            $consulta = "SELECT DISTINCT idAsignatura, nombreAsignatura, idClase, "
                    . "numeroDia, nombreDia, desde, hasta, idAula, fechaMod "
                    . "FROM vista_aulascursadas WHERE idAula = {$idAula} "
                    . "ORDER BY numeroDia asc, desde";
            return Conexion::getInstancia()->seleccionar($consulta);
        }
        return array(0, "No se pudo hacer referencia al aula");
    }

    public static function buscarParaInformeCursada($disponible, $dia, $desde, $hasta) {
        if ($dia && $desde && $hasta) {
            $consulta = "SELECT * FROM aula WHERE id {$disponible} (SELECT idAula FROM clase WHERE ";
            $consulta .= ($dia != "NO") ? "diaSemana = {$dia} AND" : "";
            $consulta .= "((horaInicio >= '{$desde}' AND horaFin < '{$hasta}') OR "
                    . "(horaFin > '{$desde}' AND horaFin < '{$hasta}') OR "
                    . "(horaInicio < '{$desde}' AND horaFin > '{$desde}'))) ORDER BY sector, nombre";
            return Conexion::getInstancia()->seleccionar($consulta);
        }
        return array(0, "Los datos recibidos no cumplen con el formato requerido");
    }

    public static function buscarParaInformeMesa($disponible, $fecha, $hora) {
        if ($disponible && $fecha && $hora) {
            $consulta = "SELECT * FROM aula WHERE id {$disponible} "
                    . "(SELECT idAula FROM llamado "
                    . "WHERE fecha = '{$fecha}' AND hora = '{$hora}') "
                    . "ORDER BY sector, nombre";
            return Conexion::getInstancia()->seleccionar($consulta);
        }
        return array(0, "Los datos recibidos no cumplen con el formato requerido");
    }

    /**
     * @see vw_informe Consulta cuando modulo es AULAS.
     */
    public static function listarInformesAula(): array {
        $consulta = "SELECT * FROM vw_informe WHERE modulo = 'AULAS'";
        return Conexion::getInstancia()->seleccionar($consulta);
    }

    public static function listarMesasExamen($id) {
        if ($id > 0) {
            $consulta = "SELECT codigoCarrera, nombreCarrera, nombreAsignatura, "
                    . "fechaPri, horaPri, fechaSeg, horaSeg "
                    . " FROM vista_mesas WHERE idAulaPri = {$id} OR idAulaSeg = {$id}";
            return Conexion::getInstancia()->seleccionar($consulta);
        }
        return array(0, "No se pudo hacer referencia al aula");
    }

    /**
     * Listar resumen limitado de aulas. Selecciona el idaula, sector, nombre,
     * cantidad de clases y cantidad de llamados ordenados por id.
     * @param int $limite Limite maximo de roles a seleccionar (LIMIT).
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public static function listarResumenAulas($limite) {
        if ($limite > 0) {
            $consulta = "SELECT * FROM vw_aula ORDER BY id DESC LIMIT {$limite}";
            return Conexion::getInstancia()->seleccionar($consulta);
        }
        return array(0, "No se estableció un limite válido");
    }

}
