<?php
require("logica.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$error = "";
	if (isset($_POST['ci']) && isset($_POST['pass']) && isset($_POST['pass2']) && isset($_POST['nombre_completo'])) {
		$ci = fix_input($_POST['ci']);
		$pass = fix_input($_POST['pass']);
		$pass2 = fix_input($_POST['pass2']);
		$nombre_completo = fix_input($_POST['nombre_completo']);
		$okay = true;
		if (!preg_match("/^[1-9][0-9]*$/", $ci)) {
			$error = "La cédula solo puede contener números y no puede empezar con un 0.";
			$okay = false;
		} else if (strlen($ci) != 8) {
			$error = "La cédula debe estrictamente contener 8 números.";
			$okay = false;
		} else if ($pass != $pass2) {
			$error = "Las contraseñas no coinciden.";
			$okay = false;
		} else if (!preg_match("/^[a-zA-Z\s]+$/", $nombre_completo)) {
			$error = "El nombre solo puede contener letras y espacios en blanco.";
			$okay = false;
		}
		if ($okay) alta_cliente($ci, $pass, $nombre_completo);
	} else {
		$error = "Hay campos vacíos.";
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<?php include("header.php") ?>
	<title>Alta cliente</title>
</head>

<body>
	<h3>Alta cliente</h3>
		<?php
		if (isset($error) && $error != "") {
			echo ("<p>ERROR: " . $error . "</p>");
		}
		?>
		<form action=<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?> method="post">
			<label for="ci">Cédula:</label>
			<input type="text" name="ci" required /><br /><br />
			<label for="pass">Contraseña:</label>
			<input type="password" name="pass" required /><br /><br />
			<label for="pass2">Verificar contraseña:</label>
			<input type="password" name="pass2" required /><br /><br />
			<label for="nombre_completo">Nombre completo:</label>
			<input type="text" name="nombre_completo" required /><br /><br />
			<input type="submit" name="submit" value="Enviar" />
		</form>
		<?php include("footer.php") ?>
</body>

</html>