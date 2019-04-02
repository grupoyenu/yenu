/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    /* Se obtienen los datos originales del formulario */

    var sector = $("#sector").val();
    var nombre = $("#nombre").val();

    /* Se captura el formulario antes que sea enviado */

    $("#formModificarAula").submit(function (event) {
        event.preventDefault();
        if (validar()) {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "./app/vistas/procesaModificarAula.php",
                data: $("#formModificarAula").serialize(),
                success: function (data) {
                    if (data[0]['exito'] === true) {
                        $('#resultado').html(data[0]['div']);
                        $('#contenido').empty();
                    } else {
                        $('#resultado').html(data[0]['div']);
                    }
                },
                error: function (data) {
                    console.log(data);
                    imprimirAlerta('No se pudo realizar la modificación del aula');
                }
            });
        } else {
            imprimirAlerta("No se detectaron cambios para el aula");
        }
    });
    
    /* Agrega un borde cuando el sector de aula esta vacio */
    
    $('#sector').change(function () {
        var valor = ($(this).val().length === 0) ? "1px solid red" : "";
        $(this).css("border", valor);
    });

    /* Agrega un borde cuando el nombre de aula esta vacio */
    
    $('#nombre').change(function () {
        var valor = ($(this).val().length === 0) ? "1px solid red" : "";
        $(this).css("border", valor);
    });

    /* Valida que se haya efectuado algun cambio a los valores originales */
    
    function validar() {
        var cambio = false;
        cambio = (sector !== $("#sector").val()) ? true : cambio;
        cambio = (nombre !== $("#nombre").val()) ? true : cambio;
        return cambio;
    }

    /* Imprime un alerta en el div resultado */
    
    function imprimirAlerta(mensaje) {
        $("#resultado").empty();
        var div = '<div class="alert alert-danger text-center" role="alert">' + mensaje + '</div>';
        $("#resultado").html(div);
    }

});
