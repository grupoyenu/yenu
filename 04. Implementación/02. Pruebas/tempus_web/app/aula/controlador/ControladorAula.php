<?php

namespace app\aula\controlador;

use app\aula\modelo\Aula;
use app\aula\modelo\ColeccionAulas as Aulas;

/**
 * Controlador de Aula. Esta clase se comunica con los modelos del modulo
 * de aulas para invocar sus metodos y otorgar los resultados a las vistas 
 * que correspondan. Ademas, se encarga de almacenar las actividades que se llevan
 * a cabo en el Log cuando se realiza una operacion que implica actualizar 
 * informacion en la base de datos.
 * 
 * @package app\aula\controlador
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 * 
 *  @version 1.0
 * 
 */
class ControladorAula {

    /**
     * Borrar aula.
     * @see Aula::borrar
     * @param int Identificador del aula a eliminar.
     * @return array Arreglo de dos posiciones (codigo, nombre).
     */
    public function borrar($idAula) {
        $aula = new Aula($idAula);
        return $aula->borrar();
    }

    /**
     * Buscar aulas para presentar en el informe de horarios de cursada.
     * @see Aulas::buscarParaInformeCursada
     * @param string $disponible Si el aula debe estar disponible u ocupada.
     * @paran string $dia Dia de la semana.
     * @param string $desde Hora de inicio de las clases.
     * @param string $desde Hora de fin de las clases.
     * @return array Arreglo de dos posiciones (mensaje, datos).
     */
    public function buscarParaInformeCursada($disponible, $dia, $desde, $hasta) {
        return Aulas::buscarParaInformeCursada($disponible, $dia, $desde, $hasta);
    }

    /**
     * Buscar aulas para presentar en el informe de mesas de examen.
     * @see Aulas::buscarParaInformeMesa
     * @param string $disponible Si el aula debe estar disponible u ocupada.
     * @paran string $fecha Fecha de las mesas de examen.
     * @param string $hora Hora de las mesas de examen.
     * @return array Arreglo de dos posiciones (mensaje, datos).
     */
    public function buscarParaInformeMesa($disponible, $fecha, $hora) {
        return Aulas::buscarParaInformeMesa($disponible, $fecha, $hora);
    }

    /**
     * Buscar aulas por su nombre o por su sector.
     * @see Aulas::buscarPorSectorNombre
     * @param string $sector Nombre del sector.
     * @param string $nombre Nombre del aula.
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public function buscarPorSectorNombre($sector, $nombre) {
        return Aulas::buscarPorSectorNombre($sector, $nombre);
    }

    /**
     * Crear nueva aula. Realiza la creacion de una nueva aula y la almacena en 
     * la base de datos. En caso que dicha aula ya se encuentre cargada, se obtiene 
     * la informacion y se indica en el resultado.
     * @see Aula::crear
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

    /**
     * Listar resumen limitado de aulas.
     * @see Aulas::listarResumenAulas
     * @param int Limite maximo de asignaturas a seleccionar.
     * @return array Arreglo de dos posiciones (codigo, datos).
     */
    public function listarResumenAulas($limite) {
        return Aulas::listarResumenAulas($limite);
    }

    public function modificar($id, $sector, $nombre) {
        $aula = new Aula($id, $nombre, $sector);
        return $aula->modificar();
    }

}
