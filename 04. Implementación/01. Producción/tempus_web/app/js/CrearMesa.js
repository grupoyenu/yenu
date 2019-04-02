/** 
 * Controla los eventos del archivo FormCrearMesa.php y realiza las validaciones
 * correspondientes antes que el formulario se envie al servidor. Se comunica a
 * traves de AJAX con el archivo procesaCrearMesa.php. Como resultado de la 
 * operacion recibe un arreglo JSON con un booleano y mensaje. Tambien controla
 * los eventos para el modal de planes, modal de docentes y modal de aulas.
 * 
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
$(document).ready(function () {

    /* Captura el formulario antes de su envio y realiza solicitud AJAX */
    
    $('#formCrearMesa').submit(function () {
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./app/vistas/procesaCrearMesa.php",
            data: $("#formCrearMesa").serialize(),
            success: function (data) {
                if (data[0]['exito'] === true) {
                    $('#resultado').html(data[0]['div']);
                    $('#contenido').empty();
                } else {
                    $('#resultado').html(data[0]['div']);
                }
            },
            error: function () {
                $("#resultado").html('<div class="alert alert-danger text-center" role="alert">Error durante la petición por AJAX</div>');
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
    
    /* Inicializa la tabla del modal docentes con DataTable */
    
    $("table#tablaDocentes").DataTable({
        dom: 'Bfrtip',
        responsive: true,
        language: {url: "./app/js/Spanish.json"}
    });
    
    /* Inicializa la tabla del modal aulas con DataTables */
    
    $("table#tablaAulas").DataTable({
        dom: 'Bfrtip',
        responsive: true,
        language: {url: "./app/js/Spanish.json"}
    });

    /* Abre el modal para la seleccion de carrera y asignatura */

    $('#seleccionarPlan').click(function () {
        $("#modalPlanes").modal();
        return false;
    });
    
    /* Abre el modal para la seleccion de PRESIDENTE */
    
    $('#buscarPresidente').click(function () {
        $("#tipo").val("1");
        $("#modalDocentes").modal();
        return false;
    });

    /* Abre el modal para la seleccion de VOCAL 1 */
    
    $('#buscarVocal1').click(function () {
        $("#tipo").val("2");
        $("#modalDocentes").modal();
        return false;
    });

    /* Abre el modal para la seleccion de VOCAL 2 */

    $('#buscarVocal2').click(function () {
        $("#tipo").val("3");
        $("#modalDocentes").modal();
        return false;
    });
    
    /* Abre el modal para la seleccion de SUPLENTE */

    $('#buscarSuplente').click(function () {
        $("#tipo").val("4");
        $("#modalDocentes").modal();
        return false;
    });
    
    /* Abre el modal para la seleccion de aula */
    
    $('#buscarAula').click(function () {
        $("#modalAulas").modal();
        return false;
    });

    /* Realiza la seleccion de carrera y asignatura */

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
    
    /* Realiza la seleccion de un docente determinado */

    $('#btnElegirDocente').click(function () {
        var tipo = $("#tipo").val();
        var idDocente = $("#radioDocente:checked").val();
        var nombreDocente = $("#nombre" + idDocente).val();
        switch (tipo) {
            case "1":
                $("#idPresidente").val(idDocente);
                $("#nombrePresidente").val(nombreDocente);
                break;
            case "2":
                $("#idVocal1").val(idDocente);
                $("#nombreVocal1").val(nombreDocente);
                break;
            case "3":
                $("#idVocal2").val(idDocente);
                $("#nombreVocal2").val(nombreDocente);
                break;
            case "4":
                $("#idSuplente").val(idDocente);
                $("#nombreSuplente").val(nombreDocente);
                break;
        }
    });
    
    /* Realiza la seleccion del aula */

    $('#btnElegirAula').click(function () {
        var idaula = $("#radioAula:checked").attr('name');
        var sector = $("#sector" + idaula).val();
        var nombre = $("#nombre" + idaula).val();
        $("#nombreSector").val(sector);
        $("#nombreAula").val(nombre);
    });




});

