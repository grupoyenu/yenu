/* 
 * Este archivo JavaScript se encarga de controlar los eventos de FormModificarMesa.php
 * y de realizar las validaciones correspondientes antes que el formulario sea 
 * enviado al servidor. Se comunica con procesaModificarMesa.php a traves de
 * AJAX. La 
 * 
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
$(document).ready(function () {
    
    /* Se obtienen los valores originales del formulario */
    
    var codigo = $("#codigoCarrera").val();
    var idasignatura = $("#idAsignatura").val();
    var idpresidente = $("#idPresidente").val();
    var idvocal1 = $("#idVocal1").val();
    var idvocal2 = $("#idVocal2").val();
    var idsuplente = $("idSuplente").val();
    
    /* Se captura el formulario al momento de su envio */
    
    $("#formModificarMesa").submit(function(event){
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./app/vistas/procesaModificarMesa.php",
            data: $("#formModificarMesa").serialize(),
            success: function (data) {
                if (data[0]['exito'] === true) {
                    $('#resultado').html(data[0]['div']);
                    $('#contenido').empty();
                } else {
                    $('#resultado').html(data[0]['div']);
                }
            },
            error: function () {
                var mensaje = 'No se pudo realizar la consulta de permisos';
                var div = '<div class="alert alert-danger text-center" role="alert">'+mensaje+'</div>';
                $("#resultado").html(div);
            }
        });
    });
});

