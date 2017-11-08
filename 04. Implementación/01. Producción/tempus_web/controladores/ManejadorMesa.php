<?php
/**
 * ManejadorMesa. Cuando se realiza alguna operacion sobre los formularios
 * correspondientes a las mesas de examen, se envia hacia aqui. El input tipo
 * hidden del formulario debe indicar la accion que se está realizando. 
 * Esa accion se captura con POST y es asignada al atributo $accion. Dependiendo
 * de la accion se realiza el redireccionamiento a quien corresponda con $redireccion.
 * 
 * 
 * @var string $redireccion Ruta absoluta desde el raiz. 
 * @var string $accion Accion que se realiza.
 * */
    include_once '../lib/conf/ObjetoDatos.php';
    include_once '../lib/conf/Constantes.php';
    include_once '../lib/conf/Utilidades.php';
    
    include_once '../modelos/mesas/Mesas.php';
    include_once '../modelos/mesas/MesaExamen.php';
    include_once '../modelos/carreras/Plan.php';
    include_once '../modelos/mesas/Tribunal.php';
    include_once '../modelos/mesas/Llamado.php';
    
    include_once '../modelos/carreras/Carrera.php';
    include_once '../modelos/carreras/Asignatura.php';
    include_once '../modelos/mesas/Docente.php';
    include_once '../modelos/aulas/Aula.php';
    
    session_start();

    $redireccion = Constantes::HOMEURL;
    
    $accion = $_POST['accion'];

    switch ($accion) {
        case "importar":
            $redireccion = "/tempus/vistas/mesas/mesa_resultado_importar.php";
            $filas = $_SESSION['mesas'];
            $resultado = null;
            if ($filas) {
                $mesas_examen = new Mesas();
                $resultado = $mesas_examen->crear($filas);
            } else {
                $mensaje = "No se pudo obtener la información a cargar";
                $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>NULL);
            }
            
            $_SESSION['mesas'] = NULL;
            $_SESSION['resultado'] = $resultado;
            break;
        case "crear":
            $redireccion = Constantes::APPURL."/vistas/mesas/mesa_resultado_crear.php";
            
            $codigocarrera = $_POST['codigoCarrera'];
            $nombrecarrera = Utilidades::convertirCamelCase($_POST['txtCarrera']);
            $nombreasignatura = Utilidades::convertirCamelCase($_POST['txtAsignatura']);
            $nombrepresidente = Utilidades::convertirCamelCase($_POST['txtNombrePresidente']);
            $nombrevocal1 = Utilidades::convertirCamelCase($_POST['txtNombreVocal1']);
            $nombrevocal2 = Utilidades::convertirCamelCase($_POST['txtNombreVocal2']);
            $nombresuplente = Utilidades::convertirCamelCase($_POST['txtNombreSuplente']);
            $primerllamado = $_POST['datePrimerLlamado'];
            $segundollamado = $_POST['dateSegundoLlamado'];
            $sector = $_POST['txtSector'];
            $nombreaula = Utilidades::convertirCamelCase($_POST['txtNombreAula']);
            $hora =  $_POST['selectHora'];
            
            $mensaje = "";
            $resultado = null;
            
            $mesa = new MesaExamen();
            $asignatura = new Asignatura();
            $asignatura->crear($nombreasignatura);
            $carrera = new Carrera();
            $carrera->crear($codigocarrera, $nombrecarrera);
            
            if ($asignatura->getIdasignatura() && $carrera->getCodigo()) {
                $plan = new Plan();
               
                if ($plan->crear($asignatura->getIdasignatura(), $carrera->getCodigo(), 1)) {
                    $plan->setAsignatura($asignatura);
                    $plan->setCarrera($carrera);
                    $tribunal = new Tribunal();
                    
                    /* procede con la creación del tribunal */
                    $presidente = new Docente();
                    $vocal1 = new Docente();
                    $vocal2 = new Docente();
                    $suplente = new Docente();
                    
                    $presidente->crear($nombrepresidente);
                    $vocal1->crear($nombrevocal1);
                    $vocal2->setIdDocente(null);
                    $suplente->setIdDocente(null);
                    
                    if ($nombrevocal2) {
                        $vocal2->crear($nombrevocal2);
                        if ($nombresuplente) {
                            $suplente->crear($nombresuplente);
                        }
                    }
                    
                    $tribunal->crear($presidente->getIdDocente(), $vocal1->getIdDocente(), $vocal2->getIdDocente(), $suplente->getIdDocente());
                    
                    if ($tribunal->getIdtribunal()) {
                        
                        $tribunal->setPresidente($presidente);
                        $tribunal->setVocal1($vocal1);
                        $tribunal->setVocal2($vocal2);
                        $tribunal->setSuplente($suplente);
                        
                        $aula = new Aula();
                        $aula->crear($nombreaula, $sector);
                        
                        if ($aula->getIdaula()) {
                            $primero = new Llamado();
                            $segundo = new Llamado();
                            
                            if ($primerllamado) {
                                $primero->setAula($aula);
                                $primero->setFecha($primerllamado);
                                $primero->setHora($hora);
                            }
                            
                            if ($segundollamado) {
                                $segundo->setAula($aula);
                                $segundo->setFecha($segundollamado);
                                $segundo->setHora($hora);
                            } else {
                                $segundo = null;
                            }
                            
                            $mensaje = $mesa->crear($plan, $tribunal, $primero, $segundo);
                            
                            if ($mesa->getIdmesa()) {
                                $resultado = array('resultado'=>TRUE,'mensaje'=>$mensaje, 'datos'=>$mesa);
                            } else {
                                $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>NULL);
                            }
                        } else {
                            $mensaje = "No se ha podido realizar la creación u obtención del aula para la mesa de examen ({$sector},{$nombreaula})";
                            $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>NULL);
                        }
                        
                    } else {
                        $mensaje = "No se ha podido realizar la creación del tribunal para la mesa de examen";
                        $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>NULL);
                    }
                } else {
                    $mensaje = "No se ha podido realizar la creación de la relacion entre carrera y asignatura para la mesa de examen";
                    $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>NULL);
                }
            } else {
                $mensaje = "No se ha podido realizar la creación de la carrera y/o asignatura a la cual pertenece la mesa de examen";
                $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>NULL);
            }
            $_SESSION['resultado'] = $resultado;
            
            break;
        case "buscar":
            $redireccion = Constantes::APPURL."/vistas/mesas/mesa_resultado_buscar.php";
            $asignatura = $_POST['txtAsignatura'];
            $mesas_examen = new Mesas();
            $_SESSION['resultado'] = $mesas_examen->buscar($asignatura);
            break;
        case "borrar":
            
            break;
        case "modificar":
            $redireccion = Constantes::APPURL."/vistas/mesas/mesa_modificar.php";
            $resultado =  $_SESSION['resultado'];
            if (isset($resultado)) {
                if (isset($resultado['datos'])) {
                    $indice = $_POST['radioMesas'];
                    if (isset($indice)) {
                        $mesas = $resultado['datos'];
                        $mesa = $mesas[$indice];
                        $resultado = array('resultado'=>TRUE,'mensaje'=>NULL, 'datos'=>$mesa);
                    } else {
                        $mensaje = "No se pudo obtener el indice la mesa seleccionada";
                        $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>NULL);
                    }
                } else {
                    $mensaje = "No se pudo obtener la información de las mesas que se han buscado";
                    $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>NULL);
                }
                
            } else {
                $mensaje = "No se pudo obtener la información de la mesa seleccionada";
                $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>NULL);
            }
            $_SESSION['resultado'] = $resultado;
            break;
        case "modificacion":
            $redireccion = Constantes::APPURL."/vistas/mesas/mesa_resultado_modificar.php";
            
            $codigocarrera = $_POST['codigoCarrera'];
            $nombrecarrera = Utilidades::convertirCamelCase($_POST['txtCarrera']);
            $nombreasignatura = Utilidades::convertirCamelCase($_POST['txtAsignatura']);
            $nombrepresidente = Utilidades::convertirCamelCase($_POST['txtNombrePresidente']);
            $nombrevocal1 = Utilidades::convertirCamelCase($_POST['txtNombreVocal1']);
            $nombrevocal2 = Utilidades::convertirCamelCase($_POST['txtNombreVocal2']);
            $nombresuplente = Utilidades::convertirCamelCase($_POST['txtNombreSuplente']);
            $primerllamado = $_POST['datePrimerLlamado'];
            $segundollamado = $_POST['dateSegundoLlamado'];
            $sector = $_POST['txtSector'];
            $nombreaula = Utilidades::convertirCamelCase($_POST['txtNombreAula']);
            $hora =  $_POST['selectHora'];
            
            
            
            $_SESSION['resultado'];
        break;
    }

    
    header("Location: ".$redireccion);
    