<?php session_start() ?>
<!DOCTYPE html>
<html>

<head>
	<?php include("header.php") ?>
	<title>Lista clientes</title>
</head>

<body>
	<h3>Lista clientes</h3>
	<?php
	require("logica.php");
	if (isset($error) && $error != "") {
		echo ("<p>ERROR: " . $error . "</p>");
	}
	?>
	<?php listar_clientes() ?>

	<?php include("footer.php") ?>
</body>

</html>