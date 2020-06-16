<?php

namespace app\carrera\controlador;

use app\carrera\modelo\Carrera;
use app\carrera\modelo\ColeccionCarreras as Carreras;

/**
 * 
 * @package app\carrera\controlador
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
class ControladorCarrera {

    /**
     * Buscar carreras por su nombre y carrera ordernadas por nombre.
     * @param string $nombreCarrera Nombre de la carrera o parte del nombre.
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public function buscarPorNombre($nombreCarrera) {
        return Carreras::buscarPorNombre($nombreCarrera);
    }

    /**
     * Crear nueva carrera.
     * @param string $nombreCarrera Nombre de la nueva carrera.
     * @return array Arreglo de dos posiciones (codigo, mensaje).
     */
    public function crear($codigo, $nombreCarrera) {
        $carrera = new Carrera($codigo, $nombreCarrera, $nombreCarrera);
        return $carrera->crear();
    }

    public function listarInformesCarrera() {
        return Carreras::listarInformesCarrera();
    }

    /**
     * Listar resumen limitado de carreras. Selecciona el identificador, nombre
     * corto, nombre largo y cantidad de asignaturas para cada una de las carreras 
     * segun el limite.
     * @param int Limite maximo de carreras a seleccionar.
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public function listarResumenCarreras($limite) {
        return Carreras::listarResumenCarreras($limite);
    }

}
