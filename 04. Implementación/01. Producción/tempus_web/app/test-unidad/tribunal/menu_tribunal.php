<?php
if(!isset($_POST['opcion'])) {
    echo '
    <html lang="es">
        <meta charset="UTF-8">
        <body style="background-color: #e2e3e5">
            <h3>MENU DE OPCIONES PARA LA CLASE TRIBUNAL</h3>
            <form method="POST">
                <label>Metodo a probar:</label>
                <select name="opcion">
                    <option value="tribunal_construct.php">CONSTRUCT</option>
                    <option value="tribunal_constructor.php">CONSTRUCTOR</option>
                    <option value="tribunal_buscar.php">BUSCAR TRIBUNAL</option>
                    <option value="tribunal_crear.php">CREAR</option>
                </select>
                <input type="submit" value="PROBAR METODO">
            </form>
        </body>
    </html>';
}else {
    $opcion = $_POST['opcion'];
    header("Location: $opcion");
}