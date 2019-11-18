<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Cursadas {

    /** @var string Descripcion sobre el resultado de alguna operacion. */
    private $descripcion;

    /**
     * Retorna la descripcion de la ultima operacion que se haya realizado.
     * @return string Descripcion de la operacion realizada.
     */
    public function getDescripcion() {
        return $this->descripcion;
    }

    public function borrar() {
        $consulta = "DELETE FROM cursada";
        $eliminacion = Conexion::getInstancia()->borrarConSubconsulta($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $eliminacion;
    }

    public function buscar($campo, $valor) {
        if ($campo) {
            $consulta = "SELECT * FROM vista_cursadas WHERE {$campo} LIKE '%{$valor}%'";
            $resultado = Conexion::getInstancia()->seleccionar($consulta);
            $this->descripcion = Conexion::getInstancia()->getDescripcion();
            return $resultado;
        }
        $this->descripcion = "El campo es obligatorio";
        return 0;
    }

    public function importar($cursadas) {
        $clases = new Clases();
        $planes = new Planes();
        $borraClases = $clases->borrar();
        $borraCursadas = $this->borrar();
        $borraPlanes = $planes->borrar();
        if (($borraClases == 2) && ($borraCursadas == 2) && ($borraPlanes == 2)) {
            $errores = $this->importarCursada($cursadas);
            if (count($errores) == count($cursadas)) {
                $this->descripcion = "No se crearon horarios de cursada";
                return 1;
            }
            $this->descripcion = "Horarios de cursada creados exitosamente: " . (count($cursadas) - count($errores)) . " de " . count($cursadas);
            return $errores;
        }
        $this->descripcion = "No se pudieron eliminar los datos previos";
        return 0;
    }

    private function importarCursada($cursadas) {
        $errores = array();
        foreach ($cursadas as $datos) {
            $carrera = new Carrera($datos[0], $datos[1]);
            $asignatura = new Asignatura(NULL, $datos[2]);
            $carrera->crear();
            $asignatura->crear();
            $carrera->agregarAsignatura($asignatura->getIdAsignatura(), $datos[3]);
            $clases = array();
            $posicion = 4;
            $dia = 1;
            while ($posicion < 28) {
                if ($datos[$posicion]) {
                    $aula = new Aula(NULL, $datos[$posicion + 2], $datos[$posicion + 3]);
                    $aula->crear();
                    $clase = new Clase(NULL, $dia, $datos[$posicion], $datos[$posicion + 1], $aula->getIdAula());
                    $clases[] = $clase;
                }
                $posicion = $posicion + 4;
                $dia++;
            }
            $cursada = new Cursada($asignatura->getIdAsignatura(), $datos[0], $clases);
            if ($cursada->crear() != 2) {
                $mensaje = "Carrera: " . $carrera->getDescripcion() . " / ";
                $mensaje .= "Asignatura: " . $asignatura->getDescripcion() . " / ";
                $mensaje .= "Cursada: " . $cursada->getDescripcion();
                Log::escribirLineaError("[" . $mensaje . "]");
                $errores [] = $datos;
            }
        }
        return $errores;
    }

    public function listarInforme($carrera, $asignatura, $dia, $modificada, $opDesde, $desde, $opHasta, $hasta) {
        $consulta = "SELECT * FROM vista_cursadas WHERE ";
        $consulta .= ($carrera) ? "nombreCarrera LIKE '%{$carrera}%' AND " : "";
        $consulta .= ($asignatura) ? "nombreAsignatura LIKE '%{$asignatura}%' AND " : "";
        $consulta .= ($dia != "NO") ? "idClase{$dia} IS NOT NULL AND " : "";
        $consulta .= ($desde != "NO") ? "(desde1 {$opDesde} '{$desde}' OR desde2 {$opDesde} '{$desde}' OR desde3 {$opDesde} '{$desde}' OR desde4 {$opDesde} '{$desde}' OR desde5 {$opDesde} '{$desde}' OR desde6 {$opDesde} '{$desde}') AND " : "";
        $consulta .= ($hasta != "NO") ? "(hasta1 {$opHasta} '{$hasta}' OR hasta2 {$opHasta} '{$hasta}' OR hasta3 {$opHasta} '{$hasta}' OR hasta4 {$opHasta} '{$hasta}' OR hasta5 {$opHasta} '{$hasta}' OR hasta6 {$opHasta} '{$hasta}') AND " : "";
        $consulta .= ($modificada == "SI") ? "(fechaMod1 IS NOT NULL OR fechaMod2 IS NOT NULL OR fechaMod3 IS NOT NULL OR fechaMod4 IS NOT NULL OR fechaMod5 IS NOT NULL OR fechaMod6 IS NOT NULL)" : "(fechaMod1 IS NULL AND fechaMod2 IS NULL AND fechaMod3 IS NULL AND fechaMod4 IS NULL AND fechaMod5 IS NULL AND fechaMod6 IS NULL)";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

    public function listarUltimasCreadas() {
        $consulta = "SELECT * FROM vista_cursadas ORDER BY idAsignatura DESC LIMIT 10";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

    public function listarResumenInicial() {
        $consulta = "SELECT 'Total de horarios de cursada' nombre, COUNT(DISTINCT idasignatura, idcarrera) cantidad FROM vista_cursadas UNION "
                . "SELECT 'Total de asignaturas distintas con cursada' nombre, COUNT(DISTINCT idasignatura) cantidad FROM vista_cursadas UNION "
                . "SELECT 'Total de cursadas que se han modificado' nombre, COUNT(*) cantidad FROM vista_cursadas WHERE fechaMod1 IS NOT NULL OR fechaMod2 IS NOT NULL OR fechaMod3 IS NOT NULL OR fechaMod4 IS NOT NULL OR fechaMod5 IS NOT NULL OR fechaMod6 IS NOT NULL";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

}
