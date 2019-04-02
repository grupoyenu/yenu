<?php
if(!isset($_POST['opcion'])) {
    echo '
    <html lang="es">
        <meta charset="UTF-8">
        <body style="background-color: #e2e3e5">
            <h3>MENU DE OPCIONES PARA LA CLASE USUARIO</h3>
            <form method="POST">
                <label>Metodo a probar:</label>
                <select name="opcion">
                    <option value="usuario_construct.php">CONSTRUCT</option>
                    <option value="usuario_constructor.php">CONSTRUCTOR</option>
                    <option value="usuario_borrar.php">BORRAR</option>
                    <option value="usuario_buscar.php">BUSCAR</option>
                    <option value="usuario_crear.php">CREAR</option>
                    <option value="usuario_modificar.php">MODIFICAR</option>
                </select>
                <input type="submit" value="PROBAR METODO">
            </form>
        </body>
    </html>';
}else {
    $opcion = $_POST['opcion'];
    header("Location: $opcion");
}