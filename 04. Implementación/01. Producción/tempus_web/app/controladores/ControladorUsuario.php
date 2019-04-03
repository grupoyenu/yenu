<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorUsuario {
    
    /** @var UsuarioGoogle Usuario con el que se va a trabajar */
    private $usuario;
    
    /**
     * Constructor del controlador.
     */
    function __construct() {
        $this->usuario = new UsuarioGoogle();
    }
    
    public function buscar() {
        return $this->usuario->buscarUsuarios();
    }
    
    public function crear($email, $nombre, $rol) {
        $this->usuario->crear();
    }
    
    public function modificar($idusuario, $email, $nombre, $rol) {
        
    }
    
    /**
     * @param integer $idusuario Identificador del usuario a eliminar.
     */
    public function borrar($idusuario) {
        
    }
        
}

