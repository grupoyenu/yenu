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
                                $aula->crear($nombresector, $nombresector);
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
            
            break;
        case "modificacion":
            
            break;
    }
    
    header("Location: ".$redireccion);