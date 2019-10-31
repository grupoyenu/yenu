<?php

/**
 * Description of ControladorRoles
 *
 * @author Emanuel
 */
class ControladorRoles {

    private $descripcion;

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function buscar($nombre) {
        $roles = new Roles();
        $resultado = $roles->buscar($nombre);
        $this->descripcion = $roles->getDescripcion();
        return $resultado;
    }

    /**
     * @param string $nombre Nombre para el rol a crear.
     * @param array $permisos Identificadores de los permisos asociados al rol.
     */
    public function crear($nombre, $permisos) {
        if (Conexion::getInstancia()->iniciarTransaccion()) {
            $rol = new Rol(NULL, $nombre, $permisos);
            $creacion = $rol->crear();
            $this->descripcion = $rol->getDescripcion();
            $confirmar = ($creacion == 2) ? TRUE : FALSE;
            Conexion::getInstancia()->finalizarTransaccion($confirmar);
            return $creacion;
        }
        $this->mensaje = "No se pudo inicializar la transacción para operar";
        return 0;
    }

    public function listar() {
        $roles = new Roles();
        $resultado = $roles->listar();
        $this->descripcion = $roles->getDescripcion();
        return $resultado;
    }

    public function listarUltimosCreados() {
        $roles = new Roles();
        $resultado = $roles->listarUltimosCreados();
        $this->descripcion = $roles->getDescripcion();
        return $resultado;
    }

    public function modificar($idRol, $nombre, $permisos) {
        $rol = new Rol($idRol, $nombre, $permisos);
        $modificacion = $rol->modificar();
        $this->descripcion = $rol->getDescripcion();
        return $modificacion;
    }

}
