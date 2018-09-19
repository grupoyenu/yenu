<?php

    include_once '../lib/conf/Constantes.php';
    include_once '../lib/conf/ObjetoDatos.php';
    include_once '../lib/conf/Utilidades.php';
    include_once '../modelos/aulas/Aula.php';
    include_once '../modelos/cursadas/Clase.php';
    include_once '../modelos/cursadas/Cursada.php';
    include_once '../modelos/cursadas/Cursadas.php';
    include_once '../modelos/carreras/Plan.php';
    
    session_start();
    
    $redireccion = Constantes::HOMEURL;
    
    $accion = $_POST['accion'];
      
    switch ($accion) {
        case "importar":
            $redireccion = "/tempus/vistas/cursadas/cursada_resultado_importar.php";
            $filas = $_SESSION['cursadas'];
            $resultado = null;
            if ($filas) {
                $cursadas = new Cursadas();
                $resultado = $cursadas->crear($filas);
            } else {
                $mensaje = "No se pudo obtener la información a cargar";
                $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>NULL);
            }
            $_SESSION['cursadas'] = NULL;
            $_SESSION['resultado'] = $resultado;
            break;
        case "crear":
            $redireccion = Constantes::APPURL."/vistas/cursadas/cursada_resultado_crear.php";
            $mensaje = "";
            $resultado = null;
            /* Obtiene los datos del formulario */
            $codigocarrera = $_POST['codigoCarrera'];
            $nombrecarrera = Utilidades::convertirCamelCase($_POST['txtCarrera']);
            $nombreasignatura = Utilidades::convertirCamelCase($_POST['txtAsignatura']);
            $anio = $_POST['selectAnio'];
            
            /* Crea la carrera y asignatura */
            $carrera = new Carrera();
            $asignatura = new Asignatura();
            $carrera->crear($codigocarrera, $nombrecarrera);
            $asignatura->crear($nombreasignatura);
            
            if ($asignatura->getIdasignatura() && $carrera->getCodigo()) {
                /* Se han creado o encontrado la carrera y asignatura en la BD */
                $plan = new Plan();
                
                $plan->buscar($asignatura->getIdasignatura(),  $carrera->getCodigo());
                
                if(!$plan->getAsignatura() && !$plan->getCarrera()) {
                    
                    if ($plan->crear($asignatura->getIdasignatura(), $carrera->getCodigo(), $anio)) {
                        /* Se ha creado la carrera, asignatura y la relación */
                        $plan->setAsignatura($asignatura);
                        $plan->setCarrera($carrera);
                        
                        $cursada = new Cursada();
                        $clases = array();
                        
                        for ($i=1; $i<7; ++$i) {
                            $dia = 'cbDiasClase'.$i;
                            
                            if (isset($_POST[$dia])) {
                                
                                $aula = new Aula();
                                $nombresector = $_POST['txtSector'.$i];
                                $nombreaula = $_POST['txtAula'.$i];
                                $aula->crear($nombreaula, $nombresector);
                                if ($aula->getIdaula()) {
                                    $desde = $_POST['selectHoraInicio'.$i];
                                    $hasta = $_POST['selectHoraFin'.$i];
                                    /* Crea la clase y setea sus valores */
                                    $clase = new Clase();
                                    $clase->setDia($i);
                                    $clase->setDesde($desde);
                                    $clase->setHasta($hasta);
                                    $clase->setAula($aula);
                                    /* Agrega la clase al array */
                                    $clases [] = $clase;
                                }
                            }
                        }
                        
                        if ($cursada->crear($plan, $clases)) {
                            $mensaje = "Se ha realizado la creación de la cursada correctamente";
                            $resultado = array('resultado'=>TRUE,'mensaje'=>$mensaje, 'datos'=>$cursada);
                        } else {
                            $mensaje = "No se ha podido realizar la creacíon de la cursada";
                            $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>NULL);
                        }
                    } else {
                        $mensaje = "No se ha podido realizar la creación de la relacion entre carrera y asignatura para la cursada";
                        $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>NULL);
                    }
                    
                } else {
                    $mensaje = "Ya existe creada una cursada para la carrera y asignatura indicada";
                    $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>NULL);
                }
            } else {
                $mensaje = "No se ha podido realizar la creación de la carrera y/o asignatura a la cual pertenece la cursada";
                $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>NULL);
            }
            $_SESSION['resultado'] = $resultado;
            break;
        case "buscar":
            $redireccion = Constantes::APPURL."/vistas/cursadas/cursada_resultado_buscar.php";
            $cursadas = new Cursadas();
            $asignatura = $_POST['txtAsignatura'];
            $_SESSION['resultado'] = $cursadas->buscar($asignatura);
            
            break;
        case "borrar":
            
            break;
        case "modificar":
            $redireccion = Constantes::APPURL."/vistas/cursadas/cursada_modificar.php";
            $resultado =  $_SESSION['resultado'];
            if (isset($resultado)) {
                if (isset($resultado['datos'])) {
                    $indice = $_POST['radioCursadas'];
                    if (isset($indice)) {
                        $cursadas = $resultado['datos'];
                        $cursada = $cursadas[$indice];
                        $resultado = array('resultado'=>TRUE,'mensaje'=>NULL, 'datos'=>$cursada);
                    } else {
                        $mensaje = "No se pudo obtener el indice del horario de cursada seleccionado";
                        $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>NULL);
                    }
                } else {
                    $mensaje = "No se pudo obtener la información de los horarios de cursadas que se han buscado";
                    $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>NULL);
                }
                
            } else {
                $mensaje = "No se pudo obtener la información del horario de cursada seleccionado";
                $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>NULL);
            }
            $_SESSION['resultado'] = $resultado;
            break;
        case "modificarCursada":
            
            break;
        case "crearclase":
            $redireccion = Constantes::APPURL."/vistas/cursadas/cursada_modificar.php";
            $resultado =  $_SESSION['resultado'];
            if(isset($resultado)) {
                $cursada = $resultado['datos'];
                $dia = $_POST['radDias'];
                $horainicio = $_POST['selectHoraInicio'.$dia];
                $horafin = $_POST['selectHoraFin'.$dia];
                $sector = $_POST['txtSector'.$dia];
                $nombreaula = $_POST['txtAula'.$dia];
                $aula = new Aula();
                $aula->crear($nombreaula, $sector);
                if($aula->getIdaula()) {
                    $clase = new Clase();
                    $clase->crear($dia, $horainicio, $horafin, $aula);
                    if($clase->getIdclase()) {
                        $clases = $cursada->getClases();
                        $clases[$dia] = $clase;
                        $cursada->setClases($clases);
                        $mensaje = "Se ha realizado la creación de la clase correctamente";
                    } else {
                        $mensaje = "No se ha podido realizar la creación de la clase";
                    }
                } else {
                    $mensaje = "No se ha podido realizar la creación de la clase";
                }
                $resultado = array('resultado'=>TRUE,'mensaje'=>$mensaje, 'datos'=>$cursada);
                
            } else {
                $mensaje = "No se pudo obtener la información de la clase seleccionada para crear";
                $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>null);
            }
            
            $_SESSION['resultado'] = $resultado;
            break;
        case "modificarclase":
            $redireccion = Constantes::APPURL."/vistas/cursadas/cursada_modificar.php";
            $resultado =  $_SESSION['resultado'];
            if(isset($resultado)) {
               
                $dia = $_POST['radDias'];
                $idclase = $_POST['idclase'.$dia];
                $horainicio = $_POST['selectHoraInicio'.$dia];
                $horafin = $_POST['selectHoraFin'.$dia];
                $sector = $_POST['txtSector'.$dia];
                $nombreaula = $_POST['txtAula'.$dia];
                
                $cursada = $resultado['datos'];
                $clase = $clases[$dia];
                $aula = $clase->getAula();
                
                if(($aula->getSector() != $sector) || ($aula->getNombre() != $nombreaula)) {
                    $mensaje = "Modifca aula: ".$dia." / ".$idclase." / ".$horainicio." / ".$horafin." / ".$sector." / ".$aula;
                } else {
                    $mensaje = $dia." / ".$idclase." / ".$horainicio." / ".$horafin." / ".$sector." / ".$aula;
                }
                $resultado = array('resultado'=>TRUE,'mensaje'=>$mensaje, 'datos'=>$cursada);
                
            } else {
                $mensaje = "No se pudo obtener la información de la clase seleccionada para modificar";
                $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>null);
            }
            $_SESSION['resultado'] = $resultado;
            
            break;
        case "borrarclase":
            $redireccion = Constantes::APPURL."/vistas/cursadas/cursada_modificar.php";
            $resultado =  $_SESSION['resultado'];
            if(isset($resultado)) {
                $dia = $_POST['radDias'];
                $idclase = $_POST['idclase'.$dia];
                $cursada = $resultado['datos'];
                $clases = $cursada->getClases();
                $clase = $clases[$dia];
                $clase->borrar($idclase);
                if($clase->getIdclase()) {
                    $clases[$dia] = null;
                    $cursada->setClases($clases);
                    $mensaje = "Se ha realizado la eliminación de la clase correctamente";
                } else {
                    $mensaje = $dia." / ".$idclase." : No se ha eliminado";
                }
                $resultado = array('resultado'=>TRUE,'mensaje'=>$mensaje, 'datos'=>$cursada);
            } else {
                $mensaje = "No se pudo obtener la información de la clase seleccionada para borrar";
                $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>null);
            }
            $_SESSION['resultado'] = $resultado;
            break;
    }
   
    header("Location: ".$redireccion);