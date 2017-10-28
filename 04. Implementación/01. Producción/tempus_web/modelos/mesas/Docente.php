<?php
require_once '../lib/conf/ObjetoDatos.php';

/**
 * Esta clase corresponde con la tabla Docente de la base de datos.
 * Contiene los metodos necesarios para crear, borrar, buscar o modificar un docente.
 * Se relaciona con la clase Tribunal. (Un tribunal posee docentes).
 * 
 * Fecha de creaci�n: 18-10-2017.
 * 
 * @version 1.0
 * 
 * @author Oyarzo Mariela.
 * @author Quiroga Sandra.
 * @author Marquez Emanuel.
 * */
class Docente 
{
    /** @var integer $iddocente */
    private $iddocente;
    
    /** @var string $nombre */
    private $nombre;
    
    /** @var mysqli_result $datos */
    private $datos;
        
    /**
     * Constructor de la clase. Si se introduce el identificador del docente,
     * se obtiene su informacion desde la base de datos. En caso contrario, se
     * crea con los atributos nulos.
     * @param $iddocente Integer Recibe el identificador del docente.
     * */
    function __construct($iddocente = null)
    {
        if($iddocente) {
            $consulta = "SELECT * FROM docente WHERE iddocente = ".$iddocente." LIMIT 1";
            $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
            if ($this->datos->num_rows > 0) {
                /* Se ha encontrado un docente que cumple la condicion de busqueda */
                $fila = $this->datos->fetch_row();
                $this->iddocente = $fila[0];
                $this->nombre = $fila[1];
            }
            $this->datos = null;
        }
    }
    
    /**
     * Devuelve el identificador del docente. 
     * */
    public function getIdDocente() 
    {
        return $this->iddocente;
    }
    
    /**
     * Devuelve el nombre del docente.
     * */
    public function getNombre()
    {
        return $this->nombre;
    }
    
    /**
     * Modifica el identificador del docente.
     * */
    public function setIdDocente($iddocente)
    {
        $this->iddocente = $iddocente;
    }

    /**
     * Modifica el nombre del docente.
     * */
    public function setNombre($nombre)
    {
        $this->nombre=$nombre;
    }
    
    /**
     * Crea el nuevo docente en la base de datos. Se realiza la busqueda
     * del docente para verificar que no exista. Si no existe el docente
     * se crea un nuevo. En caso contrario, se obtiene la informaci�n del
     * docente existente.
     * */
    public function crear($nombre)
    {
        $this->buscar($nombre);
        if (is_null($this->iddocente)) {
            ObjetoDatos::getInstancia()->ejecutarQuery("INSERT INTO docente VALUES (null,'".$nombre."')");
            if (ObjetoDatos::getInstancia()->affected_rows > 0) {
                $this->iddocente = (Int) ObjetoDatos::getInstancia()->insert_id;
                $this->nombre = $nombre;
            }
        }
    }
    
    /**
     * Se borra al docente de la base de datos. En caso que se elimine correctamente,
     * el docente queda con los atributos nulos. Caso contrario, mantiene la informacion.
     * @param integer $iddocente Identificador del docente a borrar (Obligatorio).
     * */
    public function borrar($iddocente)
    {
        $consulta = "DELETE FROM docente WHERE iddocente = ".$iddocente;
        ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if (ObjetoDatos::getInstancia()->affected_rows > 0) {
            $this->iddocente = null;
            $this->nombre = null;
        }
    }
    
    /**
     * Busca a un docente en la base de datos utilizando su nombre. Si el docente
     * se encuentra cargado en la base de datos se actualizan los atributos id y 
     * nombre. En caso contrario, los atributos ser�n nulos.
     * La b�squeda en la base de datos se realiza igualando el parametro ingresado
     * con el campo nombre de la tabla docente. No se obtienen similares.
     * @param $nombre String Recibe el nombre del docente a buscar.
     * */
    public function buscar($nombre)
    {
        $consulta = "SELECT * FROM docente WHERE nombre = '".$nombre."' LIMIT 1";
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if ($this->datos->num_rows > 0) {
            /* Se ha encontrado un docente que cumple la condicion de busqueda */
            $fila = $this->datos->fetch_row();
            $this->iddocente = $fila[0];
            $this->nombre = $fila[1];
        } else {
            /* No se ha encontrado un docente */
            $this->iddocente = null;
            $this->nombre = null;
        }
        $this->datos = null;
    }
    
}

?>