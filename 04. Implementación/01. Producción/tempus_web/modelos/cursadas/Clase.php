<?php

/**
 * Esta corresponde con la tabla Clase de la base de datos. Contiene los metodos
 * necesarios para crear, borrar, buscar o modificar una clase. Se relaciona con
 * la clase Aula y Cursada.
 * 
 * Fecha de creaci�n: 22-10-2017.
 * 
 * @version 1.0
 * 
 * @author Oyarzo Mariela.
 * @author Quiroga Sandra.
 * @author Marquez Emanuel.
 * */
class Clase
{
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
    
    /** @var mysqli_result */
    private $datos;
    
    /**
     * Constructor de la clase. Cuando se indica un identificador de clase se 
     * obtiene la informaci�n desde la base de datos asignados a los atributos.
     * En caso contrario, se crea el objeto con los atributos nulos.
     * @var integer $idclase Identificador de la clase (Opcional).
     * */
    function __construct($idclase = null)
    {
        if ($idclase) {
            $consulta = "SELECT idclase, dia, DATE_FORMAT(desde, '%H:%i'), DATE_FORMAT(hasta, '%H:%i'), idaula, DATE_FORMAT(fechamod, '%d/%m/%Y %H:%i') FROM clase WHERE idclase = {$idclase} LIMIT 1";
            $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
            if ($this->datos->num_rows > 0) {
                $fila = $this->datos->fetch_row();
                $this->idclase = $fila[0];
                $this->dia = $fila[1];
                $this->desde = $fila[2];
                $this->hasta = $fila[3];
                $this->aula = new Aula($fila[4]);
                $this->fechamod = $fila[5];
            }
            $this->datos = null;
        }
    }
    
    /**
     * @return integer $idclase
     */
    public function getIdclase()
    {
        return $this->idclase;
    }

    /**
     * @return integer $dia
     */
    public function getDia()
    {
        return $this->dia;
    }

    /**
     * @return string $desde
     */
    public function getDesde()
    {
        return $this->desde;
    }

    /**
     * @return string $hasta
     */
    public function getHasta()
    {
        return $this->hasta;
    }

    /**
     * @return Aula $aula
     */
    public function getAula()
    {
        return $this->aula;
    }
    
    /**
     * @return string $fechamod Formato DD/MM/AAAA HH:MM.
     * */
    public function getFechamod()
    {
        return $this->fechamod;
    }

    /**
     * @param integer $idclase
     */
    public function setIdclase($idclase)
    {
        $this->idclase = $idclase;
    }

    /**
     * @param string $dia
     */
    public function setDia($dia)
    {
        $this->dia = $dia;
    }

    /**
     * @param string $desde
     */
    public function setDesde($desde)
    {
        $this->desde = $desde;
    }

    /**
     * @param string $hasta
     */
    public function setHasta($hasta)
    {
        $this->hasta = $hasta;
    }

    /**
     * @param Aula $aula
     */
    public function setAula($aula)
    {
        $this->aula = $aula;
    }
    
    /**
     * @param string $fechamod Formato DD/MM/AAAA HH:MM.
     * */
    public function setFechamod($fechamod)
    {
        $this->fechamod = $fechamod;
    }

    /**
     * Realiza la creaci�n de una nueva clase. 
     * @param integer $dia 1,2,3,4,5 o 6 (Obligatorio).
     * @param string $desde Hora en formato HH:MM (Obligatorio).
     * @param string $hasta Hora en formato HH:MM (Obligatorio).
     * @param Aula $aula Aula que debe contener su id cargado (Obligatorio).
     * */
    public function crear($dia, $desde, $hasta, $aula)
    {
        $this->buscar($dia, $desde, $hasta, $aula);
        if (is_null($this->idclase)) {
            /* No se ha encontrado la clase */
            $idaula = $aula->getIdaula();
            $consulta = "INSERT INTO clase VALUES (NULL,".$dia.",'".$desde."','".$hasta."',".$idaula.",NULL)";
            ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
            if (ObjetoDatos::getInstancia()->affected_rows > 0) {
                /* Se ha realizado la creacion. Se obtiene el id */
                $this->idclase = (Int) ObjetoDatos::getInstancia()->insert_id;
                $this->dia = $dia;
                $this->desde = $desde;
                $this->hasta = $hasta;
                $this->aula = $aula;
                $this->fechamod = null;
            } else {
                /* No se ha realizado la creacion. Se ponen nulos los atributos */
                $this->idclase = null;
                $this->dia = null;
                $this->desde = null;
                $this->hasta = null;
                $this->aula = null;
                $this->fechamod = null;
            }
        }
    }
    
    /**
     * Realiza la eliminaci�n de una clase en la base de datos. Si se hace la
     * elimiinacion correctamente, el idclase sera nulo. En caso contrario, el
     * idclase sera el recibido por parametro.
     * @param integer Identificador de la clase a borrar.
     * */
    public function borrar($idclase) 
    {
        $consulta = "DELETE FROM clase WHERE idclase=".$idclase;
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if ($this->datos->num_rows > 0) {
            $this->idclase = null;
        } else {
            $this->idclase = $idclase;
        }
        $this->datos = null;
    }
    
    /**
     * Busca una clase con las caracteristicas indicadas por parametro.
     * @param integer $dia 1,2,3,4,5 o 6 (Obligatorio).
     * @param string $desde Hora en formato HH:MM (Obligatorio).
     * @param string $hasta Hora en formato HH:MM (Obligatorio).
     * @param Aula $aula Aula donde se dicta la clase (Obligatorio).
     * */
    public function buscar($dia, $desde, $hasta, $aula) 
    {
        $idaula = $aula->getIdaula();
        $consulta = "SELECT * FROM clase WHERE dia =".$dia." AND desde = '".$desde."' AND hasta = '".$hasta."' AND idaula = ".$idaula;
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if ($this->datos->num_rows > 0) {
            /* Se ha encontrado una clase que cumple las condiciones */
            $fila = $this->datos->fetch_row();
            $this->idclase = $fila[0];
            $this->dia = $dia;
            $this->desde = $desde;
            $this->hasta = $hasta;
            $this->aula = $aula;
            $this->fechamod = $fila[5];
        } else {
            /* No se ha encontrado una clase que cumplas las condiciones */
            $this->idclase = null;
            $this->dia = null;
            $this->desde = null;
            $this->hasta = null;
            $this->aula = null;
        }
        $this->datos = null;
    }
    
    
    /**
     * Modifica un horario de clase. Cuando la modificacion se realiza correctamente
     * los datos estan cargados en el objeto. En caso contrario, los atributos seran
     * nulos. Los datos que se modifican son la hora de inicio, hora de fin, idaula 
     * y se coloca la fecha de modificacion por la actual.
     * @param $idclase integer Identificador de la clase a modifcar.
     * @param $dia integer Dia de la semana.
     * @param $desde string Hora de inicio de la clase en formato HH:MM.
     * @param $hasta string Hora de fin de la clase en formato HH:MM.
     * @param $aula Aula Aula donde se dicta la clase.
     * */
    public function modificar($idclase, $dia, $desde, $hasta, $aula)
    {
        $idaula = $aula->getIdaula();
        $consulta = "UPDATE clase SET desde='".$desde."', hasta='".$hasta."', idaula=".$idaula.", fechamod=NOW() WHERE idclase=".$idclase;
        ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if (ObjetoDatos::getInstancia()->affected_rows > 0) {
            /* Se ha realizado la modificacion. Se obtiene el id */
            $this->idclase = $idclase;
            $this->dia = $dia;
            $this->desde = $desde;
            $this->hasta = $hasta;
            $this->aula = $aula;
        } else {
            /* No se ha realizado la modificacion. Se ponen nulos los atributos */
            $this->idclase = null;
            $this->dia = null;
            $this->desde = null;
            $this->hasta = null;
            $this->aula = null;
        }
    }
    
}