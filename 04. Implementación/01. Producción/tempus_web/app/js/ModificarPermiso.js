/* 
 * Este archivo JavaScript se encarga de controlar los eventos de FormModificarPermiso.php
 * y de realizar las validaciones correspondientes antes que el formulario sea 
 * enviado al servidor. Se comunica con procesaModificarPermiso.php a traves de
 * AJAX. 
 * 
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
$(document).ready(function () {
    
    /* Se obtienen los valores originales del formulario */
    
    var nombre = $("#nombre").val();

    /* Se captura el formulario al momento de su envio */
    
    $("#formModificarPermiso").submit(function (event) {
        event.preventDefault();
        if (nombre !== $("#nombre").val()) {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "./app/vistas/procesaModificarPermiso.php",
                data: $("#formModificarPermiso").serialize(),
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
                    imprimirAlerta("No se pudo realizar la consulta de permisos");
                }
            });
        } else {
            imprimirAlerta("No se detectaron cambios");
        }
    });
    
    /* Imprime un alerta en el div resultado */
    
    function imprimirAlerta(mensaje) {
        $("#resultado").empty();
        var div = '<div class="alert alert-danger text-center" role="alert">' + mensaje + '</div>';
        $("#resultado").html(div);
    }
    
    /* Agrega un borde cuando el nombre de aula esta vacio */

    $('#nombre').change(function () {
        var valor = ($(this).val().length === 0) ? "1px solid red" : "";
        $(this).css("border", valor);
    });

});