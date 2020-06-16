<?php

namespace app\docente\controlador;

use app\docente\modelo\ColeccionDocentes as Docentes;

/**
 * 
 * @package app\docente\controlador.
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
class ControladorDocente {

    public function seleccionar($nombreDocente) {
        return Docentes::seleccionar($nombreDocente);
    }

}
