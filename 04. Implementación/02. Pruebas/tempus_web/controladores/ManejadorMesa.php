<?php
/**
 * ManejadorMesa. Cuando se realiza alguna operacion sobre los formularios
 * correspondientes a las mesas de examen, se envia hacia aqui. El input tipo
 * hidden del formulario debe indicar la accion que se est� realizando. 
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
include_once '../modelos/mesas/Docentes.php';
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
            $mensaje = "No se pudo obtener la informaci�n a cargar";
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
                
                /* procede con la creaci�n del tribunal */
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
                        $mensaje = "No se ha podido realizar la creaci�n u obtenci�n del aula para la mesa de examen ({$sector},{$nombreaula})";
                        $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>NULL);
                    }
                    
                } else {
                    $mensaje = "No se ha podido realizar la creaci�n del tribunal para la mesa de examen";
                    $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>NULL);
                }
            } else {
                $mensaje = "No se ha podido realizar la creaci�n de la relacion entre carrera y asignatura para la mesa de examen";
                $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>NULL);
            }
        } else {
            $mensaje = "No se ha podido realizar la creaci�n de la carrera y/o asignatura a la cual pertenece la mesa de examen";
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
        if (isset($resultado) && isset($resultado['datos'])) {
            $indice = $_POST['radioMesas'];
            if (isset($indice)) {
                $docentes = new Docentes();
                $mesas = $resultado['datos'];
                $mesa = $mesas[$indice];
                $resultado = array('resultado'=>TRUE,'mensaje'=>NULL, 'datos'=>$mesa);
                $_SESSION['docentes'] = $docentes->getDocentes();
            } else {
                $mensaje = "No se pudo obtener el indice la mesa seleccionada";
                $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>NULL);
            }
        } else {
            $mensaje = "No se pudo obtener la informaci�n de la mesa seleccionada";
            $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>NULL);
        }
        $_SESSION['resultado'] = $resultado;
        break;
    case "modificarTribunal":
        $redireccion = Constantes::APPURL."/vistas/mesas/mesa_modificar.php";
        $resultado =  $_SESSION['resultado'];
        if (isset($resultado) && isset($resultado['datos'])) { 
            $mesa = $resultado['datos'];
            $tribunal = $mesa->getTribunal();
            $nombrepresidente = $_POST['txtNombrePresidente'];
            $nombrevocal1 = $_POST['txtNombreVocal1'];
            $nombrevocal2 = $_POST['txtNombreVocal2'];
            $nombresuplente = $_POST['txtNombreSuplente'];
            
            $modificacion = $mesa->modificarTribunal($tribunal, $nombrepresidente, $nombrevocal1, $nombrevocal2, $nombresuplente);
            if ($modificacion) {
                $mesa->setTribunal($tribunal);
                $mensaje = "Se ha realizado la modificaci�n del tribunal correctamente";
                $resultado = array('resultado'=>TRUE,'mensaje'=>$mensaje, 'datos'=>$mesa);
            } else {
                $mensaje = "No se ha realizado la modificaci�n del tribunal";
                $resultado = array('resultado'=>TRUE,'mensaje'=>$mensaje, 'datos'=>$mesa);
            }
        } else {
            $mensaje = "No se pudo obtener la informaci�n del llamado a modificar. Intente nuevamente";
            $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>null);
        }
        $_SESSION['resultado'] = $resultado;
    break;
    case "modificarLlamado":
        $redireccion = Constantes::APPURL."/vistas/mesas/mesa_modificar.php";
        $resultado =  $_SESSION['resultado'];
        if (isset($resultado) && isset($resultado['datos'])) {
            $mesa = $resultado['datos'];
            $llamado = $_POST['llamado'];
            if($llamado == 1) {
                $primerllamado = $mesa->getPrimero();
                $idprimero = $primerllamado->getIdllamado();
                $fecha = $_POST['datePrimerLlamado'];
                $primerllamado->modificarFecha($idprimero, $fecha);
                if($primerllamado->getIdllamado()) {
                    $mesa->setPrimero($primerllamado);
                    $mensaje = "Se ha realizado la modificaci�n del primer llamado correctamente";
                    $resultado = array('resultado'=>TRUE,'mensaje'=>$mensaje, 'datos'=>$mesa);
                } else {
                    $mensaje = "No se pudo realizar la modificaci�n del primer llamado";
                    $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>$mesa);
                }
            } else {
                $segundollamado = $mesa->getSegundo();
                $idsegundo = $segundollamado->getIdllamado();
                $fecha = $_POST['dateSegundoLlamado'];
                $segundollamado->modificarFecha($idsegundo, $fecha);
                if($segundollamado->getIdllamado()) {
                    $mesa->setSegundo($segundollamado);
                    $mensaje = "Se ha realizado la modificaci�n del segundo llamado correctamente";
                    $resultado = array('resultado'=>TRUE,'mensaje'=>$mensaje, 'datos'=>$mesa);
                } else {
                    $mensaje = "No se pudo realizar la modificaci�n del segundo llamado";
                    $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>$mesa);
                }
            }
        } else {
            $mensaje = "No se pudo obtener la informaci�n del llamado a modificar. Intente nuevamente";
            $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>null);
        }
        $_SESSION['resultado'] = $resultado;
        break;
    case "modificarHora":
        $redireccion = Constantes::APPURL."/vistas/mesas/mesa_modificar.php";
        $resultado =  $_SESSION['resultado'];
        if (isset($resultado) && isset($resultado['datos'])) {
            $mesa = $resultado['datos'];
            $hora =  $_POST['selectHora'];
            $primero = null;
            $segundo = null;
            if ($mesa->getPrimero()) {
                $primero = $mesa->getPrimero();
            }
            if ($mesa->getSegundo()) {
                $segundo = $mesa->getSegundo();
            }
            $modificacion = $mesa->modificarHora($primero, $segundo, $hora);
            if ($modificacion) {
                $mesa->setPrimero($primero);
                $mesa->setSegundo($segundo);
                $mensaje = "Se ha realizado la modificaci�n de la hora correctamente";
                $resultado = array('resultado'=>TRUE,'mensaje'=>$mensaje, 'datos'=>$mesa);
            } else {
                $mensaje = "No se pudo realizar la modificaci�n de la hora";
                $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>$mesa);
            }
        }
        $_SESSION['resultado']  = $resultado;
        break;
    case "modificarAula":
        break;
}

header("Location: ".$redireccion);
    