<!DOCTYPE html>
<html>

<head>
	<?php include("header.php") ?>
	<title>Proyecto PHP</title>
</head>

<body>
	<a href="alta_cliente.php">Alta Cliente</a><br />
	<a href="lista_clientes.php">Lista Clientes</a><br />
	<a href="alta_item.php">Alta Ítem</a><br />
	<a href="lista_items.php">Lista Ítems</a><br /> <!-- si está logeado como admin, puede borrar/modificar items, si es cliente puede comprar -->
	<!-- Faltaría MiPerfil cuando está logeado, el carrito de compras -->
	<?php include("footer.php") ?>
</body>

</html>