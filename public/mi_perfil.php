<?php session_start() ?>
<!DOCTYPE html>
<html>

<head>
	<?php include("header.php") ?>
	<title>Mi Perfil</title>
</head>

<body>
<h3>Mi perfil</h3>
<?php
	require("logica.php");
	if (isset($error) && $error != "") {
		echo ("<p>ERROR: " . $error . "</p>");
	}
	?>
	<?php mostrar_cliente($_SESSION['logged']) ?>

	<?php include("footer.php") ?>
</body>

</html>