<?php

    header('Access-Control-Allow-Origin: *'); 
    
    /** Define los parametros para la conexion a la base de datos */
    
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "tempus";
    $cs = "utf";
    $port = "3306";
    
    
    $dsn  = "mysql:host=" . $host . ";port=". $port. ";dbname=" . $db . ";charset=" . $cs;
    $opt  = array (
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_EMULATE_PREPARES   => false,
    );
    
    // Create a PDO instance (connect to the database)
    
    $pdo  = new PDO($dsn, $user, $pass, $opt);
    
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
                    
                    $consulta = " SELECT cu.idasignatura, cu.idcarrera, cl.dia, DATE_FORMAT(cl.desde, '%H:%i'), DATE_FORMAT(cl.hasta, '%H:%i'), au.sector, au.nombre".
                                " FROM cursada cu, clase cl, aula au, asignatura asi, carrera ca, asignatura_carrera ac".
                                " WHERE cu.idclase=cl.idclase AND cl.idaula = au.idaula AND cu.idasignatura = asi.idasignatura ".
                                " AND cu.idcarrera=ca.codigo AND ac.anio = {$anio} AND asi.nombre LIKE '%{$asignatura}%' AND ca.nombre LIKE '%{$carrera}%'";
                    
                    $stmt = $pdo->query($consulta);
                    while($row  = $stmt->fetch(PDO::FETCH_OBJ)) {
                        $data[] = $row;
                    }
                    
                    echo json_encode($data);
                } else {
                    echo "No se ha obtenido la información necesaria para consultar horarios de cursada";
                }
                
            } catch (PDOException $e) {
                echo "Error al buscar cursada: ". $e->getMessage();
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
    