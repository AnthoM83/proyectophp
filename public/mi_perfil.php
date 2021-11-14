<?php session_start() ?>
<?php
require("logica.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$error = "";
	$okay = true;
	if (isset($_POST['submit_nombre'])) {
		$ci = $_POST['cedula'];
		$nombre_completo = fix_input($_POST['nombre_completo']);
		if (!preg_match("/^[a-zA-Z\s]+$/", $nombre_completo)) {
			$error = "El nombre solo puede contener letras y espacios en blanco.";
			$okay = false;
		}
		modificar_cliente_nombre($ci, $nombre_completo);
	} else if (isset($_POST['submit_pass'])) {
		if ($_POST['n_pass'] != $_POST['n_pass2']) {
			$error = "La nueva contraseña no coincide con la verificación.";
			$okay = false;
		}
		if ($okay) $error = modificar_cliente_pass($_POST['cedula'], $_POST['n_pass']);
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
	<title>TecnoStore - Mi Perfil</title>
</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<a class="navbar-brand" href="#">TecnoStore</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<?php include("header.php") ?>
		</div>
	</nav>
<h3>Mi perfil</h3>
<?php
	if (isset($error) && $error != "") {
		echo ("<p>ERROR: " . $error . "</p>");
	}
	?>
	<?php mostrar_cliente($_SESSION['logged']) ?>

</body>

</html>