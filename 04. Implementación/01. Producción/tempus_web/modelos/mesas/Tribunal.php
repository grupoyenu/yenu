<?php
    require_once 'Docente.php';

/**
 * 
 * @author Oyarzo Mariela.
 * @author Quiroga Sandra.
 * @author Marquez Emanuel.
 * */
class Tribunal
{
    /** @var integer $idtribunal */
    private $idtribunal;
    
    /** @var Docente $presidente */
    private $presidente;
    
    /** @var Docente $vocal1 */
    private $vocal1;
    
    /** @var Docente $vocal2 */
    private $vocal2;
    
    /** @var Docente $suplente */
    private $suplente;
    
    /** @var mysqli_result $datos Resultado de la consulta a la base de datos. */
    private $datos;
    
    /**
     * Constructor de clase.
     * @author Marquez Emanuel.
     * */
    function __construct($idtribunal = null)
    {
        if ($idtribunal) {
            $consulta = "SELECT * FROM tribunal WHERE idtribunal = ".$idtribunal;
            $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
            if ($this->datos->num_rows > 0) {
                $fila = $this->datos->fetch_row();
                $this->idtribunal = $fila[0];
                $this->presidente = new Docente($fila[1]);
                $this->vocal1 = new Docente($fila[2]);
                /* Coloca al vocal2 y suplente en nulos por si quedan asignados de un tribunal anterior */
                $this->vocal2 = null;
                $this->suplente = null;
                if($fila[3]) {
                    $this->vocal2 = new Docente($fila[3]);
                }
                if($fila[4]) {
                    $this->suplente = new Docente($fila[4]);
                }
            }
            $this->datos = null;
        }
    }
    
    /**
     * Devuelve el identificador del tribunal.
     * @return integer $idtribunal
     * @author Marquez Emanuel.
     */
    public function getIdtribunal()
    {
        return $this->idtribunal;
    }

    /**
     * Devuelve el presidente del tribunal.
     * @return Docente $presidente
     * @author Marquez Emanuel.
     */
    public function getPresidente()
    {
        return $this->presidente;
    }

    /**
     * Devuelve el vocal primero del tribunal.
     * @return Docente $vocal1
     * @author Marquez Emanuel.
     */
    public function getVocal1()
    {
        return $this->vocal1;
    }

    /**
     * Devuelve el vocal segundo del tribunal.
     * @return Docente $vocal2
     * @author Marquez Emanuel.
     */
    public function getVocal2()
    {
        return $this->vocal2;
    }

    /**
     * Devuelve el suplente del tribunal.
     * @return Docente $suplente
     * @author Marquez Emanuel.
     */
    public function getSuplente()
    {
        return $this->suplente;
    }

    /**
     * Modifica el identificador del tribunal.
     * @param integer $idtribunal
     * @author Marquez Emanuel.
     */
    public function setIdtribunal($idtribunal)
    {
        $this->idtribunal = $idtribunal;
    }

    /**
     * Modifica el presidente del tribuanal.
     * @param Docente $presidente
     * @author Marquez Emanuel.
     */
    public function setPresidente($presidente)
    {
        $this->presidente = $presidente;
    }

    /**
     * Modifica el vocal primer del tribunal.
     * @param Docente $vocal1
     * @author Marquez Emanuel.
     */
    public function setVocal1($vocal1)
    {
        $this->vocal1 = $vocal1;
    }

    /**
     * Modifica el vocal segundo del tribunal.
     * @param Docente $vocal2
     * @author Marquez Emanuel.
     */
    public function setVocal2($vocal2)
    {
        $this->vocal2 = $vocal2;
    }

    /**
     * Modifica el suplente de tribunal.
     * @param Docente $suplente
     * @author Marquez Emanuel.
     */
    public function setSuplente($suplente)
    {
        $this->suplente = $suplente;
    }
    
    /**
     * Realiza la creacion de un nuevo tribunal en la base de datos.
     * @param integer $presidente Identificador del docente que ser� presidente (Obligatorio).
     * @param integer $vocal1 Identificador del docente que ser� vocal1 (Obligatorio).
     * @param integer $vocal2 Identificador del docente que ser� vocal2 (Opcional).
     * @param integer $suplente Identificador del docente que ser� suplente (Opcional).
     * @author Marquez Emanuel.
     * */
    public function crear($presidente, $vocal1, $vocal2 = null, $suplente = null)
    {
        $this->buscar($presidente, $vocal1, $vocal2, $suplente);
        
        if(is_null($this->idtribunal)) {
            /* No se ha encontrado un tribunal que contenga a los docentes indicados */
            $consulta =  "INSERT INTO tribunal VALUES (null, ".$presidente.",".$vocal1.",";
            if($vocal2) {
                $consulta = $consulta.$vocal2.",";
            } else {
                $consulta = $consulta."NULL,";
            }
            
            if($suplente) {
                $consulta = $consulta.$suplente.")";
            } else {
                $consulta = $consulta."NULL)";
            }
            
            ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
            $this->idtribunal = (Int) ObjetoDatos::getInstancia()->insert_id;
        }
    }
    
    public function borrar()
    {
        
    }

    /**
     * Realiza la busqueda de un tribunal a partir de los docentes que lo componen. Si se
     * encuentra el tribunal, se obtiene toda la informacion del mismo (incluyendo datos de
     * docentes). Si el tribunal no se encuentra, todos los datos ser�n nulos.
     * @var integer $presidente Identificador del presidente.
     * @var integer $vocal1 Identificador del vocal primero.
     * @var integer $vocal2 Identificador del vocal segundo (null por defecto).
     * @var integer $suplente Identificador del susplente (null por defecto).
     * @author Marquez Emanuel.
     * */
    public function buscar($presidente, $vocal1, $vocal2 = null, $suplente = null)
    {
        /* Prepara la consulta segun los parametros recibidos */
        $consulta = "SELECT * FROM tribunal WHERE presidente = ".$presidente." AND vocal1 = ".$vocal1." ";
        
        if($vocal2) {
            /* Hay vocal, se debe saber si hay suplente */
            $consulta = $consulta." AND vocal2 = ".$vocal2;
            if($suplente) {
                $consulta = $consulta. " AND suplente = ".$suplente;
            } else {
                $consulta = $consulta. " AND suplente IS NULL";
            }
        } else {
            /* Si no hay vocal2 no deberia haber suplente */
            $consulta = $consulta. " AND vocal2 IS NULL AND suplente IS NULL";
        }
       
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if ($this->datos->num_rows > 0) {
            
            $fila = $this->datos->fetch_row();
            $this->idtribunal = $fila[0];
            $this->presidente = new Docente($fila[1]);
            $this->vocal1 = new Docente($fila[2]);
            /* Coloca al vocal2 y suplente en nulos por si quedan asignados de un tribunal anterior */
            $this->vocal2 = null;
            $this->suplente = null;
            if($fila[3]) {
                $this->vocal2 = new Docente($fila[3]);
            }
            if($fila[4]) {
                $this->suplente = new Docente($fila[4]);
            }
            
        } else {
            $this->limpiar();
        }
        $this->datos = null;
    }
    
    /**
     * Coloca cada uno de los atributos del tribunal en nulo.
     * @author Marquez Emanuel.
     * */
    private function limpiar() 
    {
        $this->idtribunal = null;
        $this->presidente = null;
        $this->vocal1 = null;
        $this->vocal2 = null;
        $this->suplente = null;
        $this->datos = null;
    }
    
    /**
     * Realiza la modificaci�n del tribunal indicado. Cuando la operaci�n se
     * hace exitosamente, se asignan los parametros al tribunal y se devuelve
     * un mensaje. En caso contrario, se colocan en nulo los atributos del 
     * tribunal y se devuelve un mensaje.
     * @param integer $idtribunal Identificador del tribunal a modificar.
     * @param Docente $presidente Docente que cumple el rol de presidente.
     * @param Docente $vocal1 Docente que cumple el rol del vocal primero.
     * @param Docente $vocal2 Docente que cumple el rol del vocal segundo.
     * @param Docente $suplente Docente que cumple el rol del suplente.
     * @return string Mensaje con el resultado de la operaci�n.
     * */
    public function modificar($idtribunal, $presidente, $vocal1, $vocal2, $suplente)
    {
        if($idtribunal) {
            if($presidente && $vocal1) {
                
                $idpresidente = $presidente->getIdDocente();
                $idvocal1 = $vocal1->getIdDocente();
                $idvocal2 = "null";
                $idsuplente = "null";
                if($vocal2) {
                    $idvocal2 = $vocal2->getIdDocente();
                    if($suplente) {
                        $idsuplente = $suplente->getIdDocente();
                    }
                }
                $consulta = "UPDATE tribunal SET presidente={$idpresidente}, vocal1={$idvocal1}, vocal2={$idvocal2}, suplente={$idsuplente} WHERE idtribunal=".$idtribunal;
                ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
                if (ObjetoDatos::getInstancia()->affected_rows > 0) {
                    $this->idtribunal = $idtribunal;
                    $this->presidente = $presidente;
                    $this->vocal1 = $vocal1;
                    $this->vocal2 = $vocal2;
                    $this->suplente = $suplente;
                    return "Se ha modificado el tribunal correctamente";
                } else {
                    $this->limpiar();
                    return "No se ha modificado el tribunal correctamente";
                }
            }
            $this->limpiar();
            return "No se obtuvo la informaci�n del presidente o vocal primero, necesaria para realizar la modificaci�n del tribunal";
        }
        $this->limpiar();
        return "No se obtuvo la informaci�n necesaria para realizar la modificaci�n del tribunal";
    }
    
}

?>