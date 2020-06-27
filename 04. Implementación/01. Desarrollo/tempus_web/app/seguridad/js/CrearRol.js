/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    $('#formCrearRol').submit(function (evento) {
        evento.preventDefault();
        var cantidad = $('input[name="permisos[]"]:checked').length;
        if (cantidad > 0) {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "./ProcesarCrearRol.php",
                data: $("#formCrearRol").serialize(),
                success: function (data) {
                    $('#seccionResultado').html(data[0]['resultado']);
                    if (data[0]['exito'] === true) {
                        $("#formCrearRol")[0].reset();
                    }
                    $('html, body').animate({scrollTop: 0}, 1250);
                },
                error: function (data) {
                    console.log(data);
                    var mensaje = "<strong>No se procesó la petición</strong>";
                    var div = '<div class="alert alert-danger text-center" role="alert"> ' + mensaje + '</div>';
                    $('#seccionResultado').html(div);
                    $('html, body').animate({scrollTop: 0}, 1250);
                }
            });
        } else {
            var men = "<i class='fas fa-exclamation-circle'><strong>Debe seleccionar al menos un permiso</strong></i>";
            var div = '<div class="alert alert-warning text-center" role="alert"> ' + men + '</div>';
            $('#seccionResultado').html(div);
            $('html, body').animate({scrollTop: 0}, 1250);
        }
    });

    /* Agrega un borde cuando el nombre de permiso esta vacio */

    $('#nombre').change(function () {
        var valor = ($(this).val().length < 5) ? "1px solid red" : "";
        $(this).css("border", valor);
    });

    /* Marca o desmarca todos los permisos de la tabla */

    $('#cbTodosPermisos').change(function () {
        if ($(this).is(':checked')) {
            $("input[name='permisos[]']").each(function () {
                $(this).prop('checked', true);
            });
        } else {
            $("input[name='permisos[]']").each(function () {
                $(this).prop('checked', false);
            });
        }
    });


});
