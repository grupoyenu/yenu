<?php

/**
 * Permite obtener operar con los registros de Docente almacenados en la base 
 * de datos. 
 * Relacion con BD: Docente.
 * Campos: iddocente, nombre.
 *
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
class Docente {

    /** @var integer $iddocente */
    private $iddocente;

    /** @var string $nombre */
    private $nombre;

    /** @var string Descripcion para mostrar mensajes */
    private $descripcion;

    /** @var boolean Estado que indica la validez de la clase */
    private $estado;

    /**
     * Constructor de la clase. Si se ingresa el identificador del docente,
     * se obtiene su informacion desde la base de datos. En caso contrario, se
     * crea con los atributos nulos.
     * @param $iddocente Integer Recibe el identificador del docente.
     * */
    function __construct($iddocente = null) {
        $this->estado = false;
        if ($iddocente) {
            $consulta = "SELECT * FROM docente WHERE iddocente = " . $iddocente;
            $rows = Conexion::getInstancia()->executeQuery($consulta);
            if (!empty($rows)) {
                $docente = $rows[0];
                $this->cargar($docente['iddocente'], $docente['nombre']);
            }
        }
    }

    /**
     * Constructor alternativo de la clase Docente. Permite establecer la 
     * informacion del docente y la validez del  mismo. Se debe utilizar cuando 
     * es necesario realizar INSERT o UPDATE a la base de datos.
     * @param string $nombre Nombre del rol.
     * @param integer $iddocente Identificador del docente o null.
     */
    public function constructor($nombre, $iddocente = null) {
        $this->estado = false;
        if ($this->setNombre($nombre)) {
            $this->iddocente = $iddocente;
            $this->estado = true;
        }
        return $this->estado;
    }

    /**
     * Carga los atributos del docente. Permite asignar informacion al docente
     * sin realizar la validacion de los datos ingreasados. Se debe utilizar 
     * cuando se obtiene la informacion de la Base de Datos.
     * @param integer $iddocente Identificador del docente o null.
     * @param string $nombre Nombre del docente.
     */
    public function cargar($iddocente, $nombre) {
        $this->iddocente = $iddocente;
        $this->nombre = Utilidades::convertirCamelCase($nombre);
        $this->estado = true;
    }

    /**
     * Devuelve el identificador del docente. 
     */
    public function getIdDocente() {
        return $this->iddocente;
    }

    /**
     * Devuelve el nombre del docente.
     */
    public function getNombre() {
        return $this->nombre;
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
        return $this->estado;
    }

    /**
     * Modifica el identificador del docente.
     */
    public function setIdDocente($iddocente) {
        $this->iddocente = $iddocente;
    }

    /**
     * Modifica el nombre del docente.
     * */
    public function setNombre($nombre) {
        if ($this->validarFormatoNombre($nombre)) {
            $this->nombre = Utilidades::convertirCamelCase($nombre);
            return true;
        }
        return false;
    }

    /**
     * Realiza la busqueda de un docente por nombre. Se retorna un arreglo 
     * asociativo que solo es vacio en caso de no encontrar registros en la base 
     * de datos.
     * @return array() Arreglo asociativo de la tabla docente.
     */
    public function buscar() {
        if ($this->nombre) {
            $consulta = "SELECT * FROM docente WHERE nombre = '$this->nombre'";
            $rows = Conexion::getInstancia()->executeQuery($consulta);
            return $rows;
        }
        $this->descripcion = "El docente no contiene toda la información";
        return null;
    }

    /**
     * Realiza la busqueda de docentes por nombre. Se retorna un arreglo 
     * asociativo que solo es vacio en caso de no encontrar registros en la base 
     * de datos.
     * @return array() Arreglo asociativo de la tabla docente.
     */
    public function buscarDocentes() {
        $consulta = "SELECT * FROM docente WHERE nombre LIKE '%$this->nombre%'";
        $rows = Conexion::getInstancia()->executeQuery($consulta);
        return $rows;
    }

    /**
     * Crea el nuevo docente y lo almacena en la base de datos. Antes de realizar
     * la operacion se hace la busqueda del docente para verificar que no exista. 
     * Si no existe el docente se crea un nuevo. En caso contrario, se obtiene la 
     * información del docente existente actualizando sus atributos.
     * @param $nombre String Nombre del docente nuevo.
     * @return array Arreglo con resultado booleano y mensaje.
     * */
    public function crear() {
        $rows = $this->buscar();
        if (!empty($rows)) {
            $this->descripcion = "Se encontró un docente que coincide con el indicado";
            $this->iddocente = $rows[0]['iddocente'];
            return 3;
        }
        if (!is_null($rows)) {
            $values = "(NULL, '$this->nombre')";
            $creacion = Conexion::getInstancia()->executeInsert("docente", $values);
            $this->iddocente = ($creacion == 2) ? (Int) Conexion::getInstancia()->insert_id : NULL;
            $this->descripcion = Conexion::getInstancia()->getDescripcion()." del docente";
            return $creacion;
        }
        return 0;
    }

    /**
     * Controla el formato del nombre de un docente. El nombre del docente
     * tiene un rango de 4 a 100 caracteres. Ademas, puede contener espacio en
     * blanco y letras con y sin acento.
     * @param string $nombre Nombre de la docente.
     */
    private function validarFormatoNombre($nombre) {
        $expresion = "/^[A-Za-zÁÉÍÓÚÑáéíóúñ, ]{4,100}$/";
        $this->descripcion = "El nombre de docente no cumple con el formato";
        return (preg_match($expresion, $nombre)) ? true : false;
    }

}
