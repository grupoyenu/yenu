<?php

/**
 * Description of Tribunal
 *
 * @author Emanuel
 */
class Tribunal {

    /** @var integer Identificador del tribunal en la base de datos */
    private $idtribunal;

    /** @var Docente Presidente del tribunal (Obligatorio) */
    private $presidente;

    /** @var Docente Vocal primero del tribunal (Obligatorio) */
    private $vocal1;

    /** @var Docente Vocal segundo del tribunal (Opcional) */
    private $vocal2;

    /** @var Docente Suplente del tribunal (Opcional) */
    private $suplente;

    /** @var string Descripcion para mostrar mensajes */
    private $descripcion;

    /** @var boolean Estado que indica la validez de la clase */
    private $valido;

    /**
     * Constructor de clase.
     * */
    function __construct($idtribunal = null) {
        $this->valido = false;
        if ($idtribunal) {
            $consulta = "SELECT t.idtribunal, p.iddocente idp, p.nombre nombrep, v.iddocente idv, v.nombre nombrev, t.vocal2, t.suplente 
                        FROM tribunal t 
                        INNER JOIN docente p ON t.presidente = p.iddocente 
                        INNER JOIN docente v ON t.vocal1 = v.iddocente 
                        WHERE idtribunal = $idtribunal";
            $rows = Conexion::getInstancia()->executeQuery($consulta);
            if (!empty($rows)) {
                $tribunal = $rows[0];
                $this->idtribunal = $tribunal['idtribunal'];
                $this->presidente = new Docente();
                $this->vocal1 = new Docente();
                $this->presidente->cargar($tribunal['idp'], $tribunal['nombrep']);
                $this->vocal1->cargar($tribunal['idv'], $tribunal['nombrev']);
                $this->vocal2 = ($tribunal['vocal2']) ? new Docente($tribunal['vocal2']) : NULL;
                $this->suplente = ($tribunal['suplente']) ? new Docente($tribunal['suplente']) : NULL;
                $this->valido = true;
            }
        }
    }

    public function constructor($presidente, $vocal1, $vocal2 = null, $suplente = null, $idtribunal = null) {
        $this->valido = false;
        if ($presidente && $vocal1) {
            $this->idtribunal = $idtribunal;
            $this->presidente = $presidente;
            $this->vocal1 = $vocal1;
            $this->vocal2 = $vocal2;
            $this->suplente = $suplente;
            $this->valido = true;
            return true;
        }
        $this->descripcion = "El tribunal no contiene la información obligatoria";
        return false;
    }

    /**
     * Devuelve el identificador del tribunal.
     * @return integer $idtribunal
     */
    public function getIdtribunal() {
        return $this->idtribunal;
    }

    /**
     * Devuelve el presidente del tribunal.
     * @return Docente $presidente
     */
    public function getPresidente() {
        return $this->presidente;
    }

    /**
     * Devuelve el vocal primero del tribunal.
     * @return Docente $vocal1
     */
    public function getVocal1() {
        return $this->vocal1;
    }

    /**
     * Devuelve el vocal segundo del tribunal.
     * @return Docente $vocal2
     */
    public function getVocal2() {
        return $this->vocal2;
    }

    /**
     * Devuelve el suplente del tribunal.
     * @return Docente $suplente
     * @author Marquez Emanuel.
     */
    public function getSuplente() {
        return $this->suplente;
    }

    /**
     * Devuelve la descripcion sobre el docente.
     * @return string Descripcion sobre el estado u operacion.
     */
    public function getDescripcion() {
        return $this->descripcion;
    }

    /**
     * Devuelve el estado del docebte para saber su validez o resultado de 
     * operacion.
     * @return boolean Estado del docente.
     */
    public function getEstado() {
        return $this->valido;
    }

    /**
     * Modifica el identificador del tribunal.
     * @param integer $idtribunal
     */
    public function setIdtribunal($idtribunal) {
        $this->idtribunal = $idtribunal;
    }

    /**
     * Modifica el presidente del tribuanal.
     * @param Docente $presidente
     */
    public function setPresidente($presidente) {
        $this->presidente = ($presidente) ? $presidente : NULL;
    }

    /**
     * Modifica el vocal primer del tribunal.
     * @param Docente $vocal1
     */
    public function setVocal1($vocal1) {
        $this->vocal1 = ($vocal1) ? $vocal1 : NULL;
    }

    /**
     * Modifica el vocal segundo del tribunal.
     * @param Docente $vocal2
     */
    public function setVocal2($vocal2) {
        $this->vocal2 = ($vocal2) ? $vocal2 : NULL;
    }

    /**
     * Modifica el suplente de tribunal.
     * @param Docente $suplente
     */
    public function setSuplente($suplente) {
        $this->suplente = ($suplente) ? $suplente : NULL;
    }

    public function buscar() {
        if ($this->validarIdentificadorDocentes()) {
            $consulta = "SELECT t.idtribunal, p.iddocente idp, p.nombre nombrep, v.iddocente idv, v.nombre nombrev, t.vocal2, t.suplente 
                        FROM tribunal t 
                        INNER JOIN docente p ON t.presidente = p.iddocente AND p.iddocente = {$this->presidente->getIdDocente()} 
                        INNER JOIN docente v ON t.vocal1 = v.iddocente AND v.iddocente = {$this->vocal1->getIdDocente()} ";
            if ($this->vocal2 && $this->vocal2->getIdDocente()) {
                $consulta = $consulta . " INNER JOIN docente v2 ON t.vocal2 = v2.iddocente AND v2.iddocente = {$this->vocal2->getIdDocente()} ";
            }
            if ($this->suplente && $this->suplente->getIdDocente()) {
                $consulta = $consulta . " INNER JOIN docente s ON t.suplente = s.iddocente AND s.iddocente = {$this->suplente->getIdDocente()} ";
            }
            $rows = Conexion::getInstancia()->executeQuery($consulta);
            return $rows;
        }
        return array();
    }

    public function crear() {
        $rows = $this->buscar();
        if (!empty($rows)) {
            $this->descripcion = "Se encontró un tribunal que coincide con el ingresado";
            return 3;
        }
        if (!$this->validarDocentesDistintos()) {
            return 3;
        }
        $values = "(NULL, {$this->presidente->getIdDocente()}, {$this->vocal1->getIdDocente()}, ";
        $values = ($this->vocal2 && $this->vocal2->getIdDocente()) ? $values . " {$this->vocal2->getIdDocente()}, " : $values . " NULL, ";
        $values = ($this->suplente && $this->suplente->getIdDocente()) ? $values . " {$this->suplente->getIdDocente()}) " : $values . " NULL) ";
        $creacion = Conexion::getInstancia()->executeInsert("tribunal", $values);
        $this->idtribunal = ($creacion == 2) ? (Int) Conexion::getInstancia()->insert_id : NULL;
        $this->descripcion = Conexion::getInstancia()->getDescripcion() . " del tribunal";
    }

    public function modificar() {
        if (!$this->idtribunal || !$this->validarIdentificadorDocentes() || !$this->validarDocentesDistintos()) {
            return 3;
        }
        $idvocal2 = ($this->vocal2 && $this->vocal2->getIdDocente()) ? $this->vocal2->getIdDocente() : "NULL";
        $idsuplente = ($this->vocal2 && $this->suplente && $this->suplente->getIdDocente()) ? $this->suplente->getIdDocente() : "NULL";
        $consulta = "UPDATE tribunal SET presidente={$this->presidente->getIdDocente()}, vocal1={$this->vocal1->getIdDocente()}, vocal2={$idvocal2}, "
                . "suplente={$idsuplente} WHERE idtribunal=" . $this->idtribunal;
        if (Conexion::getInstancia()->executeUpdate($consulta)) {
            $this->descripcion = "Se realizó la modificación del tribunal";
            return 2;
        }
        $this->descripcion = "No se realizó la modificación del tribunal";
        return 1;
    }

    private function validarIdentificadorDocentes() {
        if (!$this->presidente || !$this->presidente->getIdDocente()) {
            $this->descripcion = "El tribunal no contiene presidente";
            return false;
        }
        if (!$this->vocal1 || !$this->vocal1->getIdDocente()) {
            $this->descripcion = "El tribunal no contiene vocal 1";
            return false;
        }
        return true;
    }

    private function validarDocentesDistintos() {
        if ($this->compararDocente($this->presidente, $this->vocal1)) {
            return false;
        }
        if ($this->vocal2) {
            if ($this->compararDocente($this->vocal2, $this->presidente)) {
                return false;
            }
            if ($this->compararDocente($this->vocal2, $this->vocal1)) {
                return false;
            }
            if ($this->suplente && $this->compararDocente($this->suplente, $this->presidente)) {
                return false;
            }
            if ($this->suplente && $this->compararDocente($this->suplente, $this->vocal1)) {
                return false;
            }
            if ($this->suplente && $this->compararDocente($this->suplente, $this->vocal2)) {
                return false;
            }
        }
        return true;
    }

    private function compararDocente($docente1, $docente2) {
        if ($docente1->getIdDocente() == $docente2->getIdDocente()) {
            $this->descripcion = "El tribunal contiene docentes que coinciden";
            return true;
        }
        return false;
    }

    function __destruct() {
        unset($this);
    }

}
