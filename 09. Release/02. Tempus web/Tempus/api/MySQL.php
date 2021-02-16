<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use app\modelo\Encriptador;

class MySQL extends mysqli {

    public static $instancia;

    public function __construct() {
        global $g_db_hostname, $g_db_basename, $g_db_username, $g_db_password, $g_crypto_key;
        $encriptador = new Encriptador();
        $host = $encriptador->desencriptar($g_db_hostname, $g_crypto_key);
        $base = $encriptador->desencriptar($g_db_basename, $g_crypto_key);
        $user = $encriptador->desencriptar($g_db_username, $g_crypto_key);
        $pass = $encriptador->desencriptar($g_db_password, $g_crypto_key);
        parent::__construct($host, $user, $pass, $base);
    }

    public static function getInstancia() {
        if (!self::$instancia instanceof self) {
            try {
                self::$instancia = new self;
            } catch (Exception $e) {
                die("Error de conexion a la base de datos: " . $e->getCode() . ".");
            }
        }
        return self::$instancia;
    }

}
