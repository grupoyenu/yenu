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
                <td>Construct</td>
                <td>Idusuario:int</td>
                <td>Cuando se indica un id se busca la informacion de usuario en la BD</td>
            </tr>
        </tbody>
    </table><br><br>";
    
if (!isset($_POST['idusuario'])) {
    echo"
    <form method='post'>
        <label>Identificador de usuario:</label>
        <input type='number' name='idusuario'>
        <input type = 'submit' value = 'CONSTRUCT'/>
    </form>
    <br><br>
    <table>
        <tr>
            <td><a href='menu_usuario.php'>PROBAR OTRO METODO</a><td>
            <td><a href='../indexTest.php'>PROBAR OTRA CLASE</a><td>
        </tr>
    </table>";
} else {
    $idusuario = $_POST['idusuario'];
    $usuario = new Usuario($idusuario);
    if ($usuario->getValido()) {
        print ("
        <h5>RESULTADO OBTENIDO PARA: '$idusuario'</h5>
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
        </table>
        <br>");
    } else {
        echo "<h5>NO SE OBTUVO USUARIO PARA '$idusuario'</h5><br>";
    }
    echo"<form method='post'>
            <input type = 'submit' value = 'REGRESAR'/>
        </form>";
}
echo "
    </body>
</html>";