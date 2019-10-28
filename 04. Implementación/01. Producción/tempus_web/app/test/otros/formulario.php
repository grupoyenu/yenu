<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$html = '
    <script type="text/javascript" src="../../../lib/js/jquery-3.3.1/jquery-3.3.1.min.js"></script>
    <form name="formulario" id="formulario" method="POST" action="aula_crear">
        <input type="hidden" name="id" id="id">
        <div class="table-responsive">
            <table id="tablaBuscarAulas" class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Sector</th>
                        <th>Nombre</th>
                        <th class="text-center">Operaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>A</td>
                        <td>LAB7</td>
                        <td class="text-center" title="">
                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <button class="btn btn-outline-warning modificarAula" href="aula_crear" title="Crear aula" name="43">MODIFICAR</button>
                                <button class="btn btn-outline-info informeAula" href="aula_grafico" title="Histograma" name="43" >INFORMAR</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>A</td>
                        <td>LAB8</td>
                        <td class="text-center" title="">
                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <button class="btn btn-outline-warning modificarAula" href="aula_crear" title="Crear aula" name="24">MODIFICAR</button>
                                <button class="btn btn-outline-info informeAula" href="aula_grafico" title="Histograma" name="24" >INFORMAR</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>A</td>
                        <td>LAB10</td>
                        <td class="text-center" title="">
                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <button class="btn btn-outline-warning modificarAula" href="aula_crear" title="Crear aula" name="14">MODIFICAR</button>
                                <button class="btn btn-outline-info informeAula" href="aula_grafico" title="Histograma" name="14" >INFORMAR</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </form>';

echo $html;
?>

<script>

    $(document).ready(function () {

        $("button.modificarAula").click(function (e) {
            e.preventDefault();
            var id = $(this).attr("name");
            $("input#id").val(id);
            alert("SE FRENA " + id);
            $("form#formulario").submit();
        });

    });

</script>