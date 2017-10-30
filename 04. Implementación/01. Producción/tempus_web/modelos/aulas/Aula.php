<?php

/**
 * 
 * */
class Aula 
{
    /** @var integer Identificador del aula en la base de datos. */
    private $idaula;
    
    /** @var string Nombre del aula. */
    private $nombre;
    
    /** @var string Sector donde se ubica el aula. */
    private $sector;
    
    /** @var mysqli_result Resultado de una consulta a la base de datos. */
    private $datos;
    
    /**
     * Constructor de clase. Cuando se indica un identificador de aula, se realiza
     * la búsqueda de la informacion en la base de datos. En caso contrario, se
     * hace la creacion del aula con los atributos nulos.
     * @param integer $idaula Identificador del aula (Opcional). 
     * */
    function __construct($idaula = null)
    {
        if ($idaula) {
            $consulta = "SELECT * FROM aula WHERE idaula = ".$idaula;
            $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
            if ($this->datos->num_rows > 0) {
                $fila = $this->datos->fetch_row();
                $this->idaula = $fila[0];
                $this->nombre = $fila[1];
                $this->sector = $fila[2];
                
            }
            $this->datos = null;
        }
    }
    
    /**
     * Devuelve el identificador del aula. 
     * @return integer $idaula
     */
    public function getIdaula()
    {
        return $this->idaula;
    }
    
    /**
     * Devuelve el nombre del aula.
     * @return string $nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Devuelve el sector del aula.
     * @return string $sector
     */
    public function getSector()
    {
        return $this->sector;
    }

    /**
     * Modifica el identificador del aula.
     * @param integer $idaula
     */
    public function setIdaula($idaula)
    {
        $this->idaula = $idaula;
    }
    
    /**
     * Modifica el nombre del aula.
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Modifica el sector del aula.
     * @param string $sector
     */
    public function setSector($sector)
    {
        $this->sector = $sector;
    }
    
    /**
     * Se realiza la creacion de una nueva aula en la base de datos. Primero se
     * verifica que no exista el aula mediante una busqueda. Si el aula existe,
     * se obtiene la informacion y se asigna a los atributos de clase. En caso
     * contrario, se crea y se obtiene su identificador.
     * @param string $nombre Nombre del Aula (Obligatorio).
     * @param string $sector Nombre del sector donde se ubica el Aula (Obligatorio).
     * */
    public function crear($nombre, $sector)
    {
        $this->buscar($nombre, $sector);
        if (is_null($this->idaula)) {
            ObjetoDatos::getInstancia()->ejecutarQuery("INSERT INTO aula VALUES (null,'".$nombre."','".$sector."')");
            $this->idaula = (Int) ObjetoDatos::getInstancia()->insert_id;
            $this->nombre = $nombre;
            $this->sector = $sector;
        }
    }
    
    /**
     * Realiza la búsqueda de un aula en la base de datos. Busca un aula usando
     * el sector y nombre. Si el aula se encuentra cargada en la base de datos,
     * se actualizan los atributos. En caso contrario, los atributos serán nulos.
     * La búsqueda en la base de datos se realiza igualando los parametros ingresados
     * con los campos de la tabla Aula. No se obtienen similares.
     * @param string $nombre Nombre del aula (Obligatorio).
     * @param string $sector Sector donde se ubica el aula (Obligatorio). 
     * */
    public function buscar($nombre, $sector) 
    {
        $consulta = "SELECT * FROM aula WHERE nombre = '".$nombre."' AND sector = '".$sector."' ";
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if ($this->datos->num_rows > 0) {
            $fila = $this->datos->fetch_row();
            $this->idaula = $fila[0];
            $this->sector = $fila[1];
            $this->nombre = $fila[2];
            
        } else {
            $this->idaula = null;
            $this->sector = null;
            $this->nombre = null;
        }
        $this->datos = null;
    }
    
}