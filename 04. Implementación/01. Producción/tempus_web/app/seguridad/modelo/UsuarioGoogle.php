<?php

namespace app\seguridad\modelo;

use app\principal\modelo\Conexion;

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
        if ($this->getId() && $this->getGoogleid() && $this->imagen) {
            $idUsurio = $this->getId();
            $consulta = "INSERT INTO usuario_google VALUES ($idUsurio, '{$this->googleid}', '{$this->imagen}')";
            return Conexion::getInstancia()->insertar($consulta);
        }
        return array(0, "No se recibieron todos los campos obligatorios");
    }

    public function login() {
        $login = parent::login();
        if ($login[0] == 2) {
            $consulta = "SELECT * FROM usuario_google WHERE usuario_id = {$this->getId()}";
            $resultado = Conexion::getInstancia()->obtener($consulta);
            if (gettype($resultado[0]) == "array") {
                $fila = $resultado[0];
                $this->googleid = $fila['googleid'];
                $this->imagen = $fila['imagen'];
                return array(2, "Se obtuvo la informacion del usuario correctamente");
            }
            return array(2, "No se obtuvo la información del usuario google");
        }
        return $login;
    }

}
