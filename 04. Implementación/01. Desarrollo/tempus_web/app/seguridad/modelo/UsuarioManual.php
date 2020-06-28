<?php

namespace app\seguridad\modelo;

use app\principal\modelo\Conexion;

/**
 * Permite obtener operar con los registros de Usuario Manual almacenados en la 
 * base de datos. 
 *
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
class UsuarioManual extends Usuario {

    private $clave;

    public function __construct($id = NULL, $email = NULL, $nombre = NULL, $estado = NULL, $rol = NULL, $clave = NULL) {
        parent::__construct($id, $email, $nombre, "Manual", $estado, $rol);
        $this->setClave($clave);
    }

    public function getClave() {
        return $this->clave;
    }

    public function setClave($clave) {
        $this->clave = $clave;
    }

}
