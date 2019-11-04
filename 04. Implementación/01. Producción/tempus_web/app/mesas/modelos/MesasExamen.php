<?php

/**
 * Description of MesasExamen
 *
 * @author Emanuel
 */
class MesasExamen {

    /** @var string Descripcion sobre el resultado de alguna operacion. */
    private $descripcion;

    /**
     * Retorna la descripcion de la ultima operacion que se haya realizado.
     * @return string Descripcion de la operacion realizada.
     */
    public function getDescripcion() {
        return $this->descripcion;
    }

    /**
     * Realiza la busqueda de mesas de examen en la vista correspondiente. Se puede
     * aplicar el filtro para el campo carrera o asignatura.
     * @param string $campo Se debe indicar carrera o asignatura.
     * @param string $valor Valor para el campo indicado anteriormente.
     * @return integer 0 cuando falla la consulta, 1 sin resultados o 2 correcta.
     */
    public function buscar($campo, $valor) {
        if ($campo) {
            $consulta = "SELECT * FROM vista_mesas WHERE {$campo} LIKE '%{$valor}%'";
            $resultado = Conexion::getInstancia()->seleccionar($consulta);
            $this->descripcion = Conexion::getInstancia()->getDescripcion();
            return $resultado;
        }
        $this->descripcion = "El campo es obligatorio";
        return 0;
    }

    /**
     * Realiza la busqueda de mesas de examen en la vista correspondientes con el
     * objetivo de generar el informe del modulo. Se pueden aplicar filtros para
     * el nombre de carrera, nombre de asignatura, fecha, hora y fecha de edicion
     * de la mesa.
     * @param string $carrera Nombre de la carrera.
     * @param string $asignatura Nombre de la asignatura.
     * @param string $fecha Fecha en la que se dicta la mesa o NO.
     * @param string $hora Hora en la que se dicta la mesa o NO.
     * @param string $modificada SI para mesa modificada, NO en caso contrario.
     * @return integer 0 cuando falla la consulta, 1 sin resultados o 2 correcta.
     */
    public function listarInforme($carrera, $asignatura, $fecha, $hora, $modificada) {
        $consulta = "SELECT * FROM vista_mesas WHERE ";
        $consulta .= ($carrera) ? "nombreCarrera LIKE '%{$carrera}%' AND " : "";
        $consulta .= ($asignatura) ? "nombreAsignatura LIKE '%{$asignatura}%' AND " : "";
        $consulta .= ($fecha != "NO") ? "(fechaPri = '{$fecha}' OR fechaSeg = '{$fecha}') AND " : "";
        $consulta .= ($hora != "NO") ? "(horaPri = '{$hora}' OR horaSeg = '{$hora}') AND " : "";
        $consulta .= ($modificada == "SI") ? "(fechaModPri IS NULL OR fechaModSeg IS NULL)" : "(fechaModPri IS NOT NULL OR fechaModSeg IS NOT NULL)";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

    /**
     * Realiza la busqueda de las ultimas diez mesas de examen que se han creado.
     * El objetivo es brindar resultados previos cuando se hace la busqueda de 
     * mesas de examen.
     * @return integer 0 cuando falla la consulta, 1 sin resultados o 2 correcta.
     */
    public function listarUltimasCreadas() {
        $consulta = "SELECT * FROM vista_mesas ORDER BY idmesa LIMIT 10";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

}
