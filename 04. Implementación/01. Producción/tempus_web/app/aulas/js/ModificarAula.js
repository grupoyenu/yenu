/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    var formOriginal = $("#formModificarAula").serialize();

    /* DETECTA LOS CAMBIOS EN LOS CAMPOS DEL FORMULARIO PARA ACTIVAR/DESACTIVAR EL BOTON DE GUARDADO */

    $("#formModificarAula").change(function () {
        comparaFormularios();
    });

    /* ENVIA EL FORMULARIO PARA REALIZAR LA MODIFICACION */

    $('#formModificarAula').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./app/aulas/vistas/ProcesarModificarAula.php",
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
                $("#seccionResultado").html('<div class="alert alert-danger text-center" role="alert"><strong>No se procesó la petición</strong></div>');
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

    /* COMPARA EL FORMULARIO ORIGINAL CON EL MODIFICADO PARA VER QUE NO SEAN IGUALES */

    function comparaFormularios() {
        var formModificado = $("#formModificarAula").serialize();
        var valor = (formOriginal !== formModificado) ? false : true;
        $("#btnModificarAula").prop("disabled", valor);

    }
});

