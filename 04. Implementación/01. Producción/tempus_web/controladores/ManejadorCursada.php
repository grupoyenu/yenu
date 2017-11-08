<?php

    include_once '../lib/conf/Constantes.php';
    include_once '../lib/conf/ObjetoDatos.php';
    
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
            $redireccion = Constantes::APPURL."/vistas/cursadas/file.php";
            
            
            
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