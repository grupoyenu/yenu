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

    /**
     * Realiza la eliminacion de la mesa de examen en la base de datos.
     */
    public function borrar($idMesa) {
        $mesa = new MesaExamen($idMesa);
        if (Conexion::getInstancia()->iniciarTransaccion()) {
            $eliminacion = $mesa->borrar();
            $this->descripcion = $mesa->getDescripcion();
            $confirmar = ($eliminacion == 2) ? TRUE : FALSE;
            Conexion::getInstancia()->finalizarTransaccion($confirmar);
            return $eliminacion;
        }
        $this->descripcion = "No se pudo inicializar la transacción para operar";
        return 0;
    }

    public function buscar($campo, $valor) {
        $mesas = new MesasExamen();
        $resultado = $mesas->buscar($campo, $valor);
        $this->descripcion = $mesas->getDescripcion();
        return $resultado;
    }

    public function importar($mesasExamen, $numeroLlamados) {
        $mesas = new MesasExamen();
        $resultado = $mesas->importar($mesasExamen, $numeroLlamados);
        $this->descripcion = $mesas->getDescripcion();
        return $resultado;
    }

    public function listarInforme($carrera, $asignatura, $fecha, $hora, $modificada) {
        $mesas = new MesasExamen();
        $resultado = $mesas->listarInforme($carrera, $asignatura, $fecha, $hora, $modificada);
        $this->descripcion = $mesas->getDescripcion();
        return $resultado;
    }

    public function listarUltimasCreadas() {
        $mesas = new MesasExamen();
        $resultado = $mesas->listarUltimasCreadas();
        $this->descripcion = $mesas->getDescripcion();
        return $resultado;
    }

    public function obtenerCantidadLlamados() {
        $llamados = new Llamados();
        $cantidad = $llamados->obtenerNumeroLlamados();
        $this->descripcion = $llamados->getDescripcion();
        return $cantidad;
    }

}
