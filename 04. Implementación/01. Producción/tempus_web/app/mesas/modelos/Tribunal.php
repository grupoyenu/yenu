<?php

class Tribunal {

    private $idTribunal;
    private $presidente;
    private $vocalPrimero;
    private $vocalSegundo;
    private $suplente;
    private $descripcion;

    public function __construct($id = NULL, $presidente = NULL, $vocal1 = NULL, $vocal2 = NULL, $suplente = NULL) {
        $this->setIdTribunal($id);
        $this->setPresidente($presidente);
        $this->setVocalPrimero($vocal1);
        $this->setVocalSegundo($vocal2);
        $this->setSuplente($suplente);
    }

    public function getIdTribunal() {
        return $this->idTribunal;
    }

    public function getPresidente() {
        return $this->presidente;
    }

    public function getVocalPrimero() {
        return $this->vocalPrimero;
    }

    public function getVocalSegundo() {
        return $this->vocalSegundo;
    }

    public function getSuplente() {
        return $this->suplente;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setIdTribunal($idTribunal) {
        $this->idTribunal = $idTribunal;
    }

    public function setPresidente($presidente) {
        $this->presidente = ($presidente) ? $presidente : NULL;
        $this->descripcion = ($presidente) ? "No se pudo hacer referencia al presidente" : $this->descripcion;
    }

    public function setVocalPrimero($vocalPrimero) {
        $this->vocalPrimero = ($vocalPrimero) ? $vocalPrimero : NULL;
        $this->descripcion = ($vocalPrimero) ? "No se pudo hacer referencia al vocal primero" : $this->descripcion;
    }

    public function setVocalSegundo($vocalSegundo) {
        $this->vocalSegundo = ($vocalSegundo) ? $vocalSegundo : NULL;
    }

    public function setSuplente($suplente) {
        $this->suplente = ($suplente) ? $suplente : NULL;
    }

    /**
     * Realiza la eliminacion del tribunal y de los docentes no asociados a ningun
     * tribunal. Cuando se elimina el tribunal, se eliminan los docentes asociados
     * solo si no forman parte de otro tribunal.
     */
    public function borrar() {
        if ($this->idTribunal) {
            $consulta = "DELETE t FROM tribunal t JOIN "
                    . "(SELECT idtribunal FROM tribunal WHERE idtribunal "
                    . "NOT IN (SELECT DISTINCT idtribunal FROM mesa_examen)) CAN "
                    . "ON CAN.idtribunal = t.idtribunal AND t.idtribunal = {$this->idTribunal}";
            $eliminacion = Conexion::getInstancia()->borrarConSubconsulta($consulta);
            $this->descripcion = Conexion::getInstancia()->getDescripcion();
            if ($eliminacion == 2) {
                return $this->borrarDocentes();
            }
            $this->descripcion = "No se realizó la eliminación del tribunal";
            return $eliminacion;
        }
        $this->descripcion = "No se pudo hacer referencia al tribunal";
        return 0;
    }

    /**
     * Realiza la eliminacion de los docentes que no tienen tribunal. Al borrar
     * el tribunal, es posible que algunos docentes queden asociado a otro tribunal
     * y algunos queden sin tribunal. Aquellos docentes sin tribunal son quitados
     * de la base de datos.
     */
    private function borrarDocentes() {
        $docentes = new Docentes();
        $eliminacion = $docentes->borrarSinTribunal();
        if ($eliminacion != 2) {
            $this->descripcion = "No se realizó la eliminación de los docentes asociados al tribunal";
        }
        return $eliminacion;
    }

    /**
     * Realiza la creacion del tribunal en la base de datos.
     * @return integer 0 si falla, 1 si no se crea o 2 si es correcta.
     */
    public function crear() {
        if ($this->presidente && $this->vocalPrimero) {
            $vocal2 = ($this->vocalSegundo) ? $this->vocalSegundo : "NULL";
            $suplente = ($this->suplente) ? $this->suplente : "NULL";
            $existe = $this->verificarExistencia($vocal2, $suplente);
            if ($existe == 1) {
                $values = "(NULL, {$this->presidente}, {$this->vocalPrimero}, {$vocal2}, {$suplente})";
                $creacion = Conexion::getInstancia()->insertar("tribunal", $values);
                $this->idTribunal = ($creacion == 2) ? (Int) Conexion::getInstancia()->insert_id : NULL;
                $this->descripcion = Conexion::getInstancia()->getDescripcion();
                return $creacion;
            }
            return $existe;
        }
        return 0;
    }

    /**
     * Realiza la modificacion en la base de datos de un tribunal.
     * @return integer 0 si falla, 1 si no afecta filas o 2 si es correcta.
     */
    public function modificar() {
        if ($this->presidente && $this->vocalPrimero) {
            $vocal2 = ($this->vocalSegundo) ? $this->vocalSegundo : "NULL";
            $suplente = ($this->suplente) ? $this->suplente : "NULL";
            $campos = "prediente={$this->presidente}, vocal1={$this->vocalPrimero}, vocal2={$vocal2}, suplente={$suplente}";
            $condicion = "idtribunal={$this->idTribunal}";
            $modificacion = Conexion::getInstancia()->modificar("tribunal", $campos, $condicion);
            $this->descripcion = Conexion::getInstancia()->getDescripcion();
            return $modificacion;
        }
        return 0;
    }

    private function validar() {
        if ($this->presidente == $this->vocalPrimero) {
            return false;
        }
    }

    private function verificarExistencia($vocal2, $suplente) {
        $consulta = "SELECT idtribunal FROM tribunal WHERE presidente = {$this->presidente} "
                . "AND vocal1 ={$this->vocalPrimero} AND vocal2 = {$vocal2} AND suplente={$suplente}";
        $resultado = Conexion::getInstancia()->obtener($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        if (gettype($resultado) == "array") {
            $this->descripcion = "Se verificó la existencia del tribunal";
            $this->idTribunal = $resultado['idtribunal'];
            return 2;
        }
        return $resultado;
    }

}
