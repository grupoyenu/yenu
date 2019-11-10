<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

/*
  $email = "marquez.emanuel@hotmail.com";
  $nombre = "Marquez Jose Alberto";
  $estado = "Activo";
  $rol = 1;
  $usuario = new UsuarioGoogle(NULL, $email, $nombre, $estado, $rol);
 */

$email = "sabalero@yahoo.com";
$nombre = "Sebastian Marino";
$estado = "Activo";
$rol = 1;
$clave = "12345";
$usuario = new UsuarioManual(NULL, $email, $nombre, $estado, $rol, $clave);
$creacion = $usuario->crear();
echo $creacion . " " . $usuario->getDescripcion();
