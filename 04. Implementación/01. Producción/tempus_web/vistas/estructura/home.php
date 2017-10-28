<?php

    include_once '../../modelos/usuarios/Usuario.php';
    include_once '../../modelos/usuarios/UsuarioGoogle.php';
    session_start();
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
					
				</fieldset>
			</div>
		</article>
	</section>
	<?php include_once 'pie.php'; ?>
</html>
