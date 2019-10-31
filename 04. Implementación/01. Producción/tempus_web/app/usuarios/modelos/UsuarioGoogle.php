<?php

/**
 * Permite obtener operar con los registros de Usuario Google almacenados en la 
 * base de datos. 
 * Relacion con BD: USUARIO GOOGLE.
 * Campos: idusuario, googleid, imagen.
 *
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
class UsuarioGoogle extends Usuario {

    /** @var string Identificador google */
    private $googleid;

    /** @var string Imagen google */
    private $imagen;

    public function __construct() {
        ;
    }

    public function getGoogleid() {
        return $this->googleid;
    }

    public function getImagen() {
        return $this->imagen;
    }

    public function setGoogleid($googleid) {
        $this->googleid = $googleid;
    }

    public function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    public function crear() {
        if ($this->getIdUsuario() && $this->googleid && $this->imagen) {
            $values = "($this->getIdUsuario(), '$this->googleid', '$this->imagen')";
            $creacion = Conexion::getInstancia()->insertar("usuario_google", $values);
            $this->descripcion = Conexion::getInstancia()->getDescripcion();
            return $creacion;
        }
        return 0;
    }

}
