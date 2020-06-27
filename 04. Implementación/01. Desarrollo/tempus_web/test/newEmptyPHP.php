<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$nombre = "Introducción al conocimiento cientifico";
$expresion = "/^[a-záéíóúñü0-9,. ]{5,60}$/";

echo "<br>NOMBRE: " . $nombre;
echo "<br>UTF8-ENCODE: " . utf8_encode($nombre);
echo "<br>UTF8-DECODE: " . utf8_encode($nombre);
echo "<br>LOWER: " . mb_strtolower(utf8_encode($nombre));
echo "<br>PREG_MATCH: " . (int) preg_match($expresion, mb_strtolower(utf8_encode($nombre)));



$cadena = " frase frase frase ";
$cadena_formateada = trim($cadena);
echo "<br>La cadena original es esta: '".$cadena."' y la formateada es esta otra: '".$cadena_formateada."'";
