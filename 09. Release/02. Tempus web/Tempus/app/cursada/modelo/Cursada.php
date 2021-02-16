<?php

namespace app\cursada\modelo;

use app\principal\modelo\Conexion;

/**
 * 
 * @package app\cursada\modelo.
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
class Cursada {

    private $plan;
    private $clases;

    public function __construct($plan = NULL) {
        $this->plan = $plan;
        $this->clases = array();
    }

    public function getPlan() {
        return $this->plan;
    }

    public function getClases() {
        return $this->clases;
    }

    public function setPlan($plan) {
        $this->plan = $plan;
    }

    public function agregarClase(Clase $clase) {
        $cantidad = count($this->clases);
        if ($cantidad < 8) {
            if ($this->verificar($clase->getDiaSemana())) {
                $this->clases[] = $clase;
                return true;
            }
        }
        return false;
    }

    public function borrarCursada() {
        if ($this->plan) {
            $consulta = "DELETE FROM clase WHERE idPlan = {$this->plan}";
            return Conexion::getInstancia()->borrar($consulta);
        }
        return array(0, "No se pudo hacer referencia al plan");
    }

    public function borrar() {
        if (count($this->clases) > 0) {
            $clases = $this->clases;
            $resultado = TRUE;
            foreach ($clases as $clase) {
                $eliminacion = $clase->borrar();
                $resultado = ($eliminacion[0] == 2) ? $resultado : FALSE;
            }
            if ($resultado) {
                return array(2, "Se realizó la eliminación de clases correctamente");
            }
            return array(1, "No se realizó la eliminación de clases porque no se eliminaron todas las clases");
        }
        return array(0, "La cursada no contiene clases para borrar");
    }

    public function crear() {
        if (count($this->clases) > 0) {
            $clases = $this->clases;
            $resultado = TRUE;
            foreach ($clases as $clase) {
                $clase->setPlan($this->plan);
                $creacion = $clase->crear();
                $resultado = ($creacion[0] == 2) ? $resultado : FALSE;
            }
            if ($resultado) {
                return array(2, "Se realizó la creación de la cursada correctamente");
            }
            return array(1, "No se realizó la creación de la cursada porque no se crearon todas las clases");
        }
        return array(0, "La cursada no contiene clases para crea");
    }

    public function modificar() {
        if (count($this->clases) > 0) {
            $clases = $this->clases;
            $resultado = TRUE;
            foreach ($clases as $clase) {
                $edicion = ($clase->getId()) ? $clase->modificar() : $clase->crear();
                $resultado = ($edicion[0] == 2) ? $resultado : FALSE;
            }
            if ($resultado) {
                return array(2, "Se realizó la modificación de la cursada correctamente");
            }
            return array(1, "No se realizó la modificación de la cursada porque no se modificaron todas las clases");
        }
        return array(0, "La cursada no contiene clases para modificar");
    }

    public function obtenerPorIdentificador() {
        if ($this->plan) {
            $consulta = "SELECT id FROM clase WHERE idPlan = {$this->plan} ORDER BY diaSemana";
            $resultado = Conexion::getInstancia()->seleccionar($consulta);
            if ($resultado[0] != 2) {
                return $resultado;
            }
            $obtenidos = TRUE;
            $this->clases = array();
            $registros = $resultado[1];
            foreach ($registros as $fila) {
                $clase = new Clase($fila['id']);
                $obtener = $clase->obtenerPorIdentificador();
                if ($obtener[0] == 2) {
                    $dia = $clase->getDiaSemana();
                    $this->clases[$dia] = $clase;
                } else {
                    $obtenidos = FALSE;
                }
            }
            return ($obtenidos) ? array(2, "Se obtuvo la información de la cursada") : array(1, "No se obtuvo la cursada");
        }
        return array(0, "No se pudo hacer referencia a la cursada");
    }

    private function verificar($dia) {
        $cantidad = count($this->clases);
        $contador = 0;
        while ($contador < $cantidad) {
            $clase = $this->clases[$contador];
            if ($dia == $clase->getDiaSemana()) {
                return false;
            }
            $contador++;
        }
        return true;
    }

}
