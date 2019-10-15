<?php

class AutoCargador {

    public static function cargarModulos() {
        spl_autoload_register(function($className) {
            $modulos = array(ASI, AUL, CAR, CUR, DOC, MES, PLA, PRI, USU);
            foreach ($modulos as $modulo) {
                $archivo = AutoCargador::evaluar($modulo, $className);
                if ($archivo) {
                    require_once ($archivo);
                    return;
                }
            }
        });
    }

    private static function evaluar($modulo, $clase) {
        $controlador = $modulo . '\\controladores\\' . $clase . '.php';
        if (file_exists($controlador)) {
            return $controlador;
        }
        $modelo = $modulo . '\\modelos\\' . $clase . '.php';
        return file_exists($modelo) ? $modelo : NULL;
    }

}
