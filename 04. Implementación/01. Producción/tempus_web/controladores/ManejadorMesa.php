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


    $redireccion = "/tempus/vistas/index.php";
    $accion = $_POST['accion'];

    
    switch ($accion) {
        case "seleccionar":
            $redireccion = "/tempus/vistas/mesas/mesa_importar.php";
            break;
        case "importar":
        
            break;
        case "crear":
            $redireccion = "/tempus/vistas/mesas/mesa_crear.php";
            break;
        case "buscar":
            
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
    