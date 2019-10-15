<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorHTML {

    static function mostrarAlertaResultadoBusqueda($resultado, $mensaje) {
        if ($resultado == 1) {
            $html = "<div class='alert alert-warning text-center' role='alert'>
                        <i class='fas fa-exclamation-circle'></i> <strong>{$mensaje}</strong>
                    </div>";
        } else {
            $html = "<div class='alert alert-danger text-center' role='alert'> 
                        <i class='fas fa-exclamation-triangle'></i> <strong>{$mensaje}</strong>
                    </div>";
        }
        return $html;
    }

    static function mostrarAlertaResultadoOperacion($resultado, $mensaje) {
        switch ($resultado) {
            case 2:
                $icono = "<i class='far fa-check-circle'></i>";
                $clase = 'class="alert alert-success text-center"';
                break;
            case 1:
                $icono = "<i class='fas fa-exclamation-circle'></i>";
                $clase = 'class="alert alert-warning text-center"';
                break;
            case 0:
                $icono = "<i class='fas fa-exclamation-triangle'></i>";
                $clase = 'class="alert alert-danger text-center"';
                break;
        }
        return "<div {$clase} role='alert'>{$icono} <strong>{$mensaje}</strong></div>";
    }

    static function mostrarCardResultadoBusqueda($titulo, $contenido) {
        $html = "<div class='card'>
                    <div class='card-header'><i class='fas fa-table'></i> {$titulo}</div>
                    <div class='card-body'>{$contenido}</div>
                 </div>";
        return $html;
    }

}
