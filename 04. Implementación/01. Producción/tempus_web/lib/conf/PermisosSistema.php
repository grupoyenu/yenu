<?php
/**
 * Clase de constantes del sistema de Roles y Permisos. Esta clase contiene
 * los roles que estan cargados en la base de datos del sistema y los permisos
 * a los que se pueden acceder.
 *
 * @author Eder dos Santos <esantos@uarg.unpa.edu.ar>
 */
class PermisosSistema {
    
    const PERMISO_AUTH = "Auth";
    
    const PERMISO_SALIR = "Salir";
    const PERMISO_LOGIN = "Ingresar";
    const PERMISO_CONSULTAR = "Consultar";
    
   
    
    const PERMISO_CURSADAS = "Cursadas";
    
    const PERMISO_USUARIOS = "Usuarios";
    
    
    /** @var string Administrador del Sistema. */
    const ROL_ADMIN = "Administrador";
    
    /** @var string Secretaría Académica. */
    const ROL_SECRETARIA = "Secretaria";   
    
    /** Usuario no registrado */
    const ROL_INVITADO = "Invitado";
    
}