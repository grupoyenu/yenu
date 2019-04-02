<?php

/**
 * Description of Cursadas
 *
 * @author Emanuel
 */
class Cursadas {

    /**
     * Constructor de clase.
     * */
    function __construct() {
    }

    /**
     * Realiza la creacion de un conjunto de horarios de cursada.
     * @param Cursada[] $cursadas
     * */
    public function crear($cursadas) {
        /* Indica un mensaje a mostrar */
        $mensaje = "";
        /* Indica si se han creado las cursadas */
        $creacion = true;
        /* Indica las cursadas que no se han creado */
        $datos = null;

        if (isset($cursadas)) {
            /* Se han borrado todos los registros */
            if ($this->borrar()) {

                $tamanio = count($cursadas);
                /* Contador con la cantidad de cursadas que se han creado */
                $contadorexitos = 0;
                foreach ($cursadas as $cursada) {

                    $plan = $cursada->getPlan();
                    $asignatura = new Asignatura();
                    $asignatura->crear($plan->getAsignatura()->getNombre());

                    $carrera = new Carrera();
                    $carrera->crear($plan->getCarrera()->getCodigo(), $plan->getCarrera()->getNombre());

                    $plan->crear($asignatura->getIdasignatura(), $carrera->getCodigo(), $plan->getAnio());
                    $plan->setAsignatura($asignatura);
                    $plan->setCarrera($carrera);

                    $clases = $cursada->getClases();

                    foreach ($clases as $clase) {
                        $aula = $clase->getAula();
                        $aula->crear($aula->getNombre(), $aula->getSector());
                    }

                    $creada = $cursada->crear($plan, $clases);

                    if ($creada) {
                        /* Se ha creado correctamente la cursada */
                        $contadorexitos = $contadorexitos + 1;
                    } else {
                        $datos [] = $cursada;
                    }
                }

                if ($contadorexitos > 0) {
                    $mensaje = "Se han creado " . $contadorexitos . " horarios de cursada sobre " . $tamanio . " recibidos";
                } else {
                    $mensaje = "No se han creado horarios de cursada para un total de " . $tamanio . " recibidos";
                }
            } else {
                /* No se han borrado todos los registros existentes */
                $mensaje = 'No se ha podido realizar la eliminación de los horarios de cursada actuales';
                $creacion = false;
            }
        } else {
            /* El parametro cursadas no esta definido o es nulo (ISSET) */
            $mensaje = 'No se han recibido los horarios de cursada a crear';
            $creacion = false;
        }

        $resultado = array('resultado' => $creacion, 'mensaje' => $mensaje, 'datos' => $datos);
        return $resultado;
    }

    /**
     * Realiza la eliminacion de todas las cursadas cargadas en la base de datos.
     * Para ello realiza la eliminación de cada uno de los registros de las tablas
     * clase y cursada.
     * @return boolean true o false.
     * @author Márquez Emanuel.
     * */
    public function borrar() {
        ObjetoDatos::getInstancia()->autocommit(false);
        ObjetoDatos::getInstancia()->begin_transaction();
        try {
            ObjetoDatos::getInstancia()->ejecutarQuery("DELETE FROM clase WHERE 1");
            ObjetoDatos::getInstancia()->ejecutarQuery("DELETE FROM cursada WHERE 1");
        } catch (Exception $exception) {
            return false;
        }
        ObjetoDatos::getInstancia()->commit();
        ObjetoDatos::getInstancia()->autocommit(true);
        return true;
    }

    public function buscar($asignatura) {
        $consulta = "SELECT DISTINCTROW a.idasignatura, a.nombre, ca.codigo, ca.nombre carrera FROM cursada cu, asignatura a, carrera ca WHERE cu.idasignatura=a.idasignatura AND cu.idcarrera=ca.codigo ";
        $consulta = ($asignatura) ? $consulta . " AND a.nombre LIKE '%{$asignatura}%' " : $consulta;
        $consulta = $consulta . "  ORDER BY ca.codigo, a.idasignatura";
        $rows = Conexion::getInstancia()->executeQuery($consulta);
        if (!empty($rows)) {
            $cursadas = array();
            foreach ($rows as $fila) {
                $cursada = new Cursada();
                $plan = new Plan();
                $plan->cargar($fila['idasignatura'], $fila['nombre'], $fila['codigo'], $fila['carrera'], 1);
                $cursada->setPlan($plan);
                if ($cursada->obtenerHorarios() == 2) {
                    $cursadas[] = $cursada;
                }
            }
            return $cursadas;
        }
        return is_null($rows) ? NULL : $rows;
    }

    public function informe($codigoCarrera, $dia, $inicio, $fin) {
        $consulta = "SELECT DISTINCTROW cu.idasignatura, a.nombre, ca.nombre FROM cursada cu, clase cl, asignatura a, carrera ca WHERE cu.idcarrera={$codigoCarrera} AND cu.idclase=cl.idclase AND a.idasignatura=cu.idasignatura AND ca.codigo=cu.idcarrera";
        $consulta = ($dia) ? $consulta . " AND cl.dia={$dia} " : $consulta;
        $consulta = ($inicio) ? $consulta . " AND cl.desde='{$inicio}' " : $consulta;
        $consulta = ($fin) ? $consulta . " AND cl.hasta='{$dia}' " : $consulta;
        $rows = Conexion::getInstancia()->executeQuery($consulta);
        if (!empty($rows)) {
            $cursadas = array();
            foreach ($rows as $fila) {
                $cursada = new Cursada();
                $plan = new Plan();
                $plan->cargar($fila['idasignatura'], $fila['nombre'], $fila['codigo'], $fila['carrera'], 1);
                $cursada->setPlan($plan);
                if ($cursada->obtenerHorarios() == 2) {
                    $cursadas[] = $cursada;
                }
            }
            return $cursadas;
        }
        return is_null($rows) ? NULL : $rows;
    }

}
