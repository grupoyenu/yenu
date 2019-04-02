<?php

/**
 * Permite obtener operar con los registros de Clase almacenados en la base 
 * de datos. 
 * Relacion con BD: Clase.
 * Campos: idclase, dia, desde, hasta, idaula, fechamod.
 *
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
class Clase {

    /** @var integer */
    private $idclase;

    /** @var integer Numero del dia de la semana (1,2,3,4,5 o 6) */
    private $dia;

    /** @var string Hora de inicio en formato HH:MM */
    private $desde;

    /** @var string Hora de fin en formato HH:MM */
    private $hasta;

    /** @var Aula */
    private $aula;

    /** @var string Fecha de modificacion de clase DD/MM/AAAA HH:MM */
    private $fechamod;

    /** @var string Descripcion para mostrar mensajes */
    private $descripcion;

    /** @var boolean Estado que indica la validez de la clase */
    private $estado;

    /**
     * Constructor de la clase. Cuando se indica un identificador se 
     * busca la informacion en la base de datos y se actualizan los atributos,
     * siendo valido. Cuando no se obtiene un registro la clase no sera valida. 
     * Al no indicar idclase, se crea un objeto vacio.
     * @param integer $idclase Identificador de la clase o null.
     */
    function __construct($idclase = null) {
        $this->estado = false;
        if ($idclase) {
            $consulta = "SELECT c.idclase, c.dia, c.desde, c.hasta, c.idaula, a.nombre, a.sector, c.fechamod "
                    . "FROM clase c, aula a WHERE c.idaula = a.idaula AND idclase = $idclase";
            $rows = Conexion::getInstancia()->executeQuery($consulta);
            if (!empty($rows)) {
                $clase = $rows[0];
                $aula = new Aula();
                $aula->cargar($clase['nombre'], $clase['sector'], $clase['idaula']);
                $this->cargar($clase['idclase'], $clase['dia'], $clase['desde'], $clase['hasta'], $aula, $clase['fechamod']);
            }
        }
    }

    /**
     * Constructor alternativo de la clase. Permite establecer la informacion 
     * de la clase y la validez de la misma. Se debe utilizar cuando es necesario 
     * realizar INSERT o UPDATE a la base de datos.
     * @param integer $dia Dia del 1 al 6.
     * @param string $desde Hora de inicio en formato HH:MM.
     * @param string $hasta Hora de fin en formato HH:MM.
     * @param Aula $aula Aula donde se dicta la clase con su identificador.
     * @param integer $idclase Identificador de la clase.
     * @param string $fechamod Fecha de modificacion de la clase.
     */
    public function constructor($dia, $desde, $hasta, $aula, $idclase = null, $fechamod = "NULL") {
        $this->estado = false;
        if (!$this->setDia($dia) || !$this->setDesde($desde) || !$this->setHasta($hasta)) {
            return false;
        }
        if (!$this->validarHorarios($desde, $hasta)) {
            $this->descripcion = "La hora de inicio debe ser menor a la hora de fin";
            return false;
        }
        if ($this->setAula($aula)) {
            $this->estado = true;
            $this->idclase = $idclase;
            $this->fechamod = $fechamod;
            return true;
        }
        return false;
    }

    public function cargar($idclase, $dia, $desde, $hasta, $aula, $fechamod) {
        $this->estado = true;
        $this->dia = $dia;
        $this->desde = $desde;
        $this->hasta = $hasta;
        $this->aula = $aula;
        $this->idclase = $idclase;
        $this->fechamod = $fechamod;
    }

    /**
     * @return integer $idclase
     */
    public function getIdclase() {
        return $this->idclase;
    }

    /**
     * @return integer $dia
     */
    public function getDia() {
        return $this->dia;
    }

    /**
     * @return string $desde
     */
    public function getDesde() {
        return $this->desde;
    }

    /**
     * @return string $hasta
     */
    public function getHasta() {
        return $this->hasta;
    }

    /**
     * @return Aula $aula
     */
    public function getAula() {
        return $this->aula;
    }

    /**
     * Devuelve la fecha de modificacion de la clase.
     * @return string $fechamod Formato DD/MM/AAAA HH:MM.
     * */
    public function getFechamod() {
        return ($this->fechamod == "NULL") ? NULL : $this->fechamod;
    }

    /**
     * Devuelve la descripcion sobre la clase.
     * @return string Descripcion sobre el estado u operacion.
     */
    public function getDescripcion() {
        return $this->descripcion;
    }

    /**
     * Devuelve el estado de la clase para saber su validez o resultado de operacion.
     * @return boolean Estado del rol.
     */
    public function getEstado() {
        return $this->estado;
    }

    /**
     * @param integer $idclase
     */
    public function setIdclase($idclase) {
        $this->idclase = $idclase;
    }

    /**
     * @param string $dia
     */
    public function setDia($dia) {
        if ($this->validarFormatoDia($dia)) {
            $this->dia = $dia;
            return true;
        }
        return false;
    }

    /**
     * @param string $desde
     */
    public function setDesde($desde) {
        if ($this->validarFormatoHora($desde)) {
            if (!$this->hasta) {
                $this->desde = $desde;
                return true;
            }
            if ($this->validarHorarios($desde, $this->hasta)) {
                $this->desde = $desde;
                return true;
            }
        }
        return false;
    }

    /**
     * @param string $hasta
     */
    public function setHasta($hasta) {
        if ($this->validarFormatoHora($hasta)) {
            if (!$this->desde) {
                $this->hasta = $hasta;
                return true;
            }
            if ($this->validarHorarios($this->desde, $hasta)) {
                $this->hasta = $hasta;
                return true;
            }
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
        return false;
    }

    /**
     * @param string $fechamod Formato DD/MM/AAAA HH:MM.
     * */
    public function setFechamod($fechamod) {
        $this->fechamod = ($fechamod) ? $fechamod : "NULL";
    }

    /**
     * Realiza la eliminacion de una clase solo si contiene el idclase. El metodo
     * retorna true en caso de realizar la eliminacion o false en caso contrario. 
     * En ambos casos se indica una descripcion con un mensaje a mostrar.
     */
    public function borrar() {
        if ($this->idclase) {
            $where = "idclase=" . $this->idclase;
            $eliminacion = Conexion::getInstancia()->executeDelete("clase", $where);
            $this->descripcion = Conexion::getInstancia()->getDescripcion() . " de clase";
            return $eliminacion;
        }
        $this->descripcion = "La clase no contiene toda la información";
        return 0;
    }

    /**
     * Busca una clase con las caracteristicas indicadas por parametro.
     * @param integer $dia 1,2,3,4,5 o 6 (Obligatorio).
     * @param string $desde Hora en formato HH:MM (Obligatorio).
     * @param string $hasta Hora en formato HH:MM (Obligatorio).
     * @param Aula $aula Aula donde se dicta la clase (Obligatorio).
     * */
    public function buscar() {
        if ($this->completa()) {
            $idaula = $this->aula->getIdaula();
            $consulta = "SELECT c.idclase, c.dia, c.desde, c.hasta, c.idaula, a.nombre, a.sector, c.fechamod "
                    . "FROM clase c, aula a WHERE c.idaula = a.idaula AND c.dia =" . $this->dia
                    . " AND c.desde = '" . $this->desde . "' AND c.hasta = '" . $this->hasta . "' AND c.idaula = " . $idaula;
            $rows = Conexion::getInstancia()->executeQuery($consulta);
            return $rows;
        }
        return NULL;
    }

    /**
     * Verifica que la clase contenga todos los datos necesarios para realizar
     * consultas y actualizaciones en la base de datos. Retorna true si contiene
     * identificador, dia, hora inicio, hora de fin y aula con identificador. En
     * caso contrario retorna false.
     * @return boolean True o false.
     */
    private function completa() {
        $this->descripcion = "La clase no contiene toda la información";
        return ($this->dia && $this->desde && $this->hasta && $this->aula) ? true : false;
    }

    /**
     * Cuenta la cantidad de carreras en las que se dicta la clase. Esto se debe a que una clase
     * correspondiente a una asignatura, puede ser dictada en mas de una carrera a la vez.
     * @param integer $idclase Identificador de la clase.
     * @return integer Cantidad de carreras en las que aparece la clase.
     * */
    public function contarCarreras($idclase) {
        $consulta = "SELECT COUNT(idcarrera) cantidad FROM cursada WHERE idclase=" . $idclase;
        $rows = Conexion::getInstancia()->executeQuery($consulta);
        if (!empty(rows)) {
            $row = $rows[0];
            return $row['cantidad'];
        }
        return 0;
    }

    /**
     * Realiza la creación de una nueva clase.
     * @param integer $dia 1,2,3,4,5 o 6 (Obligatorio).
     * @param string $desde Hora en formato HH:MM (Obligatorio).
     * @param string $hasta Hora en formato HH:MM (Obligatorio).
     * @param Aula $aula Aula que debe contener su id cargado (Obligatorio).
     * */
    public function crear() {
        $rows = $this->buscar();
        if (!empty($rows)) {
            $this->descripcion = "Se encontró una clase que coincide con la ingresada";
            $this->idclase = $rows[0]['idclase'];
            return 3;
        }
        if (!is_null($rows)) {
            $values = "(NULL," . $this->dia . ",'" . $this->desde . "','" . $this->hasta . "'," . $this->aula->getIdaula() . ",NULL)";
            $creacion = Conexion::getInstancia()->executeInsert("clase", $values);
            $this->idclase = ($creacion == 2) ? (Int) Conexion::getInstancia()->insert_id : NULL;
            $this->descripcion = Conexion::getInstancia()->getDescripcion() . " de la clase";
            return $creacion;
        }
        return 0;
    }

    /**
     * Modifica un horario de clase. Cuando la modificacion se realiza correctamente los datos estan
     * cargados en el objeto. En caso contrario, los atributos seran nulos. Los datos que se 
     * modifican son la hora de inicio, hora de fin, idaula y se coloca la fecha de modificacion 
     * por la actual.
     * @param $idclase integer Identificador de la clase a modifcar.
     * @param $dia integer Dia de la semana.
     * @param $desde string Hora de inicio de la clase en formato HH:MM.
     * @param $hasta string Hora de fin de la clase en formato HH:MM.
     * @param $aula Aula Aula donde se dicta la clase.
     * */
    public function modificar($idclase, $dia, $desde, $hasta, $aula) {
        $idaula = $aula->getIdaula();
        $consulta = "UPDATE clase SET desde='" . $desde . "', hasta='" . $hasta . "', idaula=" . $idaula . ", fechamod=NOW() WHERE idclase=" . $idclase;
        ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if (ObjetoDatos::getInstancia()->affected_rows > 0) {
            $this->cargar($idclase, $dia, $desde, $hasta, $aula, null);
        } else {
            $this->cargar(null, null, null, null, null, null);
        }
    }

    private function validarFormatoDia($dia) {
        $expresion = "^[1-6]$";
        $this->descripcion = "El dia no cumple con el formato";
        return (preg_match($expresion, $dia)) ? true : false;
    }

    private function validarFormatoHora($hora) {
        $expresion = "^(1[0-9]|2[0-3]):[0-5][0-9]$";
        $this->descripcion = "La hora no cumple con el formato HH:MM";
        return (preg_match($expresion, $hora)) ? true : false;
    }

    private function validarAula($aula) {
        $this->descripcion = "El aula no se considera valida";
        return ($aula && $aula->getIdaula()) ? true : false;
    }

    private function validarHorarios($inicio, $fin) {
        $horaInicio = substr($inicio, 0, 2);
        $horaFin = substr($fin, 0, 2);
        if ($horaInicio < $horaFin) {
            return true;
        } else {
            if ($horaInicio == $horaFin) {
                $minutosInicio = substr($inicio, 3, 2);
                $minutosFin = substr($fin, 3, 2);
                return ($minutosInicio < $minutosFin) ? true : false;
            }
            return false;
        }
    }

}
