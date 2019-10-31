/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    $('#formCrearRol').submit(function (evento) {
        evento.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./app/usuarios/vistas/ProcesarCrearRol.php",
            data: $("#formCrearRol").serialize(),
            success: function (data) {
                $('#seccionResultado').html(data[0]['resultado']);
                $("#formCrearRol").reset();
            },
            error: function (data) {
                console.log(data);
                $('#seccionResultado').html('<div class="alert alert-danger text-center" role="alert"><strong>No se procesó la petición</strong></div>');
            }
        });
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
