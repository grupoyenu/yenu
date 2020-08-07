<?php

namespace app\principal\modelo;

/**
 * paquete: principal.
 * namespace: modelos;
 */
class Log {

    public static function guardar($tipo, $texto) {
        $date = date("H:i:s");
        $url = Constantes::LOG . "\\LOG_" . date("Ymd") . ".txt";
        $file = file_exists($url) ? fopen($url, 'a') : fopen($url, 'w');
        $ip = isset($_SERVER["REMOTE_ADDR"]) ? $_SERVER["REMOTE_ADDR"] : "DESC";
        $script = explode("/", $_SERVER["SCRIPT_NAME"]);
        $archivo = $script[count($script) - 1];
        $usuario = (isset($_SESSION['user'])) ? unserialize($_SESSION['user']) : NULL;
        $user = ($usuario) ? $usuario->getEmail() : "DESC";
        $data = "[{$tipo}][HORA: {$date}][USUARIO: {$user}][IP: {$ip}][SCRIPT: {$archivo}][{$texto}]" . PHP_EOL;
        fwrite($file, $data);
    }

}
