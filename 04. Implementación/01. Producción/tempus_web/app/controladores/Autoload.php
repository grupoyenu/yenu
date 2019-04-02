<?php

/**
 * Permite incluir los archivos que se van a utilizar durante el uso del sistema.
 * La sentencia require_once permite verificar si un archivo ya ha sido incluido
 * para no repetirlo o incluirlo si no esta.
 *
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
class Autoload {

    /**
     * Constructor de Autoload. Utiliza el metodo SPL_AUTOLOAD_REGISTER con una
     * funcion anonima para incluir las clases. Utiliza la ruta para los modelos
     * junto con la ruta para los controladores y los declara usando require
     * once.
     */
    public function __construct() {
        spl_autoload_register(function($className) {
            $pathModels = "./app/modelos/" . $className . ".php";
            $pathController = "./app/controladores/" . $className . ".php";
            if (file_exists($pathModels)) {
                require_once ($pathModels);
            }
            if (file_exists($pathController)) {
                require_once ($pathController);
            }
        });
    }
    
    /** 
     * Utiliza el metodo SPL_AUTOLOAD_REGISTER con una funcion anonima para incluir
     * las clses desde la carpeta vistas. Utiliza la ruta para los modelos junto
     * con la ruta para los controlador y los declara usando require once.
     */
    public function autoloadProcesa() {
        spl_autoload_register(function($className) {
            $pathModels = "../modelos/" . $className . ".php";
            $pathController = "../controladores/" . $className . ".php";
            if (file_exists($pathModels)) {
                require_once ($pathModels);
            }
            if (file_exists($pathController)) {
                require_once ($pathController);
            }
        });
    }

}