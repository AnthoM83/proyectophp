<?php
require("logica.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$error = "";
	if (isset($_POST['nombre']) && isset($_POST['precio']) && isset($_POST['stock_inicial'])) {
		$nombre = fix_input($_POST['nombre']);
		$precio = $_POST['precio'];
		$stock_inicial = $_POST['stock_inicial'];
		$okay = true;
		if (!preg_match("/^[0-9a-zA-Z\s]+$/", $nombre)) {
			$error = "El nombre solo puede contener letras, números y espacios en blanco.";
			$okay = false;
		} else if ($precio <= 0) {
			$error = "El precio no puede ser menor o igual a 0.";
			$okay = false;
		} else if ($stock_inicial < 0) {
			$error = "El stock no puede ser menor a 0.";
			$okay = false;
		}
		if ($okay) alta_item($nombre, $precio, $stock_inicial);
	} else {
		$error = "Hay campos vacíos.";
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<?php include("header.php") ?>
	<title>Alta ítem</title>
</head>

<body>
	<h3>Alta ítem</h3>
	<?php
	if (isset($error) && $error != "") {
		echo ("<p>ERROR: " . $error . "</p>");
	}
	?>
	<form action=<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?> enctype="multipart/form-data" method="post">
		<label for="nombre">Nombre:</label>
		<input type="text" name="nombre" required /><br /><br />
		<label for="precio">Precio:</label>
		<input type="number" step="0.01" min="0.01" name="precio" required /><br /><br />
		<label for="stock_inicial">Stock inicial:</label>
		<input type="number" step="1" min="0" name=stock_inicial required /><br /><br />
		<label for="foto">Foto:</label>
		<input type="file" name="foto" /><br /><br />
		<input type="submit" value="Enviar" />
	</form>
	<?php include("footer.php") ?>
</body>

</html>