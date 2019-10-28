<?php

/**
 * Description of ControladorCursada
 *
 * @author Emanuel
 */
class ControladorCursada {

    //put your code here

    private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function buscar($campo, $valor) {
        $cursadas = new Cursadas();
        $resultado = $cursadas->buscar($campo, $valor);
        $this->descripcion = $cursadas->getDescripcion();
        return $resultado;
    }

    public function crear($carrera, $asignatura, $clases) {
        $cursada = new Cursada($asignatura, $carrera, $clases);
        if (Conexion::getInstancia()->iniciarTransaccion()) {
            $creacion = $cursada->crear();
            $this->descripcion = $cursada->getDescripcion();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            Conexion::getInstancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        $this->descripcion = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function listarUltimasCreadas() {
        $cursadas = new Cursadas();
        $resultado = $cursadas->listarUltimasCreadas();
        $this->descripcion = $cursadas->getDescripcion();
        return $resultado;
    }

    public function listarResumenInicial() {
        $cursadas = new Cursadas();
        $resultado = $cursadas->listarResumenInicial();
        $this->descripcion = $cursadas->getDescripcion();
        return $resultado;
    }

}
