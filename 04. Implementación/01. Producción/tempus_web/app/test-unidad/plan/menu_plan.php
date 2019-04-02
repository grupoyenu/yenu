<?php
if(!isset($_POST['opcion'])) {
    echo '
    <html lang="es">
        <meta charset="UTF-8">
        <body style="background-color: #e2e3e5">
            <h3>MENU DE OPCIONES PARA LA CLASE PLAN</h3>
            <form method="POST">
                <label>Metodo a probar:</label>
                <select name="opcion">
                    <option value="plan_construct.php">CONSTRUCT</option>
                    <option value="plan_constructor.php">CONSTRUCTOR</option>
                    <option value="plan_buscarPlanes.php">BUSCAR PLANES</option>
                    <option value="plan_buscarPorIdentificador.php">BUSCAR POR IDENTIFICADOR</option>
                    <option value="plan_crear.php">CREAR</option>
                    <option value="plan_modificar.php">MODIFICAR</option>
                </select>
                <input type="submit" value="PROBAR METODO">
            </form>
        </body>
    </html>';
}else {
    $opcion = $_POST['opcion'];
    header("Location: $opcion");
}