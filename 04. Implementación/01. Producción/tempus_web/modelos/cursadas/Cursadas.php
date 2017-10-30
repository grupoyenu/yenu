<?php

/**
 * 
 * */
class Cursadas 
{
    /** @var mysqli_result */
    private $datos;
    
    /**
     * @param Cursada[] $cursadas
     * */
    public function crear($cursadas = array())
    {
        $mensaje = "";
        /*
        echo '<pre>'; print_r($cursadas); echo '</pre>';
        */
        
        if($this->borrar()) {
            
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
                
                $cursada->crear($plan, $clases);
            }   
        }
    }
    
    /**
     * Realiza la eliminacion de los registros de clases y curdasadas de la base
     * de datos.
     * @return boolean true o false.
     * @author Márquez Emanuel.
     * */
    public function borrar()
    {
        ObjetoDatos::getInstancia()->ejecutarQuery("DELETE FROM clase WHERE 1");
        $clases = ObjetoDatos::getInstancia()->affected_rows;
        
        ObjetoDatos::getInstancia()->ejecutarQuery("DELETE FROM cursada WHERE 1");
        $cursada = ObjetoDatos::getInstancia()->affected_rows;
        
        if (($clases > 0) && ($cursada > 0)) {
            return true;
        }
        return false;
    }
    
    /**
     * Realiza la búsqueda de horarios de cursada para una asignatura. Cuando 
     * no se establece el nombre de la asignatura, se obtienen todos los 
     * horarios cargados.
     * @param string $asignatura Nombre de la Asignatura.
     * @return array resultado, mensaje y datos.
     * @author Márquez Emanuel.
     * */
    public function buscar($asignatura) 
    {
        $consulta =  " SELECT cu.idasignatura, cu.idcarrera " 
                    ." FROM cursada cu, asignatura a, carrera ca WHERE "
                    ." cu.idasignatura=a.idasignatura AND cu.idcarrera=ca.codigo ";
        if ($asignatura) {
            $consulta = $consulta." AND a.nombre LIKE '%{$asignatura}%'";
        } 
        
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        $tamanio =  $this->datos->num_rows;
        if($tamanio > 0) {
            
            $registros = array();
            $plan = new Plan();
            while ($fila = mysqli_fetch_array($this->datos)) {
                
                $idasignatura = $fila[0];
                $idcarrera = $fila[1];
               
                
                if ($plan->getAsignatura() && $plan->getCarrera()) {
                    
                    $asignaturaplan = $plan->getAsignatura()->getIdasignatura();
                    $carreraplan = $plan->getCarrera()->getCodigo();
                    
                    if(($idasignatura != $asignaturaplan) || ($idcarrera != $carreraplan)) {
                        
                        $plan = new Plan($idasignatura, $idcarrera);
                        $cursada = new Cursada();
                        $cursada->setPlan($plan);
                        $cursada->obtenerHorarios($idasignatura, $idcarrera);
                        $registros [] = $cursada;
                    }
                    
                } else {
                    $plan = new Plan($idasignatura, $idcarrera);
                    $cursada = new Cursada();
                    $cursada->setPlan($plan);
                    $cursada->obtenerHorarios($idasignatura, $idcarrera);
                    $registros [] = $cursada;
                }
            }
            
            $mensaje = "Se han encontrado resultados para la búsqueda";
            if ($asignatura) {
                $mensaje = " '{$asignatura}' ";
            }
            return array('resultado'=>true,'mensaje'=>$mensaje, 'datos'=>$registros);
        } else {
            $mensaje = "No se han encontrado resultados para la búsquda";
            if ($asignatura) {
                $mensaje = " '{$asignatura}' "; 
            }
        }
    }
    
    
    
}
