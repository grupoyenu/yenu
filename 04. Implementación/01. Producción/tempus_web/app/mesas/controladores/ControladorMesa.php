<?php

/**
 * Description of ControladorMesa
 *
 * @author Emanuel
 */
class ControladorMesa {

    private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function buscar($campo, $valor) {
        $mesas = new MesasExamen();
        $resultado = $mesas->buscar($campo, $valor);
        $this->descripcion = $mesas->getDescripcion();
        return $resultado;
    }

    public function listarInforme($carrera, $asignatura) {
        $mesas = new MesasExamen();
        $resultado = $mesas->listarInforme();
        $this->descripcion = $mesas->getDescripcion();
        return $resultado;
    }

    public function listarUltimasCreadas() {
        $mesas = new MesasExamen();
        $resultado = $mesas->listarUltimasCreadas();
        $this->descripcion = $mesas->getDescripcion();
        return $resultado;
    }

}
