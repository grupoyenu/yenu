<?php

require_once('Configuracion.php');

/**
 * Esta clase extiende de mysqli. Tiene la logica necesaria para conectarse a 
 * la base de datos del sistema.
 *
 * @author Eder dos Santos <esantos@uarg.unpa.edu.ar>
 *
 */
class Conexion extends mysqli {

    public static $instancia;
    
    private $descripcion;

    /**
     * Constructor de la clase. Crea una nueva conexion con la base de datos
     * usando la informacion de ConfiguracionesBD.
     * 
     * @see ConfiguracionesBD
     * */
    function __construct() {
        $configuracion = new Configuracion;
        $host = $configuracion->getHost();
        $usuario = $configuracion->getUsuario();
        $clave = $configuracion->getClave();
        $baseDatos = $configuracion->getBaseDatos();
        parent::__construct($host, $usuario, $clave, $baseDatos);
        if ($this->connect_error) {
            throw new Exception($this->connect_error, $this->connect_errno);
        }
    }

    /**
     * Devuelve la instancia de la conexion a la base de datos.
     * @return ObjetoDatos
     */
    public static function getInstancia() {
        if (!self::$instancia instanceof self) {
            try {
                self::$instancia = new self;
            } catch (Exception $e) {
                die("Error de conexi�n a la base de datos: " . $e->getCode() . ".");
            }
        }
        return self::$instancia;
    }
    
    public function getDescripcion() {
        return $this->descripcion;
    }
    
    public function executeDelete($tabla, $where) {
        $consulta = "DELETE FROM {$tabla} WHERE ".$where;
        $this->query($consulta);
        if ($this->affected_rows > 0) {
            $this->descripcion = "Se realizó la eliminación";
            return 2;
        }
        $this->descripcion = "No se realizó la eliminación";
        return 1;
    }
    
    public function executeInsert($tabla, $values) {
        $consulta = "INSERT INTO {$tabla} VALUES ".$values;
        $this->query($consulta);
        if ($this->affected_rows > 0) {
            $this->descripcion = "Se realizó la creación";
            return 2;
        }
        $this->descripcion = "No se realizó la creación";
        return 1;
    }
    
    public function executeUpdate($tabla, $set, $where) {
        $consulta = "UPDATE {$tabla} SET $set WHERE $where";
        $this->query($consulta);
        if ($this->affected_rows > 0) {
            $this->descripcion = "Se realizó la modificación";
            return 2;
        }
        $this->descripcion = "No se realizó la modificación";
        return 1;
    }

    /**
     * Realiza una operacion de SELECT. Recibe la consulta a realizar y la 
     * ejecuta. Retorna un arreglo asociativo cuando se obtienen registros. En 
     * caso contrario se devuelve un arreglo vacio.
     * @return array()
     */
    public function executeQuery($consulta) {
        $result = $this->query($consulta);
        if ($result) {
            $rows = array();
            while ($fila = $result->fetch_assoc()) {
                $rows[] = $fila;
            }
            return $rows;
        }
        return NULL;
    }
    
    public function executeQueryBoolean($consulta) {
        $result = $this->query($consulta);
        if ($result) {
            return ($result->num_rows > 0) ? true : false;
        }
        return false;
    }

    function setAutocommit($commit) {
        $this->autocommit($commit);
    }

    function executeCommit() {
        $this->commit();
    }

    function executeRollback() {
        $this->rollback();
    }
    
   

}
