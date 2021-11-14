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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">   
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<title>TecnoStore - Lista ítems</title>
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
	<h3>Lista ítems</h3>
	<?php
		if (isset($error) && $error != "") {
			echo ("<p>ERROR: " . $error . "</p>");
		}
		?>
	<?php listar_items() ?>
</body>

</html>