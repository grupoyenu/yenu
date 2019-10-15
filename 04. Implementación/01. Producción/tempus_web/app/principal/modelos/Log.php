<?php

class Log {

    public static function escribirLineaError($text) {
        $url = LOG . "\\errores.txt";
        $file = file_exists($url) ? fopen($url, 'a') : fopen($url, 'w');
        $date = date("Y-m-d H:i:s");
        $ip = $_SERVER["REMOTE_ADDR"];
        $script = $_SERVER["SCRIPT_NAME"];
        $data = "[{$date}][IP: {$ip}][SCRIPT: {$script}]{$text}" . PHP_EOL;
        fwrite($file, $data);
    }
    
}
