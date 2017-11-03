<?php

/**
 * Esta corresponde con la tabla Clase de la base de datos. Contiene los metodos
 * necesarios para crear, borrar, buscar o modificar una clase. Se relaciona con
 * la clase Aula y Cursada.
 * 
 * Fecha de creación: 22-10-2017.
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
    
    /** @var mysqli_result */
    private $datos;
    
    /**
     * Constructor de la clase. Cuando se indica un identificador de clase se 
     * obtiene la información desde la base de datos asignados a los atributos.
     * En caso contrario, se crea el objeto con los atributos nulos.
     * @var integer $idclase Identificador de la clase (Opcional).
     * */
    function __construct($idclase = null)
    {
       if ($idclase) {
           $consulta = "SELECT idclase, dia, DATE_FORMAT(desde, '%H:%i'), DATE_FORMAT(hasta, '%H:%i'), idaula FROM clase WHERE idclase = {$idclase} LIMIT 1";
           $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
           if ($this->datos->num_rows > 0) {
               $fila = $this->datos->fetch_row();
               $this->idclase = $fila[0];
               $this->dia = $fila[1];
               $this->desde = $fila[2];
               $this->hasta = $fila[3];
               $this->aula = new Aula($fila[4]);
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
     * Realiza la creación de una nueva clase. 
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
            $consulta = "INSERT INTO clase VALUES (NULL,".$dia.",'".$desde."','".$hasta."',".$idaula.")";
            ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
            if (ObjetoDatos::getInstancia()->affected_rows > 0) {
                /* Se ha realizado la creacion. Se obtiene el id */
                $this->idclase = (Int) ObjetoDatos::getInstancia()->insert_id;
                $this->dia = $dia;
                $this->desde = $desde;
                $this->hasta = $hasta;
                $this->aula = $aula;
            } else {
                /* No se ha realizado la creacion. Se ponen nulos los atributos */
                $this->idclase = null;
                $this->dia = null;
                $this->desde = null;
                $this->hasta = null;
                $this->aula = null;
            }
        }
    }
    
    /**
     * Realiza la eliminación de una clase en la base de datos.
     * @param 
     * */
    public function borrar($idclase) 
    {
        
    }
    
    /**
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
     * 
     * */
    public function modificar()
    {}
    
}