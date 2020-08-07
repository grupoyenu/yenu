<?php

namespace app\carrera\controlador;

use app\carrera\modelo\Carrera;
use app\carrera\modelo\ColeccionCarreras as Carreras;

/**
 * Controlador de Carrera. Esta clase se comunica con los modelos del modulo
 * de carreras para invocar sus metodos y otorgar los resultados a las vistas 
 * que correspondan. Ademas, se encarga de almacenar las actividades que se llevan
 * a cabo en el Log cuando se realiza una operacion que implica actualizar 
 * informacion en la base de datos.
 * 
 * @package app\carrera\controlador
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 * 
 * @version 1.0
 * 
 */
class ControladorCarrera {

    /**
     * Buscar carreras por su nombre, ordernadas por nombre.
     * @see Carreras::buscarPorNombre
     * @param string $nombreCarrera Nombre de la carrera o parte del nombre.
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public function buscarPorNombre($nombreCarrera) {
        return Carreras::buscarPorNombre($nombreCarrera);
    }

    /**
     * Crear nueva carrera.
     * @see Carrera::crear
     * @see Log::guardar
     * @param string $nombreCarrera Nombre de la nueva carrera.
     * @return array Arreglo de dos posiciones (codigo, mensaje).
     */
    public function crear($codigo, $nombreCarrera) {
        Log::guardar("INF", "CONTROLADOR CARRERA --> CREAR ***");
        $carrera = new Carrera($codigo, $nombreCarrera, $nombreCarrera);
        return $carrera->crear();
    }

    /**
     * Listar informes del modulo de carreras.
     * @see Carreras::listarInformesCarrera
     * @return array Arreglo de dos posiciones (codigo, mensaje).
     */
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
