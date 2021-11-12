<h1>Desarrollo de Sitios Web con PHP - Tecnólogo Informático</h1>
<a href="index.php">Volver al inicio</a>
<hr />
<?php 
if(empty($_SESSION['logged'])) {
	echo('<a href="login_admin.php">Iniciar sesión como administrador</a>');
	echo('<br /><a href="login_cliente.php">Iniciar sesión como cliente</a>');
} else if(! empty($_SESSION['logged'])) {
	echo('<a href="logout.php">Cerrar sesión</a>');
}
if ($_SESSION['logged'] != "admin" && !empty($_SESSION['logged'])) {
	echo('<br /><a href="mi_perfil.php">Mi perfil</a>');
	echo('<br /><a href="carrito.php">Mi carrito</a>');
}
?>
<hr />