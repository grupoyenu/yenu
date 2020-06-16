<?php

namespace app\aula\controlador;

use app\aula\modelo\Aula;
use app\aula\modelo\ColeccionAulas as Aulas;

/**
 * 
 * @package app\aula\controlador
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
class ControladorAula {

    /**
     * Borrar aula.
     * @param int Identificador del aula a eliminar.
     * @return array Arreglo de dos posiciones (codigo, nombre).
     */
    public function borrar($idAula) {
        $aula = new Aula($idAula);
        return $aula->borrar();
    }

    public function buscarParaInformeCursada($disponible, $dia, $desde, $hasta) {
        return Aulas::buscarParaInformeCursada($disponible, $dia, $desde, $hasta);
    }

    public function buscarParaInformeMesa($disponible, $fecha, $hora) {
        return Aulas::buscarParaInformeMesa($disponible, $fecha, $hora);
    }

    /**
     * Buscar aulas por su nombre o por su sector.
     * @param string $sector Nombre del sector.
     * @param string $nombre Nombre del aula.
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public function buscarPorSectorNombre($sector, $nombre) {
        return Aulas::buscarPorSectorNombre($sector, $nombre);
    }

    /**
     * Crear nueva aula.
     * @param string $sector Nombre del sector.
     * @param string $nombre Nombre del aula.
     * @return array Arreglo de dos posiciones (codigo, nombre).
     */
    public function crear($sector, $nombre) {
        $aula = new Aula(NULL, $nombre, $sector);
        return $aula->crear();
    }

    public function listarAulas($nombre) {
        return Aulas::listarAulas($nombre);
    }

    public function listarAulasDisponibles($dia, $desde, $hasta, $nombre) {
        return Aulas::listarAulasDisponibles($dia, $desde, $hasta, $nombre);
    }

    public function listarInformesAula() {
        return Aulas::listarInformesAula();
    }

    public function listarResumenAulas($limite) {
        return Aulas::listarResumenAulas($limite);
    }

    public function modificar($id, $sector, $nombre) {
        $aula = new Aula($id, $nombre, $sector);
        return $aula->modificar();
    }

}
