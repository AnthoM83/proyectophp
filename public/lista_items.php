<?php session_start() ?>
<?php
require("logica.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$error = "";
	if (isset($_POST['submit_carrito'])) {
		$okay = true;
		$cantidad = $_POST['cantidad'];
		if ($cantidad <= 0) {
			$error = "La cantidad no puede ser menor a 0.";
			$okay = false;
		}
		if ($okay) {
			$_SESSION['carrito'][$_POST['codigo']] = $_POST['cantidad'];
			header("Location: exito.php");
		}

	} else if (isset($_POST['submit_baja'])) {
		baja_item($_POST['codigo']);
	} else	if (isset($_POST['submit_modif'])) {
		if (isset($_POST['nombre']) && isset($_POST['precio']) && isset($_POST['stock'])) {
			$nombre = fix_input($_POST['nombre']);
			$precio = $_POST['precio'];
			$stock = $_POST['stock'];
			$okay = true;
			if (!preg_match("/^[0-9a-zA-Z\s]+$/", $nombre)) {
				$error = "El nombre solo puede contener letras, números y espacios en blanco.";
				$okay = false;
			} else if ($precio <= 0) {
				$error = "El precio no puede ser menor o igual a 0.";
				$okay = false;
			} else if ($stock < 0) {
				$error = "El stock no puede ser menor a 0.";
				$okay = false;
			}
			if ($okay) modificar_item($_POST['codigo'], $nombre, $precio, $stock);
		} else {
			$error = "Hay campos vacíos.";
		}
	} else if (isset($_POST['submit_foto'])) {
		agregar_foto($_POST['codigo']);
	}
}
?>

<!DOCTYPE html>
<html>

<head>	
	<?php include("header.php") ?>
	<title>Lista ítems</title>
</head>

<body>
	<h3>Lista ítems</h3>
	<?php
		if (isset($error) && $error != "") {
			echo ("<p>ERROR: " . $error . "</p>");
		}
		?>
	<?php listar_items() ?>
	<?php include("footer.php") ?>
</body>

</html>