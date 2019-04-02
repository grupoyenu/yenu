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

    /**
     * Constructor de la clase.
     */
    function __construct($idusuario = null) {
        $this->setMetodo("Google");
        if ($idusuario) {
            parent::__construct($idusuario);
            if (!$this->valido) {
                return;
            }
            $this->valido = false;
            $consulta = "SELECT * FROM usuario_google WHERE idusuario = " . $idusuario;
            $rows = Conexion::getInstancia()->executeQuery($consulta);
            if (!empty($rows)) {
                $usuario = $rows[0];
                $this->googleid = $usuario['googleid'];
                $this->imagen = $usuario['imagen'];
                $this->valido = true;
            }
        }
    }

    /**
     * Devuelve el google id.
     * @return string Identificador Google.
     */
    public function getGoogleid() {
        return $this->googleid;
    }

    /**
     * Devuelve la imagen del usuario google.
     * @return string Imagen de usuario Google.
     */
    public function getImagen() {
        return $this->imagen;
    }

    /**
     * Modifica el google id del usuario.
     * @param String $googleid
     */
    public function setGoogleid($googleid) {
        $this->googleid = $googleid;
    }

    /**
     * Modifica la imagen del usuario.
     * @param String $imagen
     */
    public function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    /**
     * Realiza la creación de un usuario google en la tabla usuario_google.
     * */
    public function crearUsuarioGoogle() {
        if ($this->completo()) {
            $consulta = "INSERT INTO usuario_google VALUES ($this->getIdusuario(),'$this->googleid','$this->imagen')";
            if (Conexion::getInstancia()->executeUpdate($consulta)) {
                return true;
            }
            return false;
        }
    }

    /**
     * Realiza la búsqueda de un usuario google a traves de su correo electronico.
     * Para ello primero realiza la busqueda del usuario que utiliza el metodo de
     * login Google. 
     * */
    public function buscar() {
        $rows = parent::buscar();
        if (!empty($rows)) {
            $usuario = $rows[0];
            $rol = new Rol();
            $rol->constructor($usuario['rol'], $usuario['idrol']);
            $this->setRol($rol);
            $this->setIdusuario($usuario['idusuario']);
            $this->setNombre($usuario['nombre']);
            $this->setEstado($usuario['estado']);
            $consulta = "SELECT * FROM usuario_google WHERE idusuario = " . $usuario['idusuario'];
            $rowsGoogle = Conexion::getInstancia()->executeQuery($consulta);
            if (!empty($rowsGoogle)) {
                $this->googleid = $rowsGoogle[0]['googleid'];
                $this->imagen = $rowsGoogle[0]['imagen'];
            }
            return true;
        }
        return false;
    }

    public function buscarUsuarios() {
        $consulta = "SELECT u.idusuario, u.nombre, u.email, r.nombre rol
                    FROM usuario u, usuario_google ug, usuario_rol ur, rol r
                    WHERE u.idusuario=ug.idusuario AND ur.idrol=r.idrol AND u.idusuario=ur.idusuario";
        $rows = Conexion::getInstancia()->executeQuery($consulta);
        return $rows;
    }

    private function completo() {
        if ($this->googleid && $this->imagen) {
            return true;
        }
        $this->descripcion = "El usuario no contiene toda la información";
        return false;
    }

}
