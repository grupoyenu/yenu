<?php

/**
 * Description of Clases
 *
 * @author Emanuel
 */
class Clases {

    /** @var string Descripcion sobre el resultado de alguna operacion. */
    private $descripcion;

    /**
     * Retorna la descripcion de la ultima operacion que se haya realizado.
     * @return string Descripcion de la operacion realizada.
     */
    public function getDescripcion() {
        return $this->descripcion;
    }

    private function alter() {
        $consulta = "ALTER TABLE clase AUTO_INCREMENT = 1";
        $alter = Conexion::getInstancia()->borrarConSubconsulta($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $alter;
    }

    public function borrar() {
        $consulta = "DELETE FROM clase";
        $eliminacion = Conexion::getInstancia()->borrarConSubconsulta($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        if ($eliminacion == 2) {
            return $this->alter();
        }
        return $eliminacion;
    }

}
