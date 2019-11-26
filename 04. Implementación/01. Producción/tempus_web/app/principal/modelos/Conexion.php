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

    private $id;
    public static $instancia;

    /** @var string Mensaje con la descripcion de alguna operacion. */
    private $descripcion;

    /**
     * Constructor de la clase. Crea una nueva conexion con la base de datos
     * usando la informacion de ConfiguracionesBD.
     * 
     * @see ConfiguracionesBD
     * */
    function __construct() {
        $configuracion = new Configuracion();
        try {
            $host = $configuracion->getHost();
            $usuario = $configuracion->getUsuario();
            $clave = $configuracion->getClave();
            $baseDatos = $configuracion->getBaseDatos();
            parent::__construct($host, $usuario, $clave, $baseDatos);
        } catch (Exception $e) {
            Log::escribirLineaError("[METODO: construct][ERROR: Error al realizar la conexion a la base de datos: {$e->getCode()}: {$e->getMessage()}]");
        }
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getIdentificador() {
        return $this->id;
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
                Log::escribirLineaError("[METODO: getInstancia][ERROR: Error al obtener instancia de la conexion a la base de datos: {$e->getCode()}: {$e->getMessage()}]");
                die("Error de conexion a la base de datos: " . $e->getCode() . ".");
            }
        }
        return self::$instancia;
    }

    public function borrar($tabla, $condicion) {
        $consulta = "DELETE FROM {$tabla} WHERE {$condicion}";
        if ($this->query($consulta)) {
            if ($this->affected_rows > 0) {
                $this->descripcion = "Se realizó la eliminación del registro correctamente";
                return 2;
            }
            $this->descripcion = "No se realizó la eliminación del registro";
            return 1;
        }
        $this->descripcion = "Error en la operación. Intente nuevamente";
        Log::escribirLineaError("[METODO: borrar][ERROR: Error al borrar registro (QUERY: $consulta)");
        return 0;
    }

    public function borrarConSubconsulta($consulta) {
        if ($this->query($consulta)) {
            $this->descripcion = "Se realizó la eliminación del registro correctamente";
            return 2;
        }
        $this->descripcion = "Error en la operación. Intente nuevamente";
        Log::escribirLineaError("[METODO: borrarConSubconsulta][ERROR: Error al borrar registro (QUERY: $consulta)");
        return 0;
    }

    public function existe($consulta) {
        $result = $this->query($consulta);
        if ($result) {
            if ($result->num_rows > 0) {
                $fila = $result->fetch_array(MYSQLI_NUM);
                $this->id = $fila[0];
                $this->descripcion = "Existe un registro";
                return 3;
            }
            $this->descripcion = "No existe un registro";
            return 1;
        }
        $this->descripcion = "Error en la operación. Intente nuevamente";
        Log::escribirLineaError("[METODO: existe][ERROR: Error al verificar registro (QUERY: $consulta)");
        return 0;
    }

    public function evaluar($consulta) {
        $result = $this->query($consulta);
        if ($result) {
            return ($result->num_rows > 0) ? 2 : 1;
        }
        $this->descripcion = "Error en la operación. Intente nuevamente";
        Log::escribirLineaError("[METODO: existe][ERROR: Error al evaluar registro (QUERY: $consulta)");
        return 0;
    }

    public function insertar($table, $values) {
        $consulta = "INSERT INTO {$table} VALUES {$values}";
        if ($this->query($consulta)) {
            if ($this->affected_rows > 0) {
                $this->descripcion = "Se realizó la creación del registro correctamente";
                return 2;
            }
            $this->descripcion = "No se realizó la creación del registro";
            return 0;
        }
        if ($this->errno == 1062) {
            $this->descripcion = "No se realizó la creación del registro por duplicación";
            return 1;
        }
        $this->descripcion = "Error en la operación. Intente nuevamente ";
        Log::escribirLineaError("[METODO: insertarSinObtenerId][ERROR: Error al insertar registro (QUERY: $consulta)");
        return 0;
    }

    public function modificar($tabla, $campos, $condicion) {
        $consulta = "UPDATE $tabla SET $campos WHERE $condicion";
        if ($this->query($consulta)) {
            $this->descripcion = "Se realizó la modificación correctamente";
            return 2;
        }
        if ($this->errno == 1062) {
            $this->descripcion = "No se realizó la modificación del registro por duplicación";
            return 1;
        }
        $this->descripcion = "Error en la operación. Intente nuevamente";
        Log::escribirLineaError("[METODO: modificar][ERROR: Error al modificar registro (QUERY: $consulta)");
        return 0;
    }

    public function obtener($consulta) {
        $result = $this->query($consulta);
        if ($result) {
            if ($result->num_rows > 0) {
                $this->descripcion = "Se obtuvo la información";
                return $result->fetch_assoc();
            }
            $this->descripcion = "No se obtuvo la información";
            return 1;
        }
        $this->descripcion = "Error en la operación. Intente nuevamente";
        Log::escribirLineaError("[METODO: obtener][ERROR: Error al obtener registro (QUERY: $consulta)");
        return 0;
    }

    public function seleccionar($consulta) {
        $resultado = $this->query($consulta);
        if ($resultado) {
            if ($resultado->num_rows > 0) {
                $this->descripcion = "Se encontraron resultados";
                return $resultado;
            }
            $this->descripcion = "No se encontraron resultados";
            return 1;
        }
        $this->descripcion = "Error en la operación. Intente nuevamente";
        Log::escribirLineaError("[METODO: seleccionar][ERROR: Error al buscar registros (QUERY: $consulta)");
        return 0;
    }

    public function iniciarTransaccion() {
        return $this->autocommit(false);
    }

    public function finalizarTransaccion($resultado = TRUE) {
        ($resultado) ? $this->commit() : $this->rollback();
        $this->autocommit(true);
    }

}
