<!DOCTYPE html>
<html>

<head>	
	<?php include("header.php") ?>
	<title>Lista Ítems</title>
</head>

<body>
	<h3>Lista Ítems</h3>
	<?php require(__DIR__ . "/../src/logica.php") ?>
	<?php listar_items() ?>
	<?php include("footer.php") ?>
</body>

</html>