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

    public function importar($mesas, $nroLlamados) {
        $tribunales = new Tribunales();
        $llamados = new Llamados();
        $docentes = new Docentes();
        $truncaMesa = $this->truncar();
        $truncaTribunal = $tribunales->borrar();
        $truncaLlamado = $llamados->borrar();
        $truncaDocente = $docentes->borrar();
        if ($truncaMesa == 2 && $truncaTribunal == 2 && $truncaLlamado == 2 && $truncaDocente == 2) {
            $errores = ($nroLlamados == 1) ? $this->importarUnLlamado($mesas) : $this->importarDosLlamados($mesas);
            if (count($errores) == count($mesas)) {
                $this->descripcion = "No se crearon mesas de examen";
                return 1;
            }
            $this->descripcion = "Mesas creadas exitosamente: " . (count($mesas) - count($errores)) . " de " . count($mesas);
            return $errores;
        }
        $this->descripcion = "No se pudieron eliminar los datos previos";
        return 0;
    }

    public function importarUnLlamado($mesas) {
        $errores = array();
        foreach ($mesas as $datos) {
            $carrera = new Carrera($datos[0], $datos[1]);
            $asignatura = new Asignatura(NULL, $datos[2]);
            $presidente = new Docente(NULL, $datos[3]);
            $vocal1 = new Docente(NULL, $datos[4]);
            $vocal2 = new Docente(NULL, $datos[5]);
            $suplente = new Docente(NULL, $datos[6]);
            $primero = new Llamado(NULL, date('Y-m-d', strtotime(str_replace('/', '-', $datos[7]))), $datos[8], NULL);
            $carrera->crear();
            $asignatura->crear();
            $carrera->agregarAsignatura($asignatura->getIdAsignatura(), 1);
            $presidente->crear();
            $vocal1->crear();
            $vocal2->crear();
            $suplente->crear();
            $tribunal = new Tribunal(NULL, $presidente->getIdDocente(), $vocal1->getIdDocente(), $vocal2->getIdDocente(), $suplente->getIdDocente());
            $tribunal->crear();
            $primero->crear();
            $mesa = new MesaExamen(NULL, $asignatura->getIdAsignatura(), $carrera->getCodigo(), $tribunal->getIdTribunal(), $primero->getIdLlamado());
            if ($mesa->crear() != 2) {
                $mensaje = "Carrera: " . $carrera->getDescripcion() . " / ";
                $mensaje .= "Asignatura: " . $asignatura->getDescripcion() . " / ";
                $mensaje .= "Tribunal: " . $tribunal->getDescripcion() . " / ";
                $mensaje .= "Llamado: " . $primero->getDescripcion() . " / ";
                $mensaje .= "Mesa: " . $mesa->getDescripcion();
                Log::escribirLineaError("[" . $mensaje . "]");
                $errores [] = $datos;
            }
        }
        return $errores;
    }

    public function importarDosLlamados($mesas) {
        $errores = array();
        foreach ($mesas as $datos) {
            $carrera = new Carrera($datos[0], $datos[1]);
            $asignatura = new Asignatura(NULL, $datos[2]);
            $presidente = new Docente(NULL, $datos[3]);
            $vocal1 = new Docente(NULL, $datos[4]);
            $vocal2 = new Docente(NULL, $datos[5]);
            $suplente = new Docente(NULL, $datos[6]);
            $primero = new Llamado(NULL, date('Y-m-d', strtotime(str_replace('/', '-', $datos[7]))), $datos[9], NULL);
            $segundo = new Llamado(NULL, date('Y-m-d', strtotime(str_replace('/', '-', $datos[8]))), $datos[9], NULL);
            $carrera->crear();
            $asignatura->crear();
            $carrera->agregarAsignatura($asignatura->getIdAsignatura(), 1);
            $presidente->crear();
            $vocal1->crear();
            $vocal2->crear();
            $suplente->crear();
            $tribunal = new Tribunal(NULL, $presidente->getIdDocente(), $vocal1->getIdDocente(), $vocal2->getIdDocente(), $suplente->getIdDocente());
            $tribunal->crear();
            $primero->crear();
            $segundo->crear();
            $mesa = new MesaExamen(NULL, $asignatura->getIdAsignatura(), $carrera->getCodigo(), $tribunal->getIdTribunal(), $primero->getIdLlamado(), $segundo->getIdLlamado());
            if ($mesa->crear() != 2) {
                $mensaje = "Carrera: " . $carrera->getDescripcion() . " / ";
                $mensaje .= "Asignatura: " . $asignatura->getDescripcion() . " / ";
                $mensaje .= "Tribunal: " . $tribunal->getDescripcion() . " / ";
                $mensaje .= "Llamado 1: " . $primero->getDescripcion() . " / ";
                $mensaje .= "Llamado 2: " . $segundo->getDescripcion() . " / ";
                $mensaje .= "Mesa: " . $mesa->getDescripcion();
                Log::escribirLineaError("[" . $mensaje . "]");
                $errores [] = $datos;
            }
        }
        return $errores;
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
        Log::escribirLineaError($consulta);
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

    public function truncar() {
        $consulta = "TRUNCATE TABLE mesa_examen";
        $eliminacion = Conexion::getInstancia()->borrarConSubconsulta($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $eliminacion;
    }

}
