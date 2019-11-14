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
                    Log::escribirLineaError($dia . " " . $datos[$posicion] . " " . $datos[$posicion + 1] . " " . $aula->getIdAula());
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

    public function listarUltimasCreadas() {
        $consulta = "SELECT * FROM vista_cursadas ORDER BY idAsignatura DESC LIMIT 10";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

    public function listarResumenInicial() {
        $consulta = "SELECT 'Total de asignaturas con cursada' nombre, COUNT(DISTINCT idasignatura, idcarrera) cantidad FROM vista_cursadas";
        $resultado = Conexion::getInstancia()->seleccionar($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $resultado;
    }

}
