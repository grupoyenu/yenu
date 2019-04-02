<?php

/**
 * Description of Llamado
 *
 * @author Emanuel
 */
class Llamado {

    /** @var integer */
    private $idllamado;

    /** @var string */
    private $fecha;

    /** @var string */
    private $hora;

    /** @var Aula */
    private $aula;

    /** @var string Fecha de modificacion */
    private $fechamod;
    private $estado;
    private $descripcion;

    /**
     * Constructor de clase. Cuando recibe el identificador del llamado realiza la busqueda de la 
     * informacion en la base de datos. En caso contrario, se crea con sus atributos nulos.
     * @param integer $idllamado Identificador del llamado.
     * */
    function __construct($idllamado = NULL) {
        $this->valido = false;
        if ($idllamado) {
            $consulta = "SELECT idllamado, DATE_FORMAT(fecha, '%d/%m/%Y') fecha, DATE_FORMAT(hora, '%H:%i') hora, idaula, DATE_FORMAT(fechamod, '%d/%m/%Y') fechamod FROM llamado WHERE idllamado = " . $idllamado;
            $rows = Conexion::getInstancia()->executeQuery($consulta);
            if (!empty($rows)) {
                $llamado = $rows[0];
                $aula = ($llamado['idaula']) ? new Aula($llamado['idaula']) : NULL;
                $this->cargar($llamado['idllamado'], $llamado['fecha'], $llamado['hora'], $aula, $llamado['fechamod']);
            }
        }
    }

    public function constuctor($fecha, $hora, $idllamado = null, $aula = null, $fechamod = null) {
        $this->estado = false;
        if ($fecha && $hora) {
            $this->fecha = $fecha;
            $this->hora = $hora;
            $this->idllamado = $idllamado;
            $this->aula = ($aula) ? $this->setAula($aula) : NULL;
            $this->fechamod = $fechamod;
            $this->estado = true;
        }
        return $this->estado;
    }

    public function cargar($idllamado, $fecha, $hora, $aula, $fechamod) {
        $this->idllamado = $idllamado;
        $this->fecha = $fecha;
        $this->hora = $hora;
        $this->aula = ($aula) ? $this->setAula($aula) : "NULL";
        $this->fechamod = $fechamod;
        $this->estado = true;
    }

    /**
     * @return integer $idllamado
     */
    public function getIdllamado() {
        return $this->idllamado;
    }

    /**
     * @return string $fecha
     */
    public function getFecha() {
        return $this->fecha;
    }

    /**
     * @return string $hora
     */
    public function getHora() {
        return $this->hora;
    }

    /**
     * @return Aula $aula
     */
    public function getAula() {
        return ($this->aula == "NULL") ? NULL : $this->aula;
    }

    /**
     * @return string $fechamod
     * */
    public function getFechamod() {
        return $this->fechamod;
    }

    public function getEstado() {
        return $this->valido;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    /**
     * @param integer $idllamado
     */
    public function setIdllamado($idllamado) {
        $this->idllamado = $idllamado;
    }

    /**
     * @param string $fecha
     */
    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    /**
     * @param string $hora
     */
    public function setHora($hora) {
        if ($this->validarFormatoHora($hora)) {
            $this->hora = $hora;
            return true;
        }
        return false;
    }

    /**
     * @param Aula $aula
     */
    public function setAula($aula) {
        if ($this->validarAula($aula)) {
            $this->aula = $aula;
            return true;
        }
        $this->aula = "NULL";
        return false;
    }

    /**
     * @param string $fechamod
     * */
    public function setFechamod($fechamod) {
        $this->fechamod = $fechamod;
    }

    public function borrar() {
        if ($this->idllamado) {
            $where = "idllamado=" . $this->idllamado;
            $eliminacion = Conexion::getInstancia()->executeDelete("llamado", $where);
            $this->descripcion = Conexion::getInstancia()->getDescripcion() . " del llamado";
            return $eliminacion;
        }
        $this->descripcion = "El llamado no contiene toda la información";
        return 0;
    }

    public function crear() {
        if ($this->fecha && $this->hora) {
            $values = "(NULL,'{$this->fecha}','{$this->hora}',{$this->aula}, NULL)";
            $creacion = Conexion::getInstancia()->executeInsert("llamado", $values);
            $this->idllamado = ($creacion == 2) ? (Int) Conexion::getInstancia()->insert_id : NULL;
            $this->descripcion = Conexion::getInstancia()->getDescripcion() . " del llamado";
            return $creacion;
        }
        $this->descripcion = "El llamado no contiene toda la información";
        return 0;
    }

    public function modificar() {
        if ($this->idllamado && $this->fecha && $this->hora) {
            $consulta = "UPDATE llamado SET fecha='{$this->fecha}', hora='{$this->hora}', idaula={$this->aula}, fechamod=NOW() WHERE idllamado=" . $this->idllamado;
            if (Conexion::getInstancia()->executeUpdate($consulta)) {
                $this->descripcion = "Se realizó la modificación del llamado";
                return 2;
            }
            $this->descripcion = "No se realizó la modificación del llamado";
            return 1;
        }
        $this->descripcion = "El llamado no contiene toda la información";
        return 0;
    }

    private function validarAula($aula) {
        $this->descripcion = "El aula no se considera valida";
        return ($aula && $aula->getIdaula()) ? true : false;
    }

    private function validarFormatoHora($hora) {
        $expresion = "^(1[0-9]|2[0-3]):[0-5][0-9]$";
        $this->descripcion = "La hora no cumple con el formato HH:MM";
        return (preg_match($expresion, $hora)) ? true : false;
    }

}
