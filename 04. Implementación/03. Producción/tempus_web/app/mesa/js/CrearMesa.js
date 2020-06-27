/** 
 * Controla los eventos del archivo FormCrearMesa.php y realiza las validaciones
 * correspondientes antes que el formulario se envie al servidor. Se comunica a
 * traves de AJAX con el archivo procesaCrearMesa.php. Como resultado de la 
 * operacion recibe un arreglo JSON con un booleano y mensaje. 
 * 
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
$(document).ready(function () {

    /* Captura el formulario antes de su envio y realiza solicitud AJAX */

    $('#formCrearMesa').submit(function (evento) {
        evento.preventDefault();
        if (verificarTribunal()) {

            var fechaPrimerLlamado = $("input#fecha1").val();
            var fechaSegundoLlamado = $("input#fecha2").val();

            if (fechaPrimerLlamado || fechaSegundoLlamado) {
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: "./ProcesarCrearMesa.php",
                    data: $("#formCrearMesa").serialize(),
                    success: function (data) {
                        $('#seccionResultado').html(data[0]['resultado']);
                        if (data[0]['exito'] === true) {
                            $("select#plan").val('').trigger('change');
                            $("select#presidente").val('').trigger('change');
                            $("select#vocal1").val('').trigger('change');
                            $("select#vocal2").val('').trigger('change');
                            $("select#suplente").val('').trigger('change');
                            $("select#aula1").val('').trigger('change');
                            $("select#aula2").val('').trigger('change');
                            $("#formCrearMesa")[0].reset();
                        }
                        $('html, body').animate({scrollTop: 0}, 1250);
                    },
                    error: function (data) {
                        console.log(data);
                        var men = "<i class='fas fa-exclamation-triangle'></i> <strong>No se procesó la petición</strong>";
                        var div = "<div class='alert alert-danger text-center' role='alert'>" + men + "</div>";
                        $('#seccionResultado').html(div);
                        $('html, body').animate({scrollTop: 0}, 1250);
                    }
                });
            } else {
                var men = "<i class='fas fa-exclamation-circle'></i><strong> Complete los datos del llamado para crear mesa de examen</strong>";
                var div = "<div class='alert alert-warning text-center' role='alert'>" + men + "</div>";
                $('#seccionResultado').html(div);
                $('html, body').animate({scrollTop: 0}, 1250);
            }
        } else {
            var men = "<i class='fas fa-exclamation-circle'></i><strong>Se detectaron docentes duplicados</strong>";
            var div = "<div class='alert alert-warning text-center' role='alert'>" + men + "</div>";
            $('#seccionResultado').html(div);
            $('html, body').animate({scrollTop: 0}, 1250);
        }
    });

    $("input#fecha1").change(function () {
        var fecha = $("input#fecha1").val();
        var valor = (fecha) ? "TRUE" : "FALSE";
        $("#hayPrimerLlamado").val(valor);
    });

    $("input#fecha2").change(function () {
        var fecha = $("input#fecha2").val();
        var valor = (fecha) ? "TRUE" : "FALSE";
        $("#haySegundoLlamado").val(valor);
    });

    $('select#plan').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        minimumInputLength: 1,
        maximumSelectionLength: 30,
        language: "es",
        allowClear: true,
        width: '100%',
        ajax: {
            url: "../../plan/vista/ProcesarSeleccionarPlanSinMesa.php",
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

    $('select#presidente').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        maximumSelectionLength: 30,
        language: "es",
        allowClear: true,
        width: '100%',
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
        maximumSelectionLength: 30,
        language: "es",
        allowClear: true,
        width: '100%',
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
        maximumSelectionLength: 30,
        language: "es",
        allowClear: true,
        width: '100%',
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
        maximumSelectionLength: 30,
        language: "es",
        allowClear: true,
        width: '100%',
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
        maximumSelectionLength: 30,
        language: "es",
        allowClear: true,
        width: '100%',
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

    $('select#aula2').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        maximumSelectionLength: 30,
        language: "es",
        allowClear: true,
        width: '100%',
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


