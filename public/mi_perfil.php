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
	<?php include("header.php") ?>
	<title>Mi Perfil</title>
</head>

<body>
<h3>Mi perfil</h3>
<?php
	if (isset($error) && $error != "") {
		echo ("<p>ERROR: " . $error . "</p>");
	}
	?>
	<?php mostrar_cliente($_SESSION['logged']) ?>

	<?php include("footer.php") ?>
</body>

</html>