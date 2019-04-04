<?php

/**
 * Description of Plan
 *
 * @author Emanuel
 */
class Plan {

    /** @var Asignatura $asignatura Asignatura perteneciente al plan */
    private $asignatura;

    /** @var Carrera $carrera Carrera perteneciente al plan */
    private $carrera;

    /** @var Carrera $anio Anio en que se dicta la asignatura dentro de carrera */
    private $anio;

    /** @var string Descripcion para mostrar mensajes */
    private $descripcion;

    /** @var boolean $estado Indica la validez del plan */
    private $estado;

    function __construct($idasignatura = null, $idcarrera = null) {
        $this->estado = false;
        if ($idasignatura && $idcarrera) {
            $consulta = "SELECT a.idasignatura, a.nombre asignatura, c.codigo, c.nombre carrera, ac.anio
                        FROM asignatura_carrera ac, asignatura a, carrera c
                        WHERE ac.idasignatura = a.idasignatura AND ac.idcarrera = c.codigo AND
                        ac.idasignatura = $idasignatura AND ac.idcarrera = $idcarrera";
            $rows = Conexion::getInstancia()->executeQuery($consulta);
            if (!empty($rows)) {
                $plan = $rows[0];
                $this->cargar($plan['idasignatura'], $plan['asignatura'], $plan['codigo'], $plan['carrera'], $plan['anio']);
            }
        }
    }

    public function constructor($asignatura, $carrera, $anio) {
        $this->estado = false;
        if ($this->setAsignatura($asignatura) && $this->setCarrera($carrera) && $this->setAnio($anio)) {
             $this->estado = true;
        }
        return $this->estado;
    }

    public function cargar($idasignatura, $asignatura, $codigo, $carrera, $anio) {
        $this->asignatura = new Asignatura();
        $this->carrera = new Carrera();
        $this->asignatura->cargar($asignatura, $idasignatura);
        $this->carrera->cargar($codigo, $carrera);
        $this->anio = $anio;
        $this->estado = true;
    }

    /**
     * Devuelve la asignatura del plan.
     * @return Asignatura $asignatura
     */
    public function getAsignatura() {
        return $this->asignatura;
    }

    /**
     * Devuelve la carrera del plan.
     * @return Carrera $carrera
     */
    public function getCarrera() {
        return $this->carrera;
    }

    /**
     * Devuelve el anio al que pertenece la asignatura dentro de la carrera.
     * @return integer $anio
     */
    public function getAnio() {
        return $this->anio;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getEstado() {
        return $this->estado;
    }

    /**
     * Modifica la asignatura que pertenece a la carrera.
     * @param Asignatura $asignatura
     */
    public function setAsignatura($asignatura) {
        if ($this->validarAsignatura($asignatura)) {
            $this->asignatura = $asignatura;
            return true;
        }
        return false;
    }

    /**
     * Modifica la carrera.
     * @param carrera $carrera
     */
    public function setCarrera($carrera) {
        if ($this->validarCarrera($carrera)) {
            $this->carrera = $carrera;
            return true;
        }
        return false;
    }

    /**
     * Modifica el anio.
     * @param integer $anio
     */
    public function setAnio($anio) {
        if ($this->validarAnio($anio)) {
            $this->anio = $anio;
            return true;
        }
        return false;
    }

    private function buscarExistente() {
        $idasignatura = $this->asignatura->getIdasignatura();
        $idcarrera = $this->carrera->getCodigo();
        $consulta = "SELECT a.idasignatura, a.nombre asignatura, c.codigo, c.nombre carrera, ac.anio
                        FROM asignatura_carrera ac, asignatura a, carrera c
                        WHERE ac.idasignatura = a.idasignatura AND ac.idcarrera = c.codigo AND
                        ac.idasignatura = $idasignatura AND ac.idcarrera = $idcarrera";
        $rows = Conexion::getInstancia()->executeQuery($consulta);
        if (is_null($rows)) {
            $this->descripcion = "No se pudo realizar la búsqueda de plan";
            return 0;
        }
        $this->descripcion = "Se encontró un plan que coincide con el indicado";
        return (empty($rows)) ? 1 : 2;
    }

    public function buscarPlanes() {
        $consulta = "SELECT c.codigo, c.nombre carrera, a.idasignatura, a.nombre asignatura, ac.anio
                    FROM asignatura_carrera ac, asignatura a, carrera c
                    WHERE ac.idasignatura = a.idasignatura AND ac.idcarrera = c.codigo
                    ORDER BY c.codigo, a.nombre";
        $rows = Conexion::getInstancia()->executeQuery($consulta);
        return $rows;
    }

    public function crear() {
        if ($this->completo()) {
            if ($this->asignatura->crear() < 2) {
                $this->descripcion = $this->asignatura->getDescripcion();
                return 1;
            }
            if ($this->carrera->crear() < 2) {
                $this->descripcion = $this->carrera->getDescripcion();
                return 1;
            }
            $existe = $this->buscarExistente();
            if ($existe != 1) {
                return $existe;
            }
            $values = "({$this->asignatura->getIdasignatura()}, {$this->carrera->getCodigo()}, $this->anio)";
            $creacion = Conexion::getInstancia()->executeInsert("asignatura_carrera", $values);
            $this->descripcion = Conexion::getInstancia()->getDescripcion() . " del plan";
            return $creacion;
        }
        return 0;
    }

    public function completo() {
        $this->descripcion = "El plan no contiene toda la información";
        return ($this->asignatura && $this->carrera) ? true : false;
    }

    /**
     * Comprueba que el plan contenga asignatura y carrera. Ademas comprueba que 
     * ambas posean identificador para realizar actualizaciones a la base de
     * datos.
     */
    public function validar() {
        return ($this->validarAsignatura($this->asignatura) && $this->validarCarrera($this->carrera)) ? true : false;
    }

    private function validarAnio($anio) {
        $expresion = "/^[1-9]$/";
        $this->descripcion = "El año del plan no cumple con el formato";
        return (preg_match($expresion, $anio)) ? true : false;
    }

    public function validarAsignatura($asignatura) {
        $this->descripcion = "La asignatura no contiene toda la información";
        return ($asignatura && $asignatura->getIdasignatura()) ? true : false;
    }

    public function validarCarrera($carrera) {
        $this->descripcion = "La carrera no contiene toda la información";
        return ($carrera && $carrera->getCodigo()) ? true : false;
    }

}
