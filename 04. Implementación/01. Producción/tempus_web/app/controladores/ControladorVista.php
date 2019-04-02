<?php

/**
 * Permite incluir la estructura del sistema. Realiza la inclusion de la cabecera,
 * vista y pie de la pagina que se va a visualizar por navegador.
 *
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
class ControladorVista {

    /** @var string Ruta donde se ubican las vistas del sistema. */
    private static $rutaVista = "./app/vistas/";

    /**
     * Constructor del Controlador de Vistas. Define la ruta donde se encuentran
     * las vistas del sistema.
     */
    function __construct() {
    }

    /**
     * Realiza la carga de la cabecera, vista y pie de la pagina. Recibe el nombre
     * de la vista que se desea cargar y realiza la inclusion de las tres partes.
     * @param string $vista Nombre de la vista sin la extension PHP.
     */
    public function cargarVista($vista) {
        require_once (self::$rutaVista . "header.php");
        require_once (self::$rutaVista . $vista . ".php");
        //require_once (self::$rutaVista . "footer.php");
    }

}
