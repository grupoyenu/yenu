<?php

/**
 * Permite obtener operar con los registros de Asignatura almacenados en la base 
 * de datos. 
 * Relacion con BD: ASIGNATURA.
 * Campos: idasignatura, nombre.
 *
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
class Asignatura {

    /** @var string Identificador de la asignatura en la base de datos */
    private $idasignatura;

    /** @var string Nombre de la asignatura */
    private $nombre;

    /** @var string Descripcion para mostrar mensajes */
    private $descripcion;

    /** @var boolean Estado que indica la validez de la asignatura */
    private $estado;

    /**
     * Constructor de la clase asignatura. Cuando se indica un identificador se 
     * busca la informacion en la base de datos y se actualizan los atributos,
     * siendo valida. Cuando no se obtiene un registro la asignatura no sera
     * valida. Al no indicar idasignatura, se crea un objeto vacio.
     * @param integer $idasignatura Identificador de la asignatura o null.
     */
    function __construct($idasignatura = null) {
        $this->estado = false;
        if ($idasignatura) {
            $consulta = "SELECT * FROM asignatura WHERE idasignatura = $idasignatura";
            $rows = Conexion::getInstancia()->executeQuery($consulta);
            if (!empty($rows)) {
                $asignatura = $rows[0];
                $this->cargar($asignatura['nombre'], $asignatura['idasignatura']);
            }
        }
    }

    /**
     * Constructor alternativo de la clase asignatura. Permite establecer la 
     * informacion de la asignatura y establecer la validez de la misma. Se debe
     * utilizar cuando es necesario realizar INSERT o UPDATE a la base de datos.
     * @param string $nombre Nombre de la asignatura.
     * @param integer $idasignatura Identificador de la asignatura o null.
     */
    public function constructor($nombre, $idasignatura = null) {
        $this->estado = false;
        if ($this->setNombre($nombre)) {
            $this->idasignatura = $idasignatura;
            $this->estado = true;
        }
        return $this->estado;
    }

    public function cargar($nombre, $idasignatura) {
        $this->idasignatura = $idasignatura;
        $this->nombre = $nombre;
        $this->estado = true;
    }

    /**
     * Devuelve el identificador de asignatura.
     * @return string $idasignatura
     */
    public function getIdasignatura() {
        return $this->idasignatura;
    }

    /**
     * Devuelve el nombre de asignatura.
     * @return string $nombre
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Devuelve la descripcion de la asignatura. Cuando la asignatura sea invalida
     * (no cumple formato) se puede mostrar la descripcion que causa la no 
     * aceptacion.
     * @return string Descripcion del error detectado.
     */
    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getEstado() {
        return $this->estado;
    }

    /**
     * Modifica el identificador de la asignatura.
     * @param integer $idasignatura
     */
    public function setIdasignatura($idasignatura) {
        $this->idasignatura = $idasignatura;
    }

    /**
     * Modifica el nombre de la asignatura.
     * @param string $nombre
     */
    public function setNombre($nombre) {
        if ($this->validarNombre($nombre)) {
            $this->nombre = Utilidades::convertirCamelCase($nombre);
            return true;
        }
        return false;
    }

    /**
     * Realiza la busqueda de una asignatura por su nombre solo si es valida. Se
     * retorna un arreglo asociativo que solo es vacio en caso de no encontrar
     * registros en la base de datos.
     * @return array() Arreglo asociativo de la tabla asignatura.
     */
    public function buscar() {
        if ($this->nombre) {
            $consulta = "SELECT * FROM asignatura WHERE nombre='" . $this->nombre . "'";
            $rows = Conexion::getInstancia()->executeQuery($consulta);
            return $rows;
        }
        $this->descripcion = "La asignatura no contiene toda la información";
        return null;
    }

    /**
     * Realiza la busqueda de las asignaturas cargadas en la base de datos. Se
     * retorna un arreglo asociativo que solo es vacio en caso de no encontrar
     * registros y es nulo en caso de fallar la consulta. El arreglo esta compuesto
     * por [idasignatura, nombre, carrera].
     * @return array() Arreglo asociativo o NULL.
     */
    public function buscarAsignaturas() {
        $consulta = "SELECT a.idasignatura, a.nombre, COUNT(ac.idcarrera) carreras "
                . "FROM asignatura a, asignatura_carrera ac "
                . "WHERE a.idasignatura = ac.idasignatura "
                . "GROUP BY a.idasignatura";
        $rows = Conexion::getInstancia()->executeQuery($consulta);
        return $rows;
    }

    /**
     * Realiza la creacion de una asignatura solo si es valida. El metodo retorna
     * un numero que indica el resultado de la operacion de creacion. En todos 
     * los casos, se obtiene una descripcion que indica un mensaje.
     * 0 si la busqueda falla.
     * 1 si la asignatura no se crea.
     * 2 si se realiza la creacion de asignatura.
     * 3 si se encuentran coincidencias en la base de datos.
     * @return integer Numero que indica resultado (0, 1, 2 o 3).
     */
    public function crear() {
        $rows = $this->buscar();
        if (!empty($rows)) {
            $this->descripcion = "Se encontró una asignatura que coincide con la indicada";
            $this->idasignatura = $rows[0]['idasignatura'];
            return 3;
        }
        if (!is_null($rows)) {
            $values = "(NULL, '$this->nombre')";
            $creacion = Conexion::getInstancia()->executeInsert("asignatura", $values);
            $this->idasignatura = ($creacion == 2) ? (Int) Conexion::getInstancia()->insert_id : NULL;
            $this->descripcion = Conexion::getInstancia()->getDescripcion()." de la asignatura";
            return $creacion;
        }
        return 0;
    }

    /**
     * Realiza la validacion del nombre de la asignatura. Para el nombre de una
     * asignatura solo se permiten entre 5 y 255 caracteres alfanumericos, 
     * incluyendo acentos, comas, puntos y enes. Solo si el nombre cumple con los
     * requerimiento sera valido. En caso contrario sera invalida y contendra una
     * descripcion indicando el motivo.
     * @param string $nombre Recibe el nombre de a validar.
     * @return boolean True o false.
     */
    private function validarNombre($nombre) {
        $expresion = "/^[A-Za-zÑÁÉÍÓÚñáéíóú0123456789,. ]{5,255}$/";
        $this->descripcion = "El nombre de asignatura no cumple con el formato";
        return (preg_match($expresion, $nombre)) ? true : false;
    }

}
