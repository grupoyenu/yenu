/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    var formTribunalOriginal = $("#formModificarTribunal").serialize();
    var formLlamado1Original = $("#formModificarLlamado1").serialize();
    var formLlamado2Original = $("#formModificarLlamado2").serialize();

    /**
     * INICIALIZA EL SELECTOR DEL PRESIDENTE CON EL PLUGIN SELECT2.
     */
    $('select#presidente').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        ajax: {
            url: "./app/docentes/vistas/ProcesarSeleccionarDocente.php",
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
     * INICIALIZA EL SELECTOR DEL VOCAL PRIMERO CON EL PLUGIN SELECT2.
     */
    $('select#vocal1').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        ajax: {
            url: "./app/docentes/vistas/ProcesarSeleccionarDocente.php",
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
     * INICIALIZA EL SELECTOR DEL VOCAL SEGUNDO CON EL PLUGIN SELECT2.
     */
    $('select#vocal2').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        ajax: {
            url: "./app/docentes/vistas/ProcesarSeleccionarDocente.php",
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
     * INICIALIZA EL SELECTOR DEL SUPLENTE CON EL PLUGIN SELECT2.
     */
    $('select#suplente').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        ajax: {
            url: "./app/docentes/vistas/ProcesarSeleccionarDocente.php",
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
     * INICIALIZA EL SELECTOR DEL AULA PARA EL PRIMER LLAMADO CON EL PLUGIN SELECT2.
     */
    $('select#aula1').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        ajax: {
            url: "./app/aulas/vistas/ProcesarSeleccionarAula.php",
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
            url: "./app/aulas/vistas/ProcesarSeleccionarAula.php",
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

    /* DETECTA LOS CAMBIOS EN LOS CAMPOS DEL FORMULARIO PARA ACTIVAR/DESACTIVAR EL BOTON DE GUARDADO */

    $("#formModificarTribunal").change(function () {
        var formModificado = $("#formModificarTribunal").serialize();
        var habilitar = (formTribunalOriginal !== formModificado) ? false : true;
        $("#btnModificarTribunal").prop("disabled", habilitar);
    });


    /* DETECTA LOS CAMBIOS EN LOS CAMPOS DEL FORMULARIO PARA ACTIVAR/DESACTIVAR EL BOTON DE GUARDADO */

    $("#formModificarLlamado1").change(function () {
        var formModificado = $("#formModificarLlamado2").serialize();
        var habilitar = (formLlamado1Original !== formModificado) ? false : true;
        $("#btnModificarLlamado1").prop("disabled", habilitar);
    });


    /* DETECTA LOS CAMBIOS EN LOS CAMPOS DEL FORMULARIO PARA ACTIVAR/DESACTIVAR EL BOTON DE GUARDADO */

    $("#formModificarLlamado2").change(function () {
        var formModificado = $("#formModificarLlamado2").serialize();
        var habilitar = (formLlamado2Original !== formModificado) ? false : true;
        $("#btnModificarLlamado2").prop("disabled", habilitar);
    });

    /**
     * SE CONFIRMA LA MODIFICACION DEL TRIBUNAL.
     */
    $('#formModificarTribunal').submit(function (evento) {
        evento.preventDefault();
        $.ajax({
            type: "POST",
            url: "./app/mesas/vistas/ProcesarModificarTribunal.php",
            data: $("#formModificarTribunal").serialize(),
            success: function (data) {
                $("#presidente").prop("disabled", true);
                $("#vocal1").prop("disabled", true);
                $("#vocal2").prop("disabled", true);
                $("#suplente").prop("disabled", true);
                $("#btnModificarTribunal").prop("disabled", true);
                $('#seccionResultado').html(data);
                $('html, body').animate({scrollTop: 0}, 1250);
            },
            error: function (data) {
                console.log(data);
                $("#seccionResultado").html('<div class="alert alert-danger text-center" role="alert"><strong>No se procesó la petición</strong></div>');
            }
        });
    });

    /**
     * SE CONFIRMA LA MODIFICACION DEL PRIMER LLAMADO.
     */
    $('#formModificarLlamado1').submit(function (evento) {
        evento.preventDefault();
        $.ajax({
            type: "POST",
            url: "./app/mesas/vistas/ProcesarModificarLlamado.php",
            data: $("#formModificarLlamado1").serialize(),
            success: function (data) {
                $("#fecha1").prop("readonly", true);
                $("#hora1").prop("disabled", true);
                $("#aula1").prop("disabled", true);
                $("#btnModificarLlamado1").prop("disabled", true);
                $('#seccionResultado').html(data);
                $('html, body').animate({scrollTop: 0}, 1250);
            },
            error: function (data) {
                console.log(data);
                $("#seccionResultado").html('<div class="alert alert-danger text-center" role="alert"><strong>No se procesó la petición</strong></div>');
            }
        });
    });

    /**
     * SE CONFIRMA LA MODIFICACION DEL SEGUNDO LLAMADO
     */
    $('#formModificarLlamado2').submit(function () {
        $.ajax({
            type: "POST",
            url: "./app/mesas/vistas/ProcesarModificarLlamado.php",
            data: $("#formModificarLlamado2").serialize(),
            success: function (data) {
                $("#fecha2").prop("readonly", true);
                $("#hora2").prop("disabled", true);
                $("#aula2").prop("disabled", true);
                $("#btnModificarLlamado2").prop("disabled", true);
                $('#seccionResultado').html(data);
                $('html, body').animate({scrollTop: 0}, 1250);
            },
            error: function (data) {
                console.log(data);
                $("#seccionResultado").html('<div class="alert alert-danger text-center" role="alert"><strong>No se procesó la petición</strong></div>');
            }
        });
    });

});

