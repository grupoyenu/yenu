<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mesa
 *
 * @author Emanuel
 */
class Mesa {

    /** @var integer Identificador de la mesa en la base de datos. */
    private $idmesa;

    /** @var Plan Asignatura y Carrera a la que pertenece la mesa. */
    private $plan;

    /** @var Tribunal Tribunal de la mesa. */
    private $tribunal;

    /** @var Llamados Llamados de la mesa. */
    private $llamados;

    /** @var string Descripcion para mostrar mensajes */
    private $descripcion;

    /** @var boolean Estado que indica la validez de la mesa */
    private $valida;

    function __construct($idmesa = null) {
        $this->valida = false;
        if (!$idmesa) {
            return;
        }
        $consulta = "SELECT me.idmesa, a.idasignatura, a.nombre asignatura, c.codigo, c.nombre, me.idtribunal, me.primero, me.segundo
                    FROM mesa_examen me, asignatura a, carrera c
                    WHERE me.idasignatura = a.idasignatura AND me.idcarrera = c.codigo AND me.idmesa = " . $idmesa;
        $rows = Conexion::getInstancia()->executeQuery($consulta);
        if (empty($rows)) {
            return;
        }
        $mesa = $rows[0];
        $this->idmesa = $mesa['idmesa'];
        $this->plan = new Plan();
        $this->plan->carga($mesa['idasignatura'], $mesa['asignatura'], $mesa['codigo'], $mesa['nombre'], 1);
        $this->tribunal = new Tribunal($mesa['idtribunal']);
        $this->llamados = new Llamados($mesa['primero'], $mesa['segundo']);
        $this->valida = true;
    }

    public function constructor($plan, $tribunal, $idmesa = NULL, $llamados = NULL) {
        $this->valida = false;
        if ($plan && $tribunal) {
            $this->idmesa = $idmesa;
            $this->plan = $plan;
            $this->tribunal = $tribunal;
            $this->llamados = $llamados;
        }
        $this->descripcion = "La mesa de examen no contiene informacion obligatoria";
        return false;
    }

    public function cargar($idmesa, $plan, $tribunal, $llamados) {
        $this->idmesa = $idmesa;
        $this->plan = $plan;
        $this->tribunal = $tribunal;
        $this->llamados = $llamados;
        $this->valida = true;
    }

    /**
     * @return integer $idmesa
     */
    public function getIdmesa() {
        return $this->idmesa;
    }

    /**
     * @return Plan $plan
     */
    public function getPlan() {
        return $this->plan;
    }

    /**
     * @return Tribunal $tribunal
     */
    public function getTribunal() {
        return $this->tribunal;
    }

    /**
     * @return Llamados $primero
     */
    public function getLlamados() {
        return $this->llamados;
    }

    public function getEstado() {
        return $this->valida;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    /**
     * @param integer $idmesa
     */
    public function setIdmesa($idmesa) {
        $this->idmesa = $idmesa;
    }

    /**
     * @param Plan $plan
     */
    public function setPlan($plan) {
        $this->plan = ($plan) ? $plan : NULL;
    }

    /**
     * @param Tribunal $tribunal
     */
    public function setTribunal($tribunal) {
        $this->tribunal = $tribunal;
    }

    /**
     * @param Llamado $llamados
     */
    public function setLlamados($llamados) {
        $this->llamados = $llamados;
    }

    /**
     * Realiza la eliminacion de una mesa de examen. Junto con ella se deben eliminar los llamados
     * de la mesa indicada. El tribunal no se elimina porque puede estar relacionado con otra mesa
     * de examen.
     * @param MesaExamen $mesa Mesa de examen a eliminar.
     * @return boolean true o false.
     * */
    public function borrar() {
        if ($this->idmesa) {
            $consulta = "DELETE FROM mesa_examen WHERE idmesa=" . $this->idmesa;
            if (!Conexion::getInstancia()->executeUpdate($consulta)) {
                $this->descripcion = "No se realizó la eliminación de la mesa de examen";
                return 1;
            }
            $borrar = $this->llamados->borrar();
            if ($borrar < 2) {
                $this->descripcion = $this->llamados->getDescripcion();
                return $borrar;
            }
            $this->descripcion = "Se realizó la eliminación de la mesa de examen";
            return 2;
        }
        $this->descripcion = "La mesa de examen no contiene toda la información";
        return 0;
    }

    /**
     * Realiza la búsqueda de una mesa de examen. Cuando se encuentra la mesa de examen
     * se obtiene toda la información asociada. En caso contrario, cada uno de sus atributos
     * seran nulos.
     * @param Plan $plan Recibe la asignatura y carrera de la mesa de examen (Obligatorio).
     * */
    public function buscar() {
        if (!$this->plan) {
            $this->descripcion = "La mesa de examen no contiene plan";
            return 0;
        }
        if ($this->plan->validarParaActualizar()) {
            $consulta = "SELECT * FROM mesa_examen WHERE idasignatura = {$this->plan->getAsignatura()->getIdasignatura()} AND idcarrera = " . $this->plan->getCarrera()->getCodigo();
            $rows = Conexion::getInstancia()->executeQuery($consulta);
            if (is_null($rows)) {
                $this->descripcion = "No se pudo realizar la búsqueda para la mesa de examen";
                return 0;
            }
            if (!empty($rows)) {
                $this->descripcion = "Se encontró una mesa de examen que coincide con la indicada";
                return 2;
            }
            return 1;
        }
        $this->descripcion = $this->plan->getDescripcion();
        return 0;
    }

    public function crear() {
        $buscar = $this->buscar();
        if ($buscar == 1) {
            $crearTribunal = $this->tribunal->crear();
            if ($crearTribunal < 2) {
                $this->descripcion = $this->tribunal->getDescripcion();
                return $crearTribunal;
            }
            $crearLlamados = $this->llamados->crear();
            if ($crearLlamados < 2) {
                $this->descripcion = $this->llamados->getDescripcion();
                return $crearLlamados;
            }
            $idasignatura = $this->plan->getAsignatura()->getIdasignatura();
            $codigo = $this->plan->getCarrera()->getCodigo();
            $values = "(NULL," . $idasignatura . "," . $codigo . "," . $this->tribunal->getIdtribunal() . "," . $this->llamados->getIdPrimero() . "," . $this->llamados->getIdSegundo() . ")";
            $creacion = Conexion::getInstancia()->executeInsert("mesa_examen", $values);
            $this->idmesa = ($creacion == 2) ? (Int) Conexion::getInstancia()->insert_id : NULL;
            $this->descripcion = Conexion::getInstancia()->getDescripcion() . " de la mesa de examen";
            return $creacion;
        }
        return $buscar;
    }

    public function modificar() {
        if (!$this->idmesa || !$this->tribunal || !$this->llamados) {
            $this->descripcion = "La mesa de examen no contiene toda la información";
            return 0;
        }
        if ($this->tribunal->modificar() < 2) {
            $this->descripcion = $this->tribunal->getDescripcion();
            return 1;
        }
    }

    function __destruct() {
        unset($this);
    }

}
