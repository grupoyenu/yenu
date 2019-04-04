<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cursada
 *
 * @author Emanuel
 */
class Cursada {

    /** @var Plan  */
    private $plan;

    /** @var Clase[] */
    private $clases;
    private $descripcion;
    private $estado;

    /**
     * Constructor de clase.
     * */
    function __construct($plan = NULL, $clases = NULL) {
        $this->estado = false;
        if ($plan && $clases) {
            $this->cargar($plan, $clases);
        }
    }

    public function cargar($plan, $clases) {
        $this->plan = $plan;
        $this->clases = $clases;
        $this->estado = true;
    }

    /**
     * @return Plan $plan
     */
    public function getPlan() {
        return $this->plan;
    }

    /**
     * @return Clase[] $clases
     */
    public function getClases() {
        return $this->clases;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getEstado() {
        return $this->estado;
    }

    /**
     * @param Plan $plan
     */
    public function setPlan($plan) {
        $this->plan = $plan;
    }

    /**
     * @param Clase[] $clases
     */
    public function setClases($clases) {
        $this->clases = $clases;
    }

    public function crear() {
        if ($this->plan && !empty($this->clases)) {
            if (!$this->crearClases()) {
                return 1;
            }
            if ($this->buscarRelacion()) {
                return 1;
            }
            $values = "";
            $idasignatura = $this->plan->getAsignatura()->getIdasignatura();
            $codigo = $this->plan->getCarrera()->getCodigo();
            foreach ($this->clases as $clase) {
                $values = $values . "({$idasignatura},{$codigo}, {$clase->getIdclase()}),";
            }
            $values = substr($values, 0, -1);
            $creacion = Conexion::getInstancia()->executeInsert("cursada", $values);
            $this->descripcion = Conexion::getInstancia()->getDescripcion()." de la cursada";
            return $creacion;
        }
        $this->descripcion = "La cursada no contiene toda la información";
        return 0;
    }

    private function crearClases() {
        $contador = 0;
        $cantidad = count($this->clases);
        $correcto = true;
        while (($contador < $cantidad) && $correcto) {
            $dia = $this->clases[$contador]->getDia();
            $creacion = $this->clases[$contador]->crear();
            if ($creacion < 2) {
                $this->descripcion = $this->clases[$contador]->getDescripcion() . " del dia " . Utilidades::nombreDeDia($dia);
                $correcto = false;
            }
            $contador++;
        }
        return $correcto;
    }

    /**
     * 
     * */
    public function borrar($idasignatura, $idcarrera) {
        $where = "idasignatura={$idasignatura} AND idcarrera={$idcarrera}";
        $eliminacion = Conexion::getInstancia()->executeDelete("cursada", $where);
        $this->descripcion = Conexion::getInstancia()->getDescripcion() . " de la cursada";
        return $eliminacion;
    }

    /**
     * Controla que no exista cargada la relacion entre cursada y clase.
     * @return boolean Verdadero si existe o Falso en caso contrario.
     * */
    private function buscarRelacion() {
        if ($this->plan && $this->plan->validar()) {
            $idasignatura = $this->plan->getAsignatura()->getIdasignatura();
            $idcarrera = $this->plan->getCarrera()->getCodigo();
            $consulta = "SELECT * FROM cursada WHERE idasignatura = {$idasignatura} AND idcarrera = {$idcarrera}";
            if (Conexion::getInstancia()->executeQueryBoolean($consulta)) {
                $this->descripcion = "Se encontró una cursada para el plan indicado";
                return true;
            }
            return false;
        }
    }

    /**
     * Elimina una relacion entre asignatura y clase. Se mantiene la clase dado que puede estar
     * asociada a otras carreras. Cuando se realiza la eliminacion el metodo devuelve true. Si no
     * se hace la eliminacion, devuelve false.
     * @param integer $idasignatura Identificador de la Asignatura.
     * @param integer $idcarrera Identificador de la Carrera.
     * @param integer $idclase Identificador de la Clase.
     * @retun boolean true o false.
     * */
    private function borrarRelacion($idasignatura, $idcarrera, $idclase) {
        $consulta = "DELETE FROM cursada WHERE idasignatura=" . $idasignatura . " AND idcarrera=" . $idcarrera . " AND idclase=" . $idclase;
        ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if (ObjetoDatos::getInstancia()->affected_rows > 0) {
            return true;
        }
        return false;
    }

    /**
     * Obtiene las clases de una asignatura para una determinada carrera.
     * */
    public function obtenerHorarios() {
        if ($this->plan && $this->plan->validar()) {
            $idasignatura = $this->plan->getAsignatura()->getIdasignatura();
            $idcarrera = $this->plan->getCarrera()->getCodigo();
            $consulta = "SELECT cl.idclase, cl.dia, DATE_FORMAT(cl.desde, '%H:%i') desde,DATE_FORMAT(cl.hasta, '%H:%i') hasta, cl.idaula FROM cursada cu, clase cl WHERE cu.idclase=cl.idclase AND cu.idasignatura={$idasignatura} AND cu.idcarrera={$idcarrera}";
            $rows = Conexion::getInstancia()->executeQuery($consulta);
            if (empty($rows)) {
                return is_null($rows) ? 0 : 1;
            }
            $this->clases = array();
            foreach ($rows as $fila) {
                $clase = new Clase();
                $aula = new Aula($fila['idaula']);
                $clase->cargar($fila['idclase'], $fila['dia'], $fila['desde'], $fila['hasta'], $aula, NULL);
                $this->clases[$fila['dia']] = $clase;
            }
            return empty($this->clases) ? 0 : 2;
        }
        return 0;
    }

    /**
     * Realiza la eliminacion de una clase para la asignatura correspondiente. Se debe considerar
     * que la clase puede ser dictada en muchas carreras. Por ello el parametro todas debe indicar
     * si la eliminacion se aplica a todas las carreras (true) o solo a una (false). En caso de
     * estar en una sola carrera, se elimina la clase y la relacion (cursada).
     * @param Plan @plan Informacion de la carrera y asignatura.
     * @param Clase @clase Informacion de la clase a eliminar.
     * @param boolean @todas Indica si borrar para todas las clases o solo la del plan.
     * */
    public function quitarClase($plan, $clase, $todas) {
        $idclase = $clase->getIdclase();
        $numcarreras = $clase->contarCarreras($idclase);
        if ($numcarreras > 1) {
            if (!$todas) {
                $idasignatura = $plan->getAsignatura()->getIdasignatura();
                $idcarrera = $plan->getCarrera()->getCodigo();
                return $this->borrarRelacion($idasignatura, $idcarrera, $idclase);
            }
        }
        $clase->borrar($idclase);
        if ($clase->getIdclase()) {
            return false;
        }
        return true;
    }

}
