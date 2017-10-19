<?php
require_once '../modelos/mesas/Docente.php';

    echo "TEST_DOCENTE<br>";
    
    
    
    
    $result = ObjetoDatos::getInstancia()->ejecutarQuery("SELECT * FROM docente WHERE nombre = 'Marquez Emanuel'");
    echo "<br> <br>SELECT * FROM docente WHERE nombre = 'Marquez Emanuel'";
    echo "<br> Num_rows = ".$result->num_rows;
    echo "<br> Mysqli_num_rows = ".mysqli_num_rows($result);
    
    $result = ObjetoDatos::getInstancia()->ejecutarQuery("SELECT * FROM docente WHERE nombre = 'marquez Emanuel'");
    echo "<br> <br>SELECT * FROM docente WHERE nombre = 'marquez emanuel'";
    echo "<br> Num_rows = ".$result->num_rows;
    echo "<br> Mysqli_num_rows = ".mysqli_num_rows($result);
    
    $result = ObjetoDatos::getInstancia()->ejecutarQuery("SELECT * FROM docente WHERE nombre = 'Pepito'");
    echo "<br> <br>SELECT * FROM docente WHERE nombre = 'Pepito'";
    echo "<br> Num_rows = ".$result->num_rows;
    echo "<br> Mysqli_num_rows = ".mysqli_num_rows($result);
    
    $result = ObjetoDatos::getInstancia()->ejecutarQuery("SELECT * FROM docente WHERE nombre Like '%Mar%'");
    echo "<br> <br>SELECT * FROM docente WHERE nombre Like '%Mar%'";
    echo "<br> Num_rows = ".$result->num_rows;
    echo "<br> Mysqli_num_rows = ".mysqli_num_rows($result);
    
    
    $docente = new Docente();
    
    $docente->buscar("marquez emanuel");
    echo "<br> <br>buscar marquez emanuel";
    echo "<br> iddocente = ".$docente->getIdDocente();
    echo "<br> nombre = ".$docente->getNombre();
    
    $docente->buscar("quiroga sandra");
    echo "<br> <br>buscar quiroga sandra";
    echo "<br> iddocente = ".$docente->getIdDocente();
    echo "<br> nombre = ".$docente->getNombre();
    
    $docente->buscar("pepito");
    echo "<br> <br>buscar pepito";
    
    if(!is_null($docente->getIdDocente())) {
        echo "<br> iddocente = ".$docente->getIdDocente();
        echo "<br> nombre = ".$docente->getNombre();
    } else {
        echo "<br>No se encontro con is_null";
    }
    
    if($docente->getIdDocente()) {
        echo "<br> iddocente = ".$docente->getIdDocente();
        echo "<br> nombre = ".$docente->getNombre();
    } else {
        echo "<br>No se encontro con if";
    }
    
    $docente->crear("Sofia Osiris");
    echo "<br> <br>Crea a Sofia Osiris";
    echo "<br> iddocente = ".$docente->getIdDocente();
    echo "<br> nombre = ".$docente->getNombre();
    
    $docente->borrar(7);
    echo "<br> <br>Borra id 7";
    echo "<br> iddocente = ".$docente->getIdDocente();
    echo "<br> nombre = ".$docente->getNombre();
    
    $docente->crear("marquez emanuel");
    echo "<br> <br>Crea a marquez emanuel";
    echo "<br> iddocente = ".$docente->getIdDocente();
    echo "<br> nombre = ".$docente->getNombre();
    
    $docente->crear("Sofia Osiris");
    echo "<br> <br>Crea a Sofia Osiris";
    echo "<br> iddocente = ".$docente->getIdDocente();
    echo "<br> nombre = ".$docente->getNombre();
    
    
    
  
    
    
    
    
