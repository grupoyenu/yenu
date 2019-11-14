<?php

class Aula {

    /** @var integer Identificador del aula en la base de datos. */
    private $idAula;

    /** @var string Nombre del aula. */
    private $nombre;

    /** @var string Sector donde se ubica el aula. */
    private $sector;
    private $clases;
    private $mesas;

    /** @var string Descripcion para mostrar mensajes. */
    private $descripcion;

    public function __construct($id = NULL, $sector = NULL, $nombre = NULL) {
        $this->setIdAula($id);
        $this->setSector($sector);
        $this->setNombre($nombre);
    }

    public function getIdAula() {
        return $this->idAula;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getSector() {
        return $this->sector;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getClases() {
        return $this->clases;
    }

    public function getMesas() {
        return $this->mesas;
    }

    public function setIdAula($idAula) {
        $this->idAula = $idAula;
    }

    public function setNombre($nombre) {
        if (preg_match("/^[A-Za-zÁÉÍÓÚÑáéíóúñ0-9 ]{1,40}$/", $nombre)) {
            $this->nombre = Utilidades::convertirCamelCase($nombre);
        }
    }

    public function setSector($sector) {
        if (preg_match("/^[A-Za-z]$/", $sector)) {
            $this->sector = Utilidades::convertirCamelCase($sector);
        }
    }

    public function borrar() {
        if ($this->idAula) {
            
        }
        return 1;
    }

    public function crear() {
        if ($this->nombre && $this->sector) {
            $existencia = $this->verificarExistencia();
            if ($existencia == 1) {
                $values = "(NULL,'" . $this->nombre . "','" . $this->sector . "')";
                $creacion = Conexion::getInstancia()->insertar("aula", $values);
                $this->idaula = ($creacion == 2) ? (Int) Conexion::getInstancia()->insert_id : NULL;
                $this->descripcion = $this->nombre . ": " . Conexion::getInstancia()->getDescripcion();
                return $creacion;
            }
            return $existencia;
        }
        $this->descripcion = "No se recibieron los campos obligatorios o no cumplen el formato requerido";
        return 1;
    }

    public function modificar() {
        if ($this->idAula && $this->nombre && $this->sector) {
            $campos = "nombre = '{$this->nombre}', sector = '{$this->sector}'";
            $condicion = "idaula={$this->idAula}";
            $modificacion = Conexion::getInstancia()->modificar("aula", $campos, $condicion);
            $this->descripcion = $this->nombre . ": " . Conexion::getInstancia()->getDescripcion();
            return $modificacion;
        }
        $this->descripcion = ($this->idAula) ? $this->descripcion : "No se pudo hacer referencia al aula";
        return 1;
    }

    public function obtener() {
        if ($this->idAula) {
            $consulta = "SELECT * FROM aula WHERE idaula = {$this->idAula}";
            $fila = Conexion::getInstancia()->obtener($consulta);
            if (!is_null($fila)) {
                $this->nombre = $fila['nombre'];
                $this->sector = $fila['sector'];
                return 2;
            }
            $this->descripcion = "No se obtuvo la información del aula";
            return 1;
        }
        $this->descripcion = "No se pudo hacer referencia al aula";
        return 1;
    }

    public function obtenerClases() {
        if ($this->idAula) {
            $consulta = "SELECT ca.codigo, ca.nombre carrera, ma.idasignatura, ma.nombre asignatura, cl.* FROM cursada cu "
                    . "INNER JOIN asignatura ma ON ma.idasignatura = cu.idasignatura "
                    . "INNER JOIN carrera ca ON ca.codigo = cu.idcarrera "
                    . "INNER JOIN clase cl ON cl.idclase = cu.idclase "
                    . "WHERE cl.idaula = {$this->idAula} ORDER BY cl.dia, cl.desde";
            $this->clases = Conexion::getInstancia()->seleccionar($consulta);
        }
        $this->descripcion = "No se pudo hacer referencia al aula";
        return 1;
    }

    public function obtenerMesas() {
        if ($this->idAula) {
            $consulta = "SELECT me.idmesa, ma.idasignatura, ma.nombre asignatura, ca.codigo, ca.nombre carrera, lp.idllamado idpl, lp.fecha fechapl, "
                    . "lp.hora horapl, lp.fechamod fechamodpl, ls.idllamado idsl, ls.fecha fechasl, ls.hora horasl, ls.fechamod fechamodsl "
                    . "FROM mesa_examen me "
                    . "INNER JOIN asignatura ma ON ma.idasignatura = me.idasignatura "
                    . "INNER JOIN carrera ca ON ca.codigo = me.idcarrera "
                    . "LEFT JOIN llamado lp ON lp.idllamado = me.primero "
                    . "LEFT JOIN llamado ls ON ls.idllamado = me.segundo "
                    . "WHERE lp.idaula = {$this->idAula} OR ls.idaula = {$this->idAula}";
            $this->mesas = Conexion::getInstancia()->seleccionar($consulta);
        }
        $this->descripcion = "No se pudo hacer referencia al aula";
        return 1;
    }

    private function verificarExistencia() {
        $consulta = "SELECT idaula FROM aula WHERE nombre = '{$this->nombre}' AND sector = '{$this->sector}'";
        $fila = Conexion::getInstancia()->obtener($consulta);
        if (gettype($fila) == "array") {
            $this->idAula = $fila['idaula'];
            $this->descripcion = "Se verificó la existencia del aula";
            return 2;
        }
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $fila;
    }

}
