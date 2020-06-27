<?php

namespace app\asignatura\controlador;

use app\asignatura\modelo\Asignatura;
use app\asignatura\modelo\ColeccionAsignaturas as Asignaturas;
use app\principal\modelo\Log;

/**
 * Controlador de Asignatura. Esta clase se comunica con los modelos del modulo
 * de asignaturas para invocar sus metodos y otorgar los resultados a las vistas 
 * que correspondan. Ademas, se encarga de almacenar las actividades que se llevan
 * a cabo en el Log cuando se realiza una operacion que implica actualizar 
 * informacion en la base de datos.
 * 
 * @package app\asignatura\controlador
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 * 
 * @version 1.0
 */
class ControladorAsignatura {

    /**
     * Buscar asignaturas por su nombre y carrera ordernadas por nombre.
     * @see Asignaturas::buscarPorCarrera
     * @param string $codigoCarrera Codigo de la carrera.
     * @param string $nombreAsignatura Nombre de la asignatura o parte del nombre.
     * @param bool $pertenece True si la asignatura pertenece a la carrera o false.
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public function buscarPorCarrera($codigoCarrera, $nombreAsignatura, $pertenece) {
        return Asignaturas::buscarPorCarrera($codigoCarrera, $nombreAsignatura, $pertenece);
    }

    /**
     * Buscar asignaturas por su nombre ordenadas por nombre.
     * @see Asignaturas::buscarPorNombre
     * @param string $nombreAsignatura Nombre de la asignatura o parte del nombre.
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public function buscarPorNombre($nombreAsignatura) {
        return Asignaturas::buscarPorNombre($nombreAsignatura);
    }

    /**
     * Crear nueva asignatura. Realiza la creacion de una nueva asignatura y la
     * almacena en la base de datos. En caso que dicha asignatura ya se encuentre
     * cargada, se obtiene la informacion y se indica en el resultado.
     * @see Asignatura::crear
     * @see Log::guardar
     * @param string $nombreAsignatura Nombre de la nueva asignatura.
     * @return array Arreglo de dos posiciones (codigo, mensaje).
     */
    public function crear($nombreAsignatura) {
        Log::guardar("INF", "CONTROLADOR ASIGNATURA --> CREAR ***");
        $asignatura = new Asignatura(NULL, $nombreAsignatura, $nombreAsignatura);
        $resultado = $asignatura->crear();
        $mensaje = ($resultado[0] == 2) ? "CREADA" : "NO CREADA";
        Log::guardar("INF", "CONTROLADOR ASIGNATURA --> {$mensaje}");
        return $resultado;
    }

    /**
     * Listar informes del modulo de asignaturas.
     * @see Asignaturas::listarInformesAsignatura
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public function listarInformesAsignatura() {
        return Asignaturas::listarInformesAsignatura();
    }

    /**
     * Listar resumen limitado de asignaturas. Selecciona el identificador, nombre
     * y cantidad de carreras para cada una de las asignaturas segun el limite.
     * @see Asignaturas::listarResumenAsignaturas
     * @param int Limite maximo de asignaturas a seleccionar.
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public function listarResumenAsignaturas($limite) {
        return Asignaturas::listarResumenAsignaturas($limite);
    }

}
