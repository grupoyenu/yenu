<?php

header("Content-Type: text/html;charset=iso-8859-1");
include_once '../../modelos/Conexion.php';
include_once '../../modelos/Utilidades.php';
include_once '../../modelos/Usuario.php';
include_once '../../modelos/Rol.php';

echo "
<html lang='es'>
    <body style='background-color: #e2e3e5'>
    <h3>CLASE USUARIO.PHP</h3>
    <table border='1'>
        <thead>
            <tr>
                <th>METODO</th>
                <th>PARAMETROS</th>
                <th>DESCRIPCION</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Crear</td>
                <td>Email:string, Nombre:string, Metodo:string, Rol:rol</td>
                <td>Crea el usuario y la relacion usuario-rol en la BD</td>
            </tr>
        </tbody>
    </table><br><br>";

if (!isset($_POST['email']) && !isset($_POST['nombre']) && !isset($_POST['metodo']) && !isset($_POST['idrol'])) {
    echo"
    <form method='post'>
         <table>
            <tr>
                <td><label>Email:</label><td>
                <td><input type='text' name='email'><td>
            </tr>
            <tr>
                <td><label>Nombre:</label><td>
                <td><input type='text' name='nombre'><td>
            </tr>
            <tr>
                <td><label>Metodo:</label><td>
                <td><input type='text' name='metodo'><td>
            </tr>
            <tr>
                <td><label>Identificador de rol:</label><td>
                <td><input type='number' name='idrol'><td>
            </tr>
        </table>
        <input type = 'submit' value = 'CREAR USUARIO'/>
    </form>
    <br><br>
    <table>
        <tr>
            <td><a href='menu_usuario.php'>PROBAR OTRO METODO</a><td>
            <td><a href='../indexTest.php'>PROBAR OTRA CLASE</a><td>
        </tr>
    </table>";
} else {
    $email = $_POST['email'];
    $nombre = $_POST['nombre'];
    $metodo = $_POST['metodo'];
    $idrol = $_POST['idrol'];
    $usuario = new Usuario();
    $rol = new Rol();
    $rol->setIdrol($idrol);
    $usuario->constructor($email, $nombre, $rol, $metodo);
    $creacion = $usuario->crear();

    echo "<h5>RESULTADO OBTENIDO PARA '$email - $nombre - $metodo - $idrol'</h5>";
    if ($creacion > 1) {
        $style = ($creacion == 2) ? "style='color:green;'" : "style='color:orange;'";
        echo "
        <h5 $style> {$usuario->getDescripcion()} </h5>
        <table border='1'>
            <thead>
                <tr>
                    <th>Id Usuario</th>
                    <th>Email</th>
                    <th>Nombre</th>
                    <th>Metodo Login</th>
                    <th>Estado</th>
                    <th>Id Rol</th>
                    <th>Nombre Rol</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{$usuario->getIdusuario()}</td>
                    <td>{$usuario->getEmail()}</td>
                    <td>{$usuario->getNombre()}</td>
                    <td>{$usuario->getMetodo()}</td>
                    <td>{$usuario->getEstado()}</td>
                    <td>{$usuario->getRol()->getIdrol()}</td>
                    <td>{$usuario->getRol()->getNombre()}</td>
                </tr>
            </tbody>
        </table><br>";
    } else {
        echo "<h5 style='color:red;'> {$usuario->getDescripcion()} </h5>";
    }
    echo"<form method='post'>
            <input type = 'submit' value = 'REGRESAR'/>
        </form>";
}
echo "
    </body>
</html>";
