<?php

    include_once '../../lib/conf/ControlAcceso.php';
    include_once '../../lib/conf/PermisosSistema.php';
    include_once '../../modelos/usuarios/Usuario.php';
    include_once '../../modelos/usuarios/UsuarioGoogle.php';
    
    ControlAcceso::requierePermiso(PermisosSistema::PERMISO_AUTH);
    
?>

<html>
	<?php include_once 'encabezado.php'; ?>
	<section id="main-content">
		<article>
			<div class="content">
				<h2>¡LE DAMOS LA BIENVENIDA!</h2>
				<fieldset>
					<legend>Perfil de usuario</legend>
					<p> <img  src="<?= $_SESSION['usuario']->getImagen(); ?>"></p>
					<p>Nombre: <?= $_SESSION['usuario']->getNombre(); ?></p>
					<p>E-mail: <?= $_SESSION['usuario']->getEmail(); ?></p>
					
					<?php
    					foreach ($_SESSION['usuario']->getRoles() as $rol) {
    					    echo "<p>Rol: ".$rol->getNombre()."</p>";
                        }
                    ?>
				</fieldset>
			</div>
		</article>
	</section>
	<?php include_once 'pie.php'; ?>
</html>
