<?php session_start() ?>
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
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">   
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<title>TecnoStore - Alta cliente</title>
</head>

<body><nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<a class="navbar-brand" href="#">TecnoStore</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<?php include("header.php") ?>
		</div>
	</nav>
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
</body>

</html>