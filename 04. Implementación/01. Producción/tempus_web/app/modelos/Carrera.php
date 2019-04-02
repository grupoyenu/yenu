<?php

/**
 * Permite obtener operar con los registros de Carrera almacenados en la base 
 * de datos. 
 * Relacion con BD: CARRERA.
 * Campos: codigo, nombre.
 *
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
class Carrera {

    /** @var integer $codigo Codigo de la carrera. */
    private $codigo;

    /** @var string $nombre Nombre de la carrera. */
    private $nombre;

    /** @var string Descripcion para mostrar mensajes */
    private $descripcion;

    /** @var boolean Estado que indica la validez de la carrera */
    private $estado;

    /**
     * Constructor de la clase carrera. Cuando se indica un identificador se 
     * busca la informacion en la base de datos y se actualizan los atributos,
     * siendo valida. Cuando no se obtiene un registro la carrera no sera valida. 
     * Al no indicar codigo, se crea un objeto vacio.
     * @param integer $codigo Identificador de la carrera o null.
     */
    function __construct($codigo = null) {
        if ($codigo) {
            $consulta = "SELECT * FROM carrera WHERE codigo=" . $codigo;
            $rows = Conexion::getInstancia()->executeQuery($consulta);
            if (!empty($rows)) {
                $carrera = $rows[0];
                $this->codigo = $carrera['codigo'];
                $this->nombre = $carrera['nombre'];
                $this->estado = true;
            } else {
                $this->estado = false;
            }
        }
    }

    /**
     * Constructor alternativo de la clase carrera. Permite establecer la 
     * informacion de la carrera y la validez de la misma. Se debe utilizar 
     * cuando es necesario realizar INSERT o UPDATE a la base de datos.
     * @param integer $codigo Identificador de la carrera.
     * @param string $nombre Nombre de la carrera.
     */
    public function constructor($codigo, $nombre) {
        return ($this->setCodigo($codigo) && $this->setNombre($nombre)) ? true : false;
    }

    public function cargar($codigo, $nombre) {
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->estado = true;
    }

    /**
     * Devuelve el codigo de la carrera.
     * @return integer $codigo
     */
    public function getCodigo() {
        if ($this->codigo) {
            return ($this->codigo < 10) ? "00$this->codigo" : "0$this->codigo";
        }
    }

    /**
     * Deuvuelve el nombre de la carrera.
     * @return string $nombre
     */
    public function getNombre() {
        return $this->nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getEstado() {
        return $this->estado;
    }

    /**
     * Modifica el codigo de la carrera. Solo se asigna el codigo de carrera si 
     * cumple con el formato requerido. En caso de no cumplirlo no se asigna y
     * la carrera no estara completa para realizar operaciones sobre la base de
     * datos.
     * @param integer $codigo
     */
    public function setCodigo($codigo) {
        if ($this->validarFormatoCodigo($codigo)) {
            $this->codigo = $codigo;
            return true;
        }
        return false;
    }

    /**
     * Modifica el nombre de la carrera. Solo se asigna el nombre de carrera si 
     * cumple con el formato requerido. En caso de no cumplirlo no se asigna y
     * la carrera no estara completa para realizar operaciones sobre la base de
     * datos.
     * @param string $nombre
     */
    public function setNombre($nombre) {
        if ($this->validarFormatoNombre($nombre)) {
            $this->nombre = Utilidades::convertirCamelCase($nombre);
            return true;
        }
        return false;
    }

    /**
     * Realiza la creacion de una nueva carrera en la base de datos. Para ello,
     * se hace una búsqueda para verificar que la carrera no exista. En caso que
     * la carrera exista, se obtienen sus datos. En caso contrario, se crea un
     * nuevo registro.
     * @return integer Indica 0 es nulo, 1 no crea, 2 si crea y 3 existe.
     * */
    public function crear() {
        $existe = $this->buscarExistente();
        if ($existe == 1) {
            $values = "($this->codigo, '$this->nombre')";
            $creacion = Conexion::getInstancia()->executeInsert("carrera", $values);
            $this->descripcion = Conexion::getInstancia()->getDescripcion()." de la carrera";
            return $creacion;
        }
        return 0;
    }

    /**
     * Devuelve true si la carrera contiene los campos obligatorios. Evalua si
     * la carrera tiene definido un codigo y nombre. Si ambos atributos estan 
     * definidos entonces devuelve true. En caso contrario devuelve false para 
     * indicar que la carrera esta incompleta.
     * @return boolean True o false.
     */
    private function completa() {
        $this->descripcion = "La carrera no contiene toda la información";
        return ($this->codigo && $this->nombre) ? true : false;
    }

    /**
     * Realiza la busqueda de una carrera por codigo y nombre. Se busca que 
     * exista una coincidencia de codigo o de nombre. Se retorna un arreglo 
     * asociativo que solo es vacio en caso de no encontrar registros en la base 
     * de datos.
     * @return array() Arreglo asociativo de la tabla carrera.
     */
    private function buscarExistente() {
        if ($this->completa()) {
            $consulta = "SELECT codigo FROM carrera WHERE codigo=$this->codigo OR nombre = '$this->nombre'";
            $rows = Conexion::getInstancia()->executeQuery($consulta);
            if (is_null($rows)) {
                $this->descripcion = "No se pudo realizar la búsqueda de carrera";
                return 0;
            }
            $this->descripcion = "Se encontró una carrera que coincide con la indicada";
            return (empty($rows)) ? 1 : 2;
        }
        return 0;
    }

    public function buscarCarreras() {
        $consulta = "SELECT * FROM carrera";
        $rows = Conexion::getInstancia()->executeQuery($consulta);
        return $rows;
    }

    /**
     * Controla el formato del codigo de una carrera. El codigo de carrera tiene 
     * una longitud de 1 a 3 digitos. El mismo no puede ser nulo ni vacio.
     * @var string $codigo Recibe el codigo de la carrera a validar.
     * @return string Null si es correcto, mensaje en caso contrario.
     * @return boolean True o false.
     */
    private function validarFormatoCodigo($codigo) {
        $expresion = "/^[0-9]{1,3}$/";
        $this->descripcion = "El código de carrera no cumple con el formato";
        return (preg_match($expresion, $codigo)) ? true : false;
    }

    /**
     * Controla el formato del nombre de una carrera. El nombre de carrera
     * tiene un rango de 10 a 255 car�cteres. Ademas, puede contener espacio en
     * blanco y letras con y sin acento.
     * @param string $nombre Nombre de la carrera.
     * @return boolean True o false.
     */
    private function validarFormatoNombre($nombre) {
        $expresion = "/^[A-Za-zÁÉÍÓÚÑáéíóúñ. ]{10,255}$/";
        $this->descripcion = "El nombre de carrera no cumple con el formato";
        return (preg_match($expresion, $nombre)) ? true : false;
    }

}
