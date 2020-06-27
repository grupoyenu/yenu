/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    var formMesaOriginal = $("#formModificarMesa").serialize();

    /* DETECTA LOS CAMBIOS EN LOS CAMPOS DEL FORMULARIO PARA ACTIVAR/DESACTIVAR EL BOTON DE GUARDADO */

    $("#formModificarMesa").change(function () {
        var formModificado = $("#formModificarMesa").serialize();
        var habilitar = false;
        if (formMesaOriginal === formModificado) {
            habilitar = true;
            $("#tribunalModificado").val("NO");
            $("#llamadoUnoModificado").val("NO");
            $("#llamadoDosModificado").val("NO");
        }
        $("#btnModificarMesa").prop("disabled", habilitar);
    });

    $(".tribunal").change(function () {
        $("#tribunalModificado").val("SI");
    });

    $(".llamadoUno").change(function () {
        $("#llamadoUnoModificado").val("SI");
    });

    $(".llamadoDos").change(function () {
        $("#llamadoDosModificado").val("SI");
    });

    /**
     * SE CONFIRMA LA MODIFICACION DEL TRIBUNAL.
     */
    $('#formModificarMesa').submit(function (evento) {
        evento.preventDefault();
        if (verificarTribunal()) {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "./ProcesarModificarMesa.php",
                data: $("#formModificarMesa").serialize(),
                success: function (data) {
                    $('#seccionResultado').html(data[0]['resultado']);
                    if (data[0]['exito'] === true) {
                        $('#formModificarMesa').find('input, textarea, select').prop('disabled', true);
                        $("#btnModificarMesa").prop("disabled", true);
                    }
                    $('html, body').animate({scrollTop: 0}, 1250);
                },
                error: function (data) {
                    console.log(data);
                    var men = "<i class='fas fa-exclamation-triangle'></i> <strong>No se procesó la petición</strong>";
                    var div = "<div class='alert alert-danger text-center' role='alert'>" + men + "</div>";
                    $("#seccionResultado").html(div);
                    $('html, body').animate({scrollTop: 0}, 1250);
                }
            });
        } else {
            var men = "<i class='fas fa-exclamation-circle'></i><strong>Se detectaron docentes duplicados</strong>";
            var div = "<div class='alert alert-warning text-center' role='alert'>" + men + "</div>";
            $('#seccionResultado').html(div);
            $('html, body').animate({scrollTop: 0}, 1250);
        }

    });

    $('select#presidente').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        ajax: {
            url: "../../docente/vista/ProcesarSeleccionarDocente.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {nombre: params.term};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

    $('select#vocal1').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        ajax: {
            url: "../../docente/vista/ProcesarSeleccionarDocente.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {nombre: params.term};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

    $('select#vocal2').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        ajax: {
            url: "../../docente/vista/ProcesarSeleccionarDocente.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {nombre: params.term};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

    $('select#suplente').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        ajax: {
            url: "../../docente/vista/ProcesarSeleccionarDocente.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {nombre: params.term};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

    $('select#aula1').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        ajax: {
            url: "../../aula/vista/ProcesarSeleccionarAula.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {nombre: params.term};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

    /**
     * INICIALIZA EL SELECTOR DEL AULA PARA EL SEGUNDO LLAMADO CON EL PLUGIN SELECT2.
     */
    $('select#aula2').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        ajax: {
            url: "../../aula/vista/ProcesarSeleccionarAula.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {nombre: params.term};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

    $("select#presidente").change(function () {
        var presidente = $(this).val();
        if ((presidente !== null) && (presidente !== "NO")) {
            $("select#vocal1").prop("disabled", false);
        } else {
            $("select#vocal1").val('').trigger('change');
            $("select#vocal1").prop("disabled", true);
        }
    });

    $("select#vocal1").change(function () {
        var vocal1 = $(this).val();
        if ((vocal1 !== null) && (vocal1 !== "NO")) {
            $("select#vocal2").prop("disabled", false);
        } else {
            $("select#vocal2").val('').trigger('change');
            $("select#vocal2").prop("disabled", true);
        }
    });

    $("select#vocal2").change(function () {
        var vocal2 = $(this).val();
        if ((vocal2 !== null) && (vocal2 !== "NO")) {
            $("select#suplente").val('').trigger('change');
            $("select#suplente").prop("disabled", false);
        } else {
            $("select#suplente").prop("disabled", true);
        }
    });

    function verificarTribunal() {
        var presidente = $("select#presidente").val();
        var vocal1 = $("select#vocal1").val();
        var vocal2 = $("select#vocal2").val();
        var suplente = $("select#suplente").val();
        if ((presidente === vocal1) || (presidente === vocal2) || (presidente === suplente)) {
            return false;
        }
        if ((vocal2 !== null) && (vocal1 === vocal2)) {
            return false;
        }
        if ((suplente !== null) && (suplente === vocal2)) {
            return false;
        }
        return true;
    }


});

