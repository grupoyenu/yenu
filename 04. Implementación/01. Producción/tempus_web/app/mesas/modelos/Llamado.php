<?php

/**
 * Description of Llamado
 *
 * @author Emanuel
 */
class Llamado {

    /** @var integer Identificador del llamado en la base de datos. */
    private $idLlamado;

    /** @var string Fecha en la que se dicta la mesa de examen. */
    private $fecha;

    /** @var string Hora en la que se dicta la mesa de examen. */
    private $hora;

    /** @var Aula Aula en la que se dicta la mesa de examen. */
    private $aula;

    /** @var string Fecha de modificacion del llamado. */
    private $fechamod;

    /** @var string Descripcion para mostrar mensajes sobre las operaciones. */
    private $descripcion;

    public function __construct($id = NULL, $fecha = NULL, $hora = NULL, $aula = NULL, $fechaModificacion = NULL) {
        $this->setIdLlamado($id);
        $this->setFecha($fecha);
        $this->setHora($hora);
        $this->setAula($aula);
        $this->setFechamod($fechaModificacion);
    }

    public function getIdLlamado() {
        return $this->idLlamado;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getHora() {
        return $this->hora;
    }

    public function getAula() {
        return $this->aula;
    }

    public function getFechamod() {
        return $this->fechamod;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setIdLlamado($idLlamado) {
        $this->idLlamado = $idLlamado;
    }

    public function setFecha($fecha) {
        if ($fecha) {
            $this->fecha = $fecha;
        } else {
            $this->descripcion = "La fecha no cumple con el formato requerido";
        }
    }

    public function setHora($hora) {
        if (preg_match("/^(1[0-9]|2[0-3]):[0-5][0-9]$/", $hora)) {
            $this->hora = $hora;
        } else {
            $this->descripcion = "La hora no cumple con el formato requerido";
        }
    }

    public function setAula($aula) {
        $this->aula = $aula;
    }

    public function setFechamod($fechamod) {
        $this->fechamod = $fechamod;
    }

    public function borrar() {
        if ($this->idllamado) {
            $condicion = "idllamado=" . $this->idllamado;
            $eliminacion = Conexion::getInstancia()->borrar("llamado", $condicion);
            $this->descripcion = Conexion::getInstancia()->getDescripcion();
            return $eliminacion;
        }
        $this->descripcion = "No se pudo hacer referencia al llamado";
        return 0;
    }

    public function crear() {
        if ($this->fecha && $this->hora) {
            $values = "(NULL, '{$this->fecha}', '{$this->hora}', {$this->aula}, NULL)";
            $creacion = Conexion::getInstancia()->insertar("llamado", $values);
            $this->idllamado = ($creacion == 2) ? (Int) Conexion::getInstancia()->insert_id : NULL;
            $this->descripcion = Conexion::getInstancia()->getDescripcion();
            return $creacion;
        }
        return 0;
    }

    public function modificar() {
        if ($this->idLlamado && $this->fecha && $this->hora) {
            $consulta = "UPDATE llamado SET fecha='{$this->fecha}', hora='{$this->hora}', idaula={$this->aula}, fechamod = NOW() WHERE idllamado=" . $this->idllamado;
            if (Conexion::getInstancia()->executeUpdate($consulta)) {
                $this->descripcion = "Se realizó la modificación del llamado";
                return 2;
            }
            $this->descripcion = "No se realizó la modificación del llamado";
            return 1;
        }
        return 0;
    }

    public function obtener() {
        if ($this->idLlamado) {
            $consulta = "SELECT l.*, a.sector, a.nombre "
                    . "FROM llamado l LEFT JOIN aula a ON l.idaula = a.idaula "
                    . "WHERE idllamado = {$this->idLlamado}";
            $fila = Conexion::getInstancia()->obtener($consulta);
            if (!is_null($fila)) {
                $this->idLlamado = $fila['idllamado'];
                $this->fecha = $fila['fecha'];
                $this->hora = $fila['hora'];
                $this->fechamod = $fila['fechamod'];
                $parametros = array($fila['idaula'], $fila['nombre'], $fila['sector']);
                $this->aula = ($fila['idaula']) ? new Aula($parametros) : NULL;
                return 2;
            }
            return 1;
        }
        return 0;
    }

}
