<?php


if(empty($POST)) {
    /* SE RECIBE LA INFORMACION DESDE EL FORMULARIO  */
    
    require_once '../controladores/Autoload.php';
    $autoload = new Autoload();
    $autoload->autoloadProcesa();
    
    $idaula = $_POST['idaula'];
    
    $controladorAula = new ControladorAula();
    
    
} else {
    /* NO SE RECIBE LA INFORMACION DESDE EL FORMULARIO  */
    $mensaje = "No se obtuvieron los datos del formulario de búsqueda";
    echo '<div class="alert alert-danger text-center" role="alert">' . $mensaje . '</div>';
}