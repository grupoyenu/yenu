<?php
if(!isset($_POST['opcion'])) {
    echo '
    <html lang="es">
        <meta charset="UTF-8">
        <body style="background-color: #e2e3e5">
            <h3>MENU DE OPCIONES PARA LA CLASE ASIGNATURA</h3>
            <form method="POST">
                <label>Metodo a probar:</label>
                <select name="opcion">
                    <option value="asignatura_construct.php">CONSTRUCT</option>
                    <option value="asignatura_constructor.php">CONSTRUCTOR</option>
                    <option value="asignatura_buscar.php">BUSCAR</option>
                    <option value="asignatura_crear.php">CREAR</option>
                </select>
                <input type="submit" value="PROBAR METODO">
            </form>
        </body>
    </html>';
}else {
    $opcion = $_POST['opcion'];
    header("Location: $opcion");
}

