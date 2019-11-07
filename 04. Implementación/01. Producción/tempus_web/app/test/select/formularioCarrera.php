<script src="../../../lib/js/jquery-3.3.1/jquery-3.3.1.min.js"></script>
<script src="../../../lib/js/select2/select2.min.js"></script>

<link href="../../../lib/js/select2/select2.min.css" rel="stylesheet">
<script>
    $(document).ready(function () {

        $("#selector2").select2({
            placeholder: 'Select an option',
            minimumInputLength: 3,
            ajax: {
                url: 'procesarSeleccionarCarrera.php',
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

        $("#selector2").change(function () {
            var codigo = $("#selector2 option:selected").val();
            if (codigo !== "NO") {
                $("#asignatura").select2({
                    placeholder: 'Select an option',
                    minimumInputLength: 3,
                    ajax: {
                        url: 'procesarSeleccionarAsignatura.php',
                        dataType: 'json',
                        type: "POST",
                        delay: 250,
                        data: function (params) {
                            return {
                                nombre: params.term,
                                codigo: codigo
                            };
                        },
                        processResults: function (data) {
                            return {results: data};
                        },
                        cache: true
                    }
                });
            }
        });

    });

</script>

<form method="post">
    <select id="selector2" name="selector2">
        <option>ESCRIBA UNA OPCION</option>
    </select>
    <br>
    <select id="asignatura" name="asignatura">
        <option>ESCRIBA UNA OPCION</option>
    </select>
</form>