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

    public function __construct($id = NULL, $email = NULL, $nombre = NULL, $estado = NULL, $rol = NULL, $googleid = NULL, $imagen = NULL) {
        parent::__construct($id, $email, $nombre, "Google", $estado, $rol);
        $this->setGoogleid($googleid);
        $this->setImagen($imagen);
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
        if ($this->getIdUsuario()) {
            $idUsurio = $this->getIdUsuario();
            $values = "($idUsurio, NULL, NULL)";
            $creacion = Conexion::getInstancia()->insertar("usuario_google", $values);
            $this->descripcion = Conexion::getInstancia()->getDescripcion();
            return $creacion;
        }
        $this->descripcion = "No se recibieron todos los campos obligatorios";
        return 0;
    }

    public function login() {
        $login = parent::login();
        if ($login == 2) {
            $consulta = "SELECT * FROM usuario_google WHERE idusuario = {$this->getIdUsuario()}";
            $fila = Conexion::getInstancia()->obtener($consulta);
            if (gettype($fila) == "array") {
                $this->googleid = $fila['googleid'];
                $this->imagen = $fila['imagen'];
                return 2;
            }
            $this->descripcion = "No se obtuvo la información del usuario google";
            return 1;
        }
        return $login;
    }

}
