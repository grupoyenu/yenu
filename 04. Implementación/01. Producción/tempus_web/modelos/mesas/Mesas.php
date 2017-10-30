<?php

/**
 * 
 * */
class Mesas 
{
    /** @var MesaExamen[] */
    private $mesas;
    
    /** @var mysqli_result */
    private $datos;
    
    /**
     * Constructor de clase.
     * */
    function _construct()
    {
        $this->mesas = array();
    }
    
    public function agregarMesa() {
        
    }
    
    /**
     * Realiza la creación de un conjunto de mesas de examen.
     * @param array $mesas Recibe las filas del archivo a cargar.
     * */
    public function crear($mesas = array()) 
    {
        $this->borrar();
        
        $tamanio = count($mesas);
        $columnas = count($mesas[0]);
        $contadorexitos = 0;
        $mensaje = "";
        
       
        $carrera = new Carrera();
        $asignatura = new Asignatura();
        $plan = new Plan();
        $plan->setAsignatura($asignatura);
        $plan->setCarrera($carrera);
        $presidente = new Docente();
        $vocal1 = new Docente();
        $vocal2 = new Docente();
        $suplente = new Docente();
        $tribunal = new Tribunal();
        $mesa = new MesaExamen();
        $primero = new Llamado();
        $segundo = new Llamado();
        
        for ($i=0; $i < $tamanio; $i++) {
            
            $fila = $mesas[$i];
            
            $codigocarrera = $fila[0];
            $nombrecarrera = $fila[1];
            $nombreasignatura = $fila[2];
            $nombrepresidente = $fila[3];
            $nombrevocal1 = $fila[4];
            $nombrevocal2 = $fila[5];
            $nombresuplente = $fila[6];
            $fechaprimero = $fila[7];
            if ($columnas == 10) {
                $fechasegundo = $fila[8];
                $hora = $fila[9];
            } else {
                $hora = $fila[8];
            }
            
            /* Se verifica si la carrera ya se uso en la fila anterior */
            if($codigocarrera != $carrera->getCodigo()) {
                $carrera->crear($codigocarrera, $nombrecarrera);
            }
            
            /* Se verifica si la asignatura ya se uso en la fila anterior */
            if ($nombreasignatura != $asignatura->getIdasignatura()) {
                $asignatura->crear($nombreasignatura);
            }
            
            if (($codigocarrera != $plan->getCarrera()->getCodigo()) || ($nombreasignatura != $plan->getAsignatura()->getNombre())) {
                $plan->crear($asignatura->getIdasignatura(), $carrera->getCodigo(), 1);
            }
            
            $plan->setAsignatura($asignatura);
            $plan->setCarrera($carrera);
            
            $presidente->crear($nombrepresidente);
            $vocal1->crear($nombrevocal1);
            $vocal2->setIdDocente(null);
            $vocal2->setNombre(null);
            $suplente->setIdDocente(null);
            $suplente->setNombre(null);
            
            if ($nombrevocal2) {
                /* Solo si hay vocal1 se verifica que haya suplente */
                $vocal2->crear($nombrevocal2);
                if ($nombresuplente) {
                    $suplente->crear($nombresuplente);
                }
            }
            
            $tribunal->setPresidente($presidente);
            $tribunal->setVocal1($vocal1);
            $tribunal->setVocal2($vocal2);
            $tribunal->setSuplente($suplente);
            
            $primero->setFecha($fechaprimero);
            $primero->setHora($hora);
            $primero->setAula(null);
            
            $segundo->setFecha($fechaprimero);
            $segundo->setHora($hora);
            $segundo->setAula(null);
            
            $mesa->crear($plan, $tribunal, $primero, $segundo);
            
            if ($mesa->getIdmesa()) {
                $contadorexitos = $contadorexitos + 1;
            }
        }
        
        if ($contadorexitos > 0) {
            $mensaje = "Se han creado un total de ".$contadorexitos." mesas, sobre un total de ".$tamanio." mesas recibidas. ";
            
        } else {
            $mensaje = "No se han creado mesas de examen para un total de ".$tamanio." mesas recibidas. ";
        }
        
        $resultado = array('resultado'=>true,'mensaje'=>$mensaje, 'datos'=>NULL);
        return $resultado;
    } 
    
    /**
     * Realiza la búsqueda de un conjunto de mesas de examen. Cuando se indica un nombre de
     * asignatura, se busca las mesas de dicha asignatura. En caso contrario, se realiza la
     * búsqueda de todas las mesas de examen cargadas en el sistema.
     * @param string $asignatura Nombre de la asignatura que se desea saber las mesas.
     * */
    public function buscar($asignatura = null)
    {
        $consulta = "SELECT me.idmesa, me.idasignatura, me.idcarrera, me.idtribunal, me.primero, me.segundo ";
        $consulta = $consulta."FROM mesa_examen me, asignatura a WHERE me.idasignatura=a.idasignatura ";            
        if ($asignatura) {
            $consulta = $consulta."AND a.nombre LIKE '%".$asignatura."%'";
        }
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        $tamanio =  $this->datos->num_rows;
        if($tamanio > 0) {
            $datos = array();
            while ($fila = mysqli_fetch_array($this->datos)) {
                $mesa = new MesaExamen();
                $mesa->setIdmesa($fila[0]);
                $plan = new Plan($fila[1], $fila[2]);
                $mesa->setPlan($plan);
                $tribunal = new Tribunal($fila[3]);
                $mesa->setTribunal($tribunal);
                $primero = new Llamado($fila[4]);
                $mesa->setPrimero($primero);
                if($fila[5]) {
                    $segundo = new Llamado($fila[5]);
                    $mesa->setSegundo($segundo);
                } else {
                    $mesa->setSegundo(null);
                }
                $datos[] = $mesa;
            }
            $mensaje = "Se han encontrado resultados para la búsqueda";
            return array('resultado'=>true,'mensaje'=>$mensaje, 'datos'=>$datos);
            
        } else {
            $mensaje = "No se han encontrado resultados para la asignatura";
            if ($asignatura) {
                $mensaje = $mensaje." '".$asignatura."' ";
            }
            return array('resultado'=>true,'mensaje'=>$mensaje, 'datos'=>NULL);
        }
    }
    
    /**
     * Realiza la eliminacion de todas las mesas de examen cargadas en la base 
     * de datos. Para ello se realiza la eliminación de los registros de la tabla
     * mesa de examen, llamado, tribunal y docente.
     * @author Marquez Emanuel.
     * */
    public function borrar()
    {   
        ObjetoDatos::getInstancia()->ejecutarQuery("DELETE FROM mesa_examen WHERE 1");
        $mesas = ObjetoDatos::getInstancia()->affected_rows;
        ObjetoDatos::getInstancia()->ejecutarQuery("DELETE FROM llamado WHERE 1");
        $llamado = ObjetoDatos::getInstancia()->affected_rows;
        ObjetoDatos::getInstancia()->ejecutarQuery("DELETE FROM tribunal WHERE 1");
        $tribunal = ObjetoDatos::getInstancia()->affected_rows;
        ObjetoDatos::getInstancia()->ejecutarQuery("DELETE FROM docente WHERE 1");
        $docente = ObjetoDatos::getInstancia()->affected_rows;
        
        if (($mesas > 0) && ($llamado > 0) && ($tribunal > 0) && ($docente > 0)) {
           return true;
        }
        return false;
    }
    
    /**
     * Realiza la cuenta de la cantidad de mesas de examen que tienen segundo llamado.
     * Cuando el conteo es cero significa que no hay mesas con dos llamados, por lo
     * tanto la cantidad de llamados para el turno será uno.
     * @return integer Cero si tiene un llamado, entero mayor a cero en caso contrario.
     * @author Marquez Emanuel.
     * */
    public function cantidadLlamados()
    {
        $consulta = "SELECT COUNT(idmesa) FROM mesa_examen WHERE segundo IS NOT NULL";
        $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery($consulta);
        if ($this->datos->num_rows) {
            $fila = mysqli_fetch_array($this->datos);
            return $fila[0];
        }
        return 0;
    }
}
