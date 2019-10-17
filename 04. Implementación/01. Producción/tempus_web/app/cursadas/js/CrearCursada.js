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

    $('#formCrearCursada').submit(function (evento) {
        console.log($("#formCrearCursada").serialize());
        evento.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./app/cursadas/vistas/ProcesarCrearCursada.php",
            data: $("#formCrearCursada").serialize(),
            success: function (data) {
                $('#seccionResultado').html(data[0]['resultado']);
                if (data[0]['exito'] === true) {
                    $("#formCrearCursada")[0].reset();
                }
            },
            error: function (data) {
                console.log(data);
                $('#seccionResultado').html("<div class='alert alert-danger text-center' role='alert'><i class='fas fa-exclamation-triangle'></i> <strong>No se procesó la petición</strong></div>");
            }
        });
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

    $('#seleccionarAsignatura').click(function (evento) {
        evento.preventDefault();
        $("#modalSeleccionarAsignatura").modal();
        $.ajax({
            type: "POST",
            url: "./app/asignaturas/vistas/ProcesarSeleccionarAsignaturaSinCursada.php",
            success: function (data) {
                $('#cuerpoModalAsignatura').html(data);
                $('#tablaSeleccionarAsignatura').dataTable();
            },
            error: function (data) {
                console.log(data);
                $('#cuerpoModal').html("ERROR");
            }
        });
    });

    $('.seleccionarAula').click(function (evento) {
        evento.preventDefault();
        var dia = $(this).attr("name");
        var horaInicio = $("select#horaInicio" + dia + " option:selected").text();
        var horaFin = $("select#horaFin" + dia + " option:selected").text();
        $("#modalSeleccionarAula").modal();
        $.ajax({
            type: "POST",
            url: "./app/aulas/vistas/ProcesarSeleccionarAulaDisponible.php",
            data: "dia=" + dia + "&desde=" + horaInicio + "&hasta=" + horaFin,
            success: function (data) {
                $('#cuerpoModalAula').html(data);
                $('#tablaSeleccionarAula').dataTable();
            },
            error: function (data) {
                console.log(data);
                $('#cuerpoModal').html("ERROR");
            }
        });
    });

    $("#cuerpoModalAsignatura").on("click", ".seleccionarAsignatura", function () {
        $("#nombreCarrera").val($(this).parents("tr").find("td").eq(2).html());
        $("#nombreAsignatura").val($(this).parents("tr").find("td").eq(3).html());
        $("#idAsignatura").val($(this).attr("name"));
        $("#idCarrera").val($(this).val());
        $("#modalSeleccionarAsignatura").modal("toggle");
    });

    $("#cuerpoModalAula").on("click", ".elegirAula", function () {
        var dia = $(this).val();
        var sector = $(this).parents("tr").find("td").eq(1).html();
        var nombre = $(this).parents("tr").find("td").eq(2).html();
        $("#idAula" + dia).val($(this).attr("name"));
        $("#aula" + dia).val(sector + " " + nombre);
        $("#modalSeleccionarAula").modal("toggle");
    });

    $(".horaInicio").change(function () {
        var dia = $(this).parents("tr").attr("name");
        $("#aula" + dia).val("");
        alert($(this).attr("name"));
    });

    $(".horaFin").change(function () {
        var dia = $(this).parents("tr").attr("name");
        $("#aula" + dia).val("");
        alert($(this).attr("name"));
    });

});