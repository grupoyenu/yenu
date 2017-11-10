<?php
    header('Access-Control-Allow-Origin: *');
    
    // Define database connection parameters
    
    $hn      = 'localhost';
    $un      = 'root';
    $pwd     = '';
    $db      = 'tempus';
    $cs      = 'utf8';
    
    // Set up the PDO parameters
    $dsn  = "mysql:host=" . $hn . ";port=3306;dbname=" . $db . ";charset=" . $cs;
    $opt  = array(
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_EMULATE_PREPARES   => false,
    );
    
    // Create a PDO instance (connect to the database)
    $pdo  = new PDO($dsn, $un, $pwd, $opt);
    $opcion  = strip_tags($_REQUEST['key']);
    $data = array();
    
    switch ($opcion) {
        
        case "buscarCursada":
            $carrera = filter_var($_REQUEST['carrera'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $asignatura = filter_var($_REQUEST['asignatura'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $anio = filter_var($_REQUEST['anio'], FILTER_SANITIZE_NUMBER_INT);
            
            try {
                /** Controla que los campos obligatorios hayan llegado */
                if ($carrera && $asignatura && $anio) {
                    
                    $consulta = "SELECT cu.idasignatura, cu.idcarrera, cl.dia, DATE_FORMAT(cl.desde, '%H:%i') as desde,"
                               ." DATE_FORMAT(cl.hasta, '%H:%i') as hasta, au.sector, au.nombre "
                               ." FROM cursada cu, clase cl, aula au, asignatura asi, carrera ca, asignatura_carrera ac "
                               ." WHERE cu.idclase=cl.idclase AND cu.idasignatura = ac.idasignatura AND cu.idcarrera=ac.idcarrera "
                               ." AND ac.idasignatura = asi.idasignatura AND ac.idcarrera=ca.codigo AND cl.idaula = au.idaula "
                               ." AND ac.anio = {$anio} AND asi.nombre LIKE '%{$asignatura}%' AND ca.nombre LIKE '%{$carrera}%'";
                    
                   
                    $stmt = $pdo->query($consulta);
                    
                    $data[] = array ('message' =>$consulta);
                    while($row  = $stmt->fetch(PDO::FETCH_OBJ)) {
                        $data[] = $row;
                    }
                    echo json_encode($data);
                } else {
                    $data[] = array ('message' =>"No se ha obtenido la información necesaria para consultar horarios de cursada");
                    echo json_encode($data);
                }
                
            } catch (PDOException $e) {
                $data[] = array ('message' =>"Error al buscar cursada: ". $e->getMessage());
                echo json_encode($data);
            }
            
            break;
            
        case "buscarMesa":
            
            break;
            
        case "agregarFavorito":
            
            break;
        case "favoritoCursada":
            
            break;
        case "favoritoMesa":
            
            break;
        default:
            echo "No se ha obtenido la opción a realizar";
            break;
            
    }


?>