<?php
require_once '../modelos/carreras/Carrera.php';

    echo "TEST_CARRERA<br>";
    
    
    $carrera = new Carrera();
    
    $carrera->buscar("analista de sistemas");
    echo "<br> <br>buscar analista de sistemas";
    echo "<br> carrera = 0".$carrera->getCodigo();
    echo "<br> nombre = ".$carrera->getNombre();
    
    $carrera->borrar(16);
    echo "<br> <br>borrar 16";
    echo "<br> carrera = ".$carrera->getCodigo();
    echo "<br> nombre = ".$carrera->getNombre(); 
    
    $carrera->buscar("analista de sistemas");
    echo "<br> <br>buscar analista de sistemas";
    echo "<br> carrera = 0".$carrera->getCodigo();
    echo "<br> nombre = ".$carrera->getNombre(); 