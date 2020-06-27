<?php

namespace app\docente\controlador;

use app\docente\modelo\ColeccionDocentes as Docentes;

/**
 * Controlador de Docente. Esta clase se comunica con los modelos del modulo
 * de docentes para invocar sus metodos y otorgar los resultados a las vistas 
 * que correspondan.
 * 
 * @package app\docente\controlador.
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 * 
 * @version 1.0
 * 
 */
class ControladorDocente {

    /**
     * Realiza la busqueda de docentes a partir de su nombre con el objetivo de
     * realizar la seleccion de uno de ellos.
     * @see Docentes::seleccionar
     * @param string $nombreDocente Nombre o parte del nombre del docente.
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public function seleccionar($nombreDocente) {
        return Docentes::seleccionar($nombreDocente);
    }

}
