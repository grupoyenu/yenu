<?php
require_once '../lib/conf/ObjetoDatos.php';

/**
 * Esta clase corresponde con la tabla Carrera de la base de datos.
 * Contiene los metodos necesarios para crear, borrar, buscar o modificar una carrera.
 * Se relaciona con la clase Plan. (Relacion entre asignaturas y carreras).
 * 
 * Fecha de creación: 18-10-2017.
 * 
 * @version 1.0
 *
 * @author Oyarzo Mariela.
 * @author Quiroga Sandra.
 * @author Marquez Emanuel.
 * */
class Carrera 
{
    /** @var integer $codigo de carrera. */
    private $codigo;
    
    /** @var string $nombre de carrera. */
    private $nombre;
    
    /** @var mysqli_result $datos */
    private $datos;
    
    /**
     * Constructor de la clase. Si se ingresa un codigo de carrera, se obtiene la
     * informacion de la misma consultando la base de datos. En caso contrario, se
     * crea la carrera con los atributos nulos.
     * @param integer $codigo Recibe el codigod de carrera.
     * */
    function __construct($codigo = null)
    {
        if($codigo) {
            $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery(""
                ."SELECT * "
                ."FROM carrera "
                ."WHERE codigo = ".$codigo);
            if ($this->datos->num_rows > 0) {
                foreach ($this->datos->fetch_assoc() as $atributo => $valor) {
                    $this->{$atributo} = $valor;
                }
            }
            $this->datos = null;
        }
    }
    
    /**
     * Devuelve el codigo de la carrera.
     * @return integer $codigo
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Deuvuelve el nombre de la carrera.
     * @return string $nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Modifica el codigo de la carrera.
     * @param integer $codigo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * Modifica el nombre de la carrera.
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    
    
    public function crear($codigo, $nombre) 
    {
        
    }
    
    /**
     * Se borra al docente de la base de datos. En caso que se elimine correctamente,
     * el docente queda con los atributos nulos. Caso contrario, mantiene la informacion.
     * @return integer 
     * */
    public function borrar($codigo)
    {
        try {
            
            ObjetoDatos::getInstancia()->ejecutarQuery("DELETE FROM carrera WHERE codigo = ".$codigo);
            $this->codigo = null;
            $this->nombre = null;
            
        } catch(Exception $exception) {
            return 0;
        }
        return 1;
    }
    
    /**
     * Busca a una carrera en la base de datos utilizando su nombre. Si la carrera
     * se encuentra cargada en la base de datos se actualizan los atributos codigo y
     * nombre. En caso contrario, los atributos serán nulos.
     * La búsqueda en la base de datos se realiza igualando el parametro ingresado
     * con el campo nombre de la tabla carrera. No se obtienen similares.
     * @param $nombre String Recibe el nombre de la carrera a buscar.
     * */
    public function buscar($nombre)
    {
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery(""
            ."SELECT * "
            ."FROM carrera "
            ."WHERE nombre = '".$nombre."'");
        if ($this->datos->num_rows > 0) {
            foreach ($this->datos->fetch_assoc() as $atributo => $valor) {
                $this->{$atributo} = $valor;
            }
        } else {
            $this->codigo = null;
            $this->nombre = null;
        }
        $this->datos = null;
    }

}


?>