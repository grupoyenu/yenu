/** 
 * Controla los eventos del archivo FormCrearCursada.php y realiza las validaciones
 * correspondientes antes que el formulario se envie al servidor. Se comunica a
 * traves de AJAX con el archivo procesaCrearCursada.php. Como resultado de la 
 * operacion recibe un arreglo JSON con un booleano y mensaje. Tambien controla
 * los eventos para el modal de planes y modal de aulas.
 * 
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
$(document).ready(function () {
    
    /* Captura el formulario antes de su envio y realiza solicitud AJAX */
    
    $('#formCrearCursada').submit(function () {
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./app/vistas/procesaCrearCursada.php",
            data: $("#formCrearCursada").serialize(),
            success: function (data) {
                if (data[0]['exito'] === true) {
                    $('#resultado').html(data[0]['div']);
                    $('#contenido').empty();
                } else {
                    $('#resultado').html(data[0]['div']);
                }
            },
            error: function () {
                $("#resultado").html('<div class="alert alert-danger text-center" role="alert"> Error durante la petición por AJAX</div>');
            }
        });
        return false;
    });

    /* Inicializa la tabla del modal planes con DataTable */
    
    $("table#tablaBuscarCarreras").DataTable({
        dom: 'Bfrtip',
        responsive: true,
        language: {url: "./app/js/Spanish.json"}
    });
    
    /* Inicializa la tabla del modal aulas con DataTable */

    $("table#tablaAulas").DataTable({
        dom: 'Bfrtip',
        responsive: true,
        language: {url: "./app/js/Spanish.json"}
    });
    
    /* Abre el modal para selecccionar carrera y asignatura */

    $('#seleccionarPlan').click(function () {
        $("#modalPlanes").modal();
        return false;
    });
    
    /* Realiza la seleccion del plan y actualiza los valores */

    $('#btnElegirPlan').click(function () {
        var codigo = $("#plan:checked").attr('name');
        var idasignatura = $("#plan:checked").val();
        var nombreCarrera = $("#carrera" + codigo).val();
        var nombreAsignatura = $("#asignatura" + idasignatura).val();
        $("#codigoCarrera").val(codigo);
        $("#idAsignatura").val(idasignatura);
        $("#nombreCarrera").val(nombreCarrera);
        $("#nombreAsignatura").val(nombreAsignatura);
    });
    
    /* Habilita o deshabilita la seleccion de horario para cada dia */

    $('input.clases').click(function () {
        var dia = $(this).val();
        if ($(this).is(":checked")) {
            $("#inicio" + dia).prop("disabled", false);
            $("#fin" + dia).prop("disabled", false);
            $("#seleccionarAula" + dia).prop("disabled", false);
        } else {
            $("#inicio" + dia).prop("disabled", true);
            $("#fin" + dia).prop("disabled", true);
            $("#seleccionarAula" + dia).prop("disabled", true);
        }
    });
    
    /* Abre el modal de seleccion de aula para el LUNES */

    $('#seleccionarAula1').click(function () {
        $("#dia").val("1");
        $("#modalAulas").modal();
        return false;
    });
    
    /* Abre el modal de seleccion de aula para el MARTES */

    $('#seleccionarAula2').click(function () {
        $("#dia").val("2");
        $("#modalAulas").modal();
        return false;
    });
    
    /* Abre el modal de seleccion de aula para el MIERCOLES */

    $('#seleccionarAula3').click(function () {
        $("#dia").val("3");
        $("#modalAulas").modal();
        return false;
    });

    /* Abre el modal de seleccion de aula para el JUEVES */

    $('#seleccionarAula4').click(function () {
        $("#dia").val("4");
        $("#modalAulas").modal();
        return false;
    });
    
    /* Abre el modal de seleccion de aula para el VIERNES */

    $('#seleccionarAula5').click(function () {
        $("#dia").val("5");
        $("#modalAulas").modal();
        return false;
    });
    
    /* Abre el modal de seleccion de aula para el SABADO */

    $('#seleccionarAula6').click(function () {
        $("#dia").val("6");
        $("#modalAulas").modal();
        return false;
    });
    
    /* Realiza la seleccion del aula para un determinado dia */

    $('#btnElegirAula').click(function () {
        var dia = $("#dia").val();
        var idAula = $("#radioAula:checked").val();
        var nombreSector = $("#sector" + idAula).val();
        var nombreAula = $("#nombre" + idAula).val();
        $("#idaula" + dia).val(idAula);
        $("#nombreSector" + dia).val(nombreSector);
        $("#nombreAula" + dia).val(nombreAula);
    });


});