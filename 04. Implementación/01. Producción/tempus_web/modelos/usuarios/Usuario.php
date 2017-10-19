<?php

class Usuario {
/**
 * @var int
 */
    private $idusuario;
    private $email;
    private $nombre;
    private $metodoLogin;
    private $estado;
    private $datos;  
    /** @var Rol[] */
    private $roles = array();

    public function __construct($idusuario_ = null) {
        
        if ($idusuario_) {
            $this->idusuario = $idusuario_;
            $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery(""
                . "SELECT * "
                . "FROM " . Constantes::BD_USERS . ".USUARIO "
                . "WHERE idusuario = " . $this->idusuario);
            foreach ($this->datos->fetch_assoc() as $atributo => $valor) {
                $this->{$atributo} = $valor;
            }
            $this->datos = null;
            
            $this->datos = ObjetoDatos::getInstancia()->ejecutarQuery(""
                . "SELECT ur.idrol, r.nombre "
                . "FROM " . Constantes::BD_USERS . ".USUARIO_ROL ur "
                . "INNER JOIN " . Constantes::BD_USERS . ".ROL r ON (r.idrol=ur.idrol) "
                . "WHERE ur.idusuario = " . $this->idusuario);
            
            for ($x = 0; $x < $this->datos->num_rows; $x++) {
                $this->addRol($this->datos->fetch_object("WorkflowRol"));
            }
        }
    }
    
    /**
     *
     * @param Int $idRol_
     * @return boolean
     */
    function poseeRol($idRol_) {
        foreach ($this->roles as $Rol)
            if ($idRol_ == $Rol->getIdRol())
                return true;
                return false;
    }
    
}

