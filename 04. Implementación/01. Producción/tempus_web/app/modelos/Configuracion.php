<?php

class Configuracion {
   
    private $host;
    private $baseDatos;
    private $usuario;
    private $clave;
    
    function __construct() {
        $url = $_SERVER['DOCUMENT_ROOT']."/tempus3/app/config.xml";
        $conexiones = simplexml_load_file($url);
        $this->host = $conexiones->conexion[0]->host;
        $this->baseDatos = $conexiones->conexion[0]->baseDatos;
        $this->usuario = $conexiones->conexion[0]->usuario;
        $this->clave = $conexiones->conexion[0]->clave;
    }
    
    function getHost(){
        return $this->host;
    }
    
    function getBaseDatos(){
        return $this->baseDatos;
    }
    
    function getUsuario(){
        return $this->usuario;
    }
    
    function getClave(){
        return $this->clave;
    }
    
}