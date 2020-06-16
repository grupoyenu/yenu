/** 
 * 
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
$(document).ready(function () {

    var formOriginal = $("#formModificarAula").serialize();

    /* DETECTA LOS CAMBIOS EN LOS CAMPOS DEL FORMULARIO PARA ACTIVAR/DESACTIVAR EL BOTON DE GUARDADO */

    $("#formModificarAula").change(function () {
        var formModificado = $("#formModificarAula").serialize();
        var valor = (formOriginal !== formModificado) ? false : true;
        $("#btnModificarAula").prop("disabled", valor);
    });

    /* ENVIA EL FORMULARIO PARA REALIZAR LA MODIFICACION */

    $('#formModificarAula').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./ProcesarModificarAula.php",
            data: $("#formModificarAula").serialize(),
            success: function (data) {
                $('#seccionResultado').html(data[0]['resultado']);
                if (data[0]['exito'] === true) {
                    $("#sector").prop("readonly", true);
                    $("#nombre").prop("readonly", true);
                    $("#btnModificarAula").prop("disabled", true);
                }
            },
            error: function (data) {
                console.log(data);
                var men = "<i class='fas fa-exclamation-triangle'><strong>No se procesó la petición</strong></i>";
                var div = "<div class='alert alert-danger text-center' role='alert'>" + men + "</div>";
                $("#seccionResultado").html(div);
            }
        });
    });

    /* AGREGA UN BORDE CUANDO EL SECTOR DEL AULA ESTA VACIO */

    $('#sector').change(function () {
        var valor = ($(this).val().length === 0) ? "1px solid red" : "";
        $(this).css("border", valor);
    });

    /* AGREGA UN BORDE CUANDO EL NOMBRE DEL AULA ESTA VACIO */

    $('#nombre').change(function () {
        var valor = ($(this).val().length === 0) ? "1px solid red" : "";
        $(this).css("border", valor);
    });

});

