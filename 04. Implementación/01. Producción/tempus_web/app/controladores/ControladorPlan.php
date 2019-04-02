<?php

/**
 * Este controlador permite realizar las operaciones que corresponden a los 
 * planes. Funciona como un intermediario entre las vistas y los modelos. Se
 * encarga de relacionar la operacion que se desea realizar con el objeto que 
 * debe llevarla a cabo. Recibe el resultado de una operacion y la devuelve a 
 * traves de una descripcion asociada.
 *
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
class ControladorPlan {

    /** @var Plan Plan con el que se va a trabajar */
    private $plan;

    /** Constructor del controlador. Se encarga de crear un nuevo objeto Plan para
     * realizar las operaciones que se soliciten.
     */
    function __construct() {
        $this->plan = new Plan();
    }

    /**
     * Realiza la creación del plan en la base de datos. Los cambios solo se 
     * aplican si se realiza la creacion de carrera y asignatura, caso contrario 
     * no se actualiza la base de datos. Es posible que se encuentre creada una
     * carrera, asignatura o ambas. Los valores de retorno del metodo son: 
     * 0 si el plan esta incompleto.
     * 1 si la asignatura, carrera o plan no se crea.
     * 2 si se realiza la creacion de asignatura, carrera y plan.
     * 3 si se encuentran coincidencias en la base de datos.
     * @param Carrera $carrera Carrera del plan.
     * @param Asignatura $asignatura Asignatura del plan.
     * @param integer $anio Anio al que pertenece la asignatura en la carrera.
     * @return integer Devuelve un valor entero (0, 1, 2 o 3).
     */
    function crear($carrera, $asignatura, $anio) {
        Conexion::getInstancia()->setAutocommit(false);
        $this->plan->constructor($asignatura, $carrera, $anio);
        if (!$this->plan->getEstado()) {
            return 0;
        }
        $creacion = $this->plan->crear();
        if ($creacion == 3) {
            Conexion::getInstancia()->executeCommit();
        } else {
            if ($creacion == 1) {
                Conexion::getInstancia()->executeRollback();
            }
        }

        Conexion::getInstancia()->setAutocommit(true);
        return $creacion;
    }

    /** Realiza la busqueda de las carreras cargadas en la base de datos. */
    function buscarCarreras() {
        $carrera = new Carrera();
        return $carrera->buscarCarreras();
    }

    /** Realiza la busqueda de las asignaturas cargadas en la base de datos. */
    function buscarAsignaturas() {
        $asignatura = new Asignatura();
        return $asignatura->buscarAsignaturas();
    }
    
    /** Realiza la busqueda de los planes cargados en la base de datos. */
    function buscarPlanes() {
        return $this->plan->buscarPlanes();
    }

    /**
     * Retorna un mensaje que sirve de descripcion sobre alguna de las operaciones
     * que se lleva a cabo. Puede mostrar un mensaje que indica un error, una 
     * alerta o un exito.
     * @return string Mensaje descriptivo sobre alguna operacion.
     */
    function getDescripcion() {
        return $this->plan->getDescripcion();
    }
}
