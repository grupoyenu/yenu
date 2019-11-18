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

    public function borrar($codigo, $idAsignatura) {
        $cursada = new Cursada($idAsignatura, $codigo);
        if (Conexion::getInstancia()->iniciarTransaccion()) {
            $eliminacion = $cursada->borrar();
            $this->descripcion = $cursada->getDescripcion();
            $confirmar = ($eliminacion == 2) ? TRUE : FALSE;
            Conexion::getInstancia()->finalizarTransaccion($confirmar);
            return $eliminacion;
        }
        $this->descripcion = "No se pudo inicializar la transacción para operar";
        return 1;
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

    public function importar($cursadas) {
        $horariosCursada = new Cursadas();
        if (Conexion::getInstancia()->iniciarTransaccion()) {
            $resultado = $horariosCursada->importar($cursadas);
            $this->descripcion = $horariosCursada->getDescripcion();
            $confirmar = (gettype($resultado) == "array") ? TRUE : FALSE;
            Conexion::getInstancia()->finalizarTransaccion($confirmar);
            return $resultado;
        }
        $this->descripcion = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function listarInforme($carrera, $asignatura, $dia, $modificada, $operadorDesde, $desde, $operadorHasta, $hasta) {
        $cursadas = new Cursadas();
        $resultado = $cursadas->listarInforme($carrera, $asignatura, $dia, $modificada, $operadorDesde, $desde, $operadorHasta, $hasta);
        $this->descripcion = $cursadas->getDescripcion();
        return $resultado;
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

    public function modificarClase($idClase, $horaInicio, $horaFin, $aula) {
        $clase = new Clase($idClase, NULL, $horaInicio, $horaFin, $aula);
        $modificacion = $clase->modificar();
        $this->descripcion = $clase->getDescripcion();
        return $modificacion;
    }

}
