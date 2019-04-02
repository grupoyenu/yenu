<?php
if(!isset($_POST['opcion'])) {
    echo '
    <html lang="es">
        <meta charset="UTF-8">
        <body style="background-color: #e2e3e5">
            <h3>MENU DE OPCIONES PARA LA CLASE DOCENTE</h3>
            <form method="POST">
                <label>Metodo a probar:</label>
                <select name="opcion">
                    <option value="docente_construct.php">CONSTRUCT</option>
                    <option value="docente_constructor.php">CONSTRUCTOR</option>
                    <option value="docente_buscar.php">BUSCAR DOCENTE</option>
                    <option value="docente_buscarDocentes.php">BUSCAR DOCENTES</option>
                    <option value="docente_crear.php">CREAR</option>
                </select>
                <input type="submit" value="PROBAR METODO">
            </form>
        </body>
    </html>';
}else {
    $opcion = $_POST['opcion'];
    header("Location: $opcion");
}