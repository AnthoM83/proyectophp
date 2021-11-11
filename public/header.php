<h1>Desarrollo de Sitios Web con PHP - Tecnólogo Informático</h1>
<hr />
<form action=<?php echo htmlspecialchars(__DIR__ . "login_logout.php") ?> method="post">
	<input type="hidden" name="opcion" value="login" />
	<label for="ci">Cédula:</label>
	<input type="text" name="ci" required /><br /><br />
	<label for="pass">Contraseña:</label>
	<input type="password" name="pass" required /><br /><br />
	<input type="submit" value="Iniciar sesión" />
</form>
<br /><a href="index.php">Volver al inicio</a>
<hr />