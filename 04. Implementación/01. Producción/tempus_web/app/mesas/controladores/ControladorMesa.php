<?php

/**
 * Se utiliza para controlar las operaciones que se llevan a cabo para las mesas
 * de examen. Se comunica con las clases Mesa de Examen y Mesas de Examen.
 *
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>.
 * @author Quiroga Sandra <squiroga017@gmail.com>.
 * @author Marquez Emanuel <marquez.emanuel.alberto@gmail.com>.
 */
class ControladorMesa {

    /** @var string Descripcion sobre alguna de las operaciones que se realiza. */
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

    public function crear($carrera, $asignatura, $tribunal, $primero, $segundo) {
        if (Conexion::getInstancia()->iniciarTransaccion()) {
            $tribunal->crear();
            $primero->crear();
            $idSegundo = NULL;
            if ($segundo) {
                $segundo->crear();
                $idSegundo = $segundo->getIdLlamado();
            }
            $mesa = new MesaExamen(NULL, $asignatura, $carrera, $tribunal->getIdTribunal(), $primero->getIdLlamado(), $idSegundo);
            $creacion = $mesa->crear();
            $this->descripcion = $mesa->getDescripcion();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            Conexion::getInstancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        $this->descripcion = "No se pudo inicializar la transacción para operar";
        return 1;
    }

    public function importar($mesasExamen, $numeroLlamados) {
        $mesas = new MesasExamen();
        if (Conexion::getInstancia()->iniciarTransaccion()) {
            $resultado = $mesas->importar($mesasExamen, $numeroLlamados);
            $this->descripcion = $mesas->getDescripcion();
            $confirmar = (gettype($resultado) == "array") ? TRUE : FALSE;
            Conexion::getInstancia()->finalizarTransaccion($confirmar);
            return $resultado;
        }
    }

    public function listarInforme($carrera, $asignatura, $fecha, $hora, $docente, $modificada) {
        $mesas = new MesasExamen();
        $resultado = $mesas->listarInforme($carrera, $asignatura, $fecha, $hora, $docente, $modificada);
        $this->descripcion = $mesas->getDescripcion();
        return $resultado;
    }

    public function listarResumenInicial() {
        $mesas = new MesasExamen();
        $resultado = $mesas->listarResumenInicial();
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
