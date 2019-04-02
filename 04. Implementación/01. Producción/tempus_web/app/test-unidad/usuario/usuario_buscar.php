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
                <td>Buscar</td>
                <td>Email:string, Metodologin:string</td>
                <td>Busca UN usuario por su nombre en la BD</td>
            </tr>
        </tbody>
    </table><br><br>";
    
if (!isset($_POST['email']) && !isset($_POST['metodo'])) {
    echo"
    <form method='post'>
    
        <table>
            <tr>
                <td><label>Email:</label></td>
                <td><input type='text' name='email'></td>
            </tr>
            <tr>
                <td><label>Metodo Login:</label></td>
                <td><input type='text' name='metodo'></td>
            </tr>
        </table>
        <input type = 'submit' value = 'BUSCAR USUARIO'/>
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
    $metodo = $_POST['metodo'];
    $usuario = new Usuario();
    $usuario->setEmail($email);
    $usuario->setMetodo($metodo);
    $rows = $usuario->buscar();
    
    if (is_null($rows) || empty($rows)) {
        if($usuario->getDescripcion()) {
            print("<h5>USUARIO INVALIDO: {$usuario->getDescripcion()}</h5><br>");
        } else {
            print("<h5>NO SE ENCONTRARON RESULTADOS</h5><br>");
        }
    } else {
        $usuario = $rows[0];
        echo "
        <h5>RESULTADO OBTENIDO PARA: '$email - $metodo'</h5>
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
                    <td>{$usuario['idusuario']}</td>
                    <td>{$usuario['email']}</td>
                    <td>{$usuario['nombre']}</td>
                    <td>{$usuario['metodologin']}</td>
                    <td>{$usuario['estado']}</td>
                    <td>{$usuario['idrol']}</td>
                    <td>{$usuario['rol']}</td>
                </tr>
            </tbody>
        </table>
        <br>";
    }
    echo"<form method='post'>
            <input type = 'submit' value = 'REGRESAR'/>
        </form>";
}
echo "
    </body>
</html>";