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
        $truncaClases = $this->truncar();
        if ($truncaClases == 2) {
            
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
                    $clase = new Clase(NULL, $dia, $datos[4], $datos[5], $aula->getIdAula());
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

    public function truncar() {
        $consulta = "TRUNCATE TABLE clases";
        $eliminacion = Conexion::getInstancia()->borrarConSubconsulta($consulta);
        $this->descripcion = Conexion::getInstancia()->getDescripcion();
        return $eliminacion;
    }

}
