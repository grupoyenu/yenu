<?php

namespace app\principal\controlador;

class ControladorHTML {

    public static function mostrarAlertaResultadoBusqueda($resultado, $mensaje) {
        if ($resultado == 1) {
            return "<div class='alert alert-warning text-center' role='alert'>
                        <i class='fas fa-exclamation-circle'></i> <strong>{$mensaje}</strong>
                    </div>";
        }
        return "<div class='alert alert-danger text-center' role='alert'> 
                        <i class='fas fa-exclamation-triangle'></i> <strong>{$mensaje}</strong>
                    </div>";
    }

    /**
     * Genera un DIV de tipo ALERT conteniendo el mensaje que se indique. Para un
     * resultado cero se muestra un DANGER, para un resultado uno se muestra un
     * WARNING y para un resultado dos se genera un SUCCESS.
     * @param int $resultado Resultado de 0 a 2.
     * @param string $mensaje Mensaje a agregar a la alerta.
     */
    public static function mostrarAlertaResultadoOperacion($resultado, $mensaje) {
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

    public static function mostrarCard($titulo, $contenido) {
        $html = "<div class='card border-dark'>
                    <div class='card-header bg-dark text-white'>{$titulo}</div>
                    <div class='card-body'>{$contenido}</div>
                 </div>";
        return $html;
    }

    public static function mostrarCardResultadoBusqueda($titulo, $contenido) {
        date_default_timezone_set('America/Argentina/Ushuaia');
        $date = date("d/m/Y H:i:s");
        $html = "<div class='card border-dark'>
                    <div class='card-header bg-dark text-white'><i class='fas fa-table'></i> {$titulo}</div>
                    <div class='card-body'>{$contenido}</div>
                    <div class='card-footer bg-dark text-white'>
                        <div class='row'><div class='col text-right'>{$date}</div></div>
                    </div>
                 </div>";
        return $html;
    }

}
