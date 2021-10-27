<!DOCTYPE html>
<html>

<head>
	<?php include("header.php") ?>
	<title>Alta Cliente</title>
</head>

<body>
	<h3>Alta Cliente</h1>
	<form action=<?php echo __DIR__ . "opciones.php"?> method="post">
		<input type="hidden" name="opcion" value="alta_cliente" />
		<label for="ci">Cédula:</label>
		<input type="text" name="ci" required/><br />
		<label for="pass">Contraseña:</label>
		<input type="password" name="pass" required/><br />
		<label for="pass2">Verificar contraseña:</label>
		<input type="password" name="pass2" required/><br />
		<label for="nombre_completo">Nombre completo:</label>
		<input type="text" name="nombre_completo" required /><br />
		<input type="submit" value="Enviar" />
	</form>
	<?php include("footer.php") ?>
</body>

</html>