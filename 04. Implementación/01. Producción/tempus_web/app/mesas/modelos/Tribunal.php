<?php

class Tribunal {

    private $idTribunal;
    private $presidente;
    private $vocalPrimero;
    private $vocalSegundo;
    private $suplente;
    private $descripcion;
    private $TABLA = "tribunal";

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
        $this->presidente = $presidente;
    }

    public function setVocalPrimero($vocalPrimero) {
        $this->vocalPrimero = $vocalPrimero;
    }

    public function setVocalSegundo($vocalSegundo) {
        $this->vocalSegundo = $vocalSegundo;
    }

    public function setSuplente($suplente) {
        $this->suplente = $suplente;
    }

    public function crear() {
        
    }

    public function modificar() {
        
    }

    public function obtener() {
        if ($this->idTribunal) {
            $consulta = "SELECT t.idtribunal, pr.iddocente idpre, pr.nombre nompre, vp.iddocente idvop, vp.nombre nomvop, vs.iddocente idvos, vs.nombre nomvos, su.iddocente idsup, su.nombre nomsup "
                    . "FROM {$this->TABLA} t "
                    . "LEFT JOIN docente pr ON t.presidente = pr.iddocente "
                    . "LEFT JOIN docente vp ON t.vocal1 = vp.iddocente "
                    . "LEFT JOIN docente vs ON t.vocal2 = vs.iddocente "
                    . "LEFT JOIN docente su ON t.suplente = su.iddocente "
                    . "WHERE idtribunal = {$this->idTribunal}";
            $fila = Conexion::getInstancia()->obtener($consulta);
            if (!is_null($fila)) {
                $this->docentes[0] = ($fila['idpre']) ? new Docente(array($fila['idpre'], $fila['nompre'])) : NULL;
                $this->docentes[1] = ($fila['idvop']) ? new Docente(array($fila['idvop'], $fila['nomvop'])) : NULL;
                $this->docentes[2] = ($fila['idvos']) ? new Docente(array($fila['idvos'], $fila['nomvos'])) : NULL;
                $this->docentes[3] = ($fila['idsup']) ? new Docente(array($fila['idsup'], $fila['nomsup'])) : NULL;
                return 2;
            }
            return 1;
        }
        return 0;
    }

}
