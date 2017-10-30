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
    
    include_once '../modelos/mesas/Mesas.php';
    include_once '../modelos/mesas/MesaExamen.php';
    include_once '../modelos/carreras/Plan.php';
    include_once '../modelos/mesas/Tribunal.php';
    include_once '../modelos/mesas/Llamado.php';
    
    include_once '../modelos/carreras/Carrera.php';
    include_once '../modelos/carreras/Asignatura.php';
    include_once '../modelos/mesas/Docente.php';
    
    session_start();

    $redireccion = "/tempus/vistas/mesas/mesa_resultado_importar.php";
    
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
                $mensaje = "No se pudo obtener la informaci�n a cargar.";
                $resultado = array('resultado'=>FALSE,'mensaje'=>$mensaje, 'datos'=>NULL);
            }
            
            $_SESSION['mesas'] = NULL;
            $_SESSION['resultado'] = $resultado;
            break;
        case "crear":
            $redireccion = Constantes::APPURL."/vistas/mesas/mesa_crear.php";
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
            
            break;
            
        default:
            ;
        break;
    }

    
    header("Location: ".$redireccion);
    