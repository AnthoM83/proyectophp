<!DOCTYPE html>
<html>

<head>
	<?php include("header.php") ?>
	<title>Alta Ítem</title>
</head>

<body>
	<h3>Alta Ítem</h3>
	<form action=<?php echo __DIR__ . "opciones.php"?> enctype="multipart/form-data" method="post">
		<input type="hidden" name="opcion" value="alta_item" />
		<label for="nombre">Nombre:</label>
		<input type="text" name="nombre" required /><br />
		<label for="precio">Precio:</label>
		<input type="number" step="0.01" min="0" name="precio" /><br />
		<label for="stock_inicial">Stock inicial:</label>
		<input type="number" step="1" min="0" name=stock_inicial /><br />
		<label for="foto">Foto:</label>
    <input type="file" name="foto"/><br />
		<input type="submit" value="Enviar" />
	</form>
	<?php include("footer.php") ?>
</body>

</html>