<?php

namespace app\principal\controlador;

use app\seguridad\modelo\UsuarioGoogle;

class ControladorPrincipal {

    public function ingresarPorGoogle($email, $googleId, $imagen) {
        $usuario = new UsuarioGoogle(NULL, $email, NULL, NULL, NULL);
        $resultado = $usuario->login();
        if ($resultado[0] == 2) {
            $estado = $usuario->getEstado();
            $imagenGoogle = $usuario->getImagen();
            if (!$imagenGoogle) {
                $usuario->setGoogleid($googleId);
                $usuario->setImagen($imagen);
                $usuario->crear();
            }
            if ($estado == 'Activo') {
                $_SESSION['ok'] = true;
                $_SESSION['user'] = serialize($usuario);
                return $resultado;
            }
            return array(1, "El estado del usuario es inactivo");
        }
        return $resultado;
    }

}
