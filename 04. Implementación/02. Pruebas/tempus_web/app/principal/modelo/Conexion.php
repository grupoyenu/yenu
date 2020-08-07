<?php

namespace app\principal\modelo;

use mysqli;

/**
 * Esta clase extiende de mysqli. Tiene la logica necesaria para conectarse a 
 * la base de datos del sistema.
 *
 * paquete: principal.
 * namespace: modelos.
 * @author Eder dos Santos <esantos@uarg.unpa.edu.ar>
 *
 */
class Conexion extends mysqli {

    public static $instancia;

    /**
     * Constructor de la clase. Crea una nueva conexion con la base de datos
     * usando la informacion de ConfiguracionesBD.
     * 
     * @see Configuracion
     * */
    public function __construct() {
        try {
            $configuracion = new Configuracion();
            $leido = $configuracion->leerConfiguracion();
            if ($leido) {
                $host = $configuracion->getHost();
                $baseDatos = $configuracion->getBaseDatos();
                $usuario = $configuracion->getUsuario();
                $clave = $configuracion->getPassword();
                parent::__construct($host, $usuario, $clave, $baseDatos);
            } else {
                Log::guardar("ERR", "CONSTRUCTOR --> La conexion no pudo leer los parametros de configuracion");
            }
        } catch (Exception $e) {
            Log::guardar("ERR", "CONSTRUCTOR --> {$e->getCode()} : {$e->getMessage()}");
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
                Log::guardar("ERR", "INSTANCIA --> {$e->getCode()}: {$e->getMessage()}");
                die("Error de conexion a la base de datos: " . $e->getCode() . ".");
            }
        }
        return self::$instancia;
    }

    public function borrar($consulta) {
        if ($this->query($consulta)) {
            if ($this->affected_rows > 0) {
                Log::guardar("INF", " 2 --> {$consulta}");
                return array(2, "Se realizó la eliminación del registro correctamente");
            }
            Log::guardar("WAR", " 1 --> {$consulta}");
            return array(1, "No se realizó la eliminación del registro", $this->affected_rows);
        }
        if ($this->errno == 1451) {
            Log::guardar("WAR", " 1 --> {$consulta}");
            return array(1, "No se realizó la eliminación del registro porque está en uso", -1);
        }
        $this->guardarErrores("BORRAR", $consulta);
        return array(0, "Error en la operación. Intente nuevamente");
    }

    private function guardarErrores($metodo, $consulta) {
        Log::guardar("ERR", "{$metodo} --> {$consulta}");
        foreach ($this->error_list as $error) {
            Log::guardar("ERR", "{$metodo} --> {$error['errno']} : {$error['error']}");
        }
    }

    public function insertar($consulta) {
        if ($this->query($consulta)) {
            if ($this->affected_rows > 0) {
                Log::guardar("INF", " 2 --> {$consulta}");
                return array(2, "Se realizó la creación del registro correctamente", $this->insert_id);
            }
            Log::guardar("WAR", " 0 --> {$consulta}");
            return array(0, "No se realizó la creación del registro");
        }
        if ($this->errno == 1062) {
            Log::guardar("WAR", " 1 --> {$consulta}");
            return array(1, "No se realizó la creación del registro por duplicación");
        }
        $this->guardarErrores("INSERTAR", $consulta);
        return array(0, "Error en la operación. Intente nuevamente ");
    }

    public function modificar($consulta) {
        if ($this->query($consulta)) {
            Log::guardar("INF", " 2 --> {$consulta}");
            return array(2, "Se realizó la modificación correctamente");
        }
        if ($this->errno == 1062) {
            Log::guardar("WAR", " 1 --> {$consulta}");
            return array(1, "No se realizó la modificación del registro por duplicación");
        }
        $this->guardarErrores("MODIFICAR", $consulta);
        return array(0, "Error en la operación. Intente nuevamente");
    }

    public function obtener($consulta) {
        $resultado = $this->query($consulta);
        if ($resultado) {
            if ($resultado->num_rows > 0) {
                return array($resultado->fetch_assoc(), "Se obtuvo la información correctamente");
            }
            return array(1, "No se obtuvo la información");
        }
        $this->guardarErrores("OBTENER", $consulta);
        return array(0, "Error en la operación. Intente nuevamente");
    }

    public function seleccionar($consulta) {
        $resultado = $this->query($consulta);
        if ($resultado) {
            if ($resultado->num_rows > 0) {
                return array(2, $resultado->fetch_all(MYSQLI_ASSOC));
            }
            return array(1, "No se encontraron resultados");
        }
        $this->guardarErrores("SELECCIONAR", $consulta);
        return array(0, "Error en la operación. Intente nuevamente");
    }

    public function iniciarTransaccion() {
        return $this->autocommit(false);
    }

    public function finalizarTransaccion($resultado = TRUE) {
        $mensaje = ($resultado) ? "COMMIT" : "ROLLBACK";
        Log::guardar("INF", "CONEXION --> {$mensaje}");
        ($resultado) ? $this->commit() : $this->rollback();
        $this->autocommit(true);
    }

}
