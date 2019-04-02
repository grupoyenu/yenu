<?php

header("Content-Type: text/html;charset=iso-8859-1");
include_once '../../modelos/Conexion.php';
include_once '../../modelos/Utilidades.php';
include_once '../../modelos/Usuario.php';
include_once '../../modelos/UsuarioGoogle.php';
include_once '../../modelos/Rol.php';

echo "
<html lang='es'>
    <body style='background-color: #e2e3e5'>
    <h3>CLASE USUARIOGOOGLE.PHP</h3>
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
                <td>Buscar</td>
                <td>email:string</td>
                <td>Realiza la busqueda del usuario en la BD</td>
            </tr>
        </tbody>
    </table><br><br>";
    
if (!isset($_POST['email'])) {
    echo"
    <form method='post'>
        <label>Email de usuario google:</label>
        <input type='text' name='email'>
        <input type = 'submit' value = 'BUSCAR USUARIO GOOGLE'/>
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
    $usuario = new UsuarioGoogle();
    $usuario->setEmail($email);
    if ($usuario->buscar()) {
        print ("
        <h5>RESULTADO OBTENIDO PARA: '$email'</h5>
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
                    <th>Google id</th>
                    <th>Imagen</th>
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
                    <td>{$usuario->getGoogleid()}</td>
                    <td>{$usuario->getImagen()}</td>    
                </tr>
            </tbody>
        </table>
        <br>");
    } else {
        echo "<h5>NO SE OBTUVO USUARIO GOOGLE PARA '$email'</h5><br>";
    }
    echo"<form method='post'>
            <input type = 'submit' value = 'REGRESAR'/>
        </form>";
}
echo "
    </body>
</html>";