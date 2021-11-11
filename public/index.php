<!DOCTYPE html>
<html>

<head>
	<?php include("header.php") ?>
	<title>Proyecto PHP</title>
</head>

<body>
	<a href="alta_cliente.php">Alta cliente</a><br /><br />
	<a href="lista_clientes.php">Lista clientes</a><br /><br />
	<a href="alta_item.php">Alta ítem</a><br /><br />
	<a href="lista_items.php">Lista ítems</a><br /> <!-- si está logeado como admin, puede borrar/modificar items, si es cliente puede comprar -->
	<!-- Faltaría MiPerfil cuando está logeado, el carrito de compras -->
	<?php include("footer.php") ?>
</body>

</html>