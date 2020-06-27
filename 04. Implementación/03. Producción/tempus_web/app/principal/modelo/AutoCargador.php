<?php

namespace app\principal\modelo;

class AutoCargador {

    public static function cargarModulos() {
        spl_autoload_register(function($clase) {
            $ruta = Constantes::ROOT . "\\$clase.php";
            if (file_exists($ruta)) {
                require_once $ruta;
            }
        });
    }

}
