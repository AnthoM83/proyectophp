<h1>Desarrollo de Sitios Web con PHP - Tecnólogo Informático</h1>
<form action=<?php echo __DIR__ . "login_logout.php"?> method="post">
		<input type="hidden" name="opcion" value="login" />
		<label for="ci">Cédula:</label>
		<input type="text" name="ci" required/><br />
		<label for="pass">Contraseña:</label>
		<input type="password" name="pass" required/><br />
		<input type="submit" value="Iniciar sesión" />
</form>
<a href="index.php">Volver al inicio</a>
<hr />