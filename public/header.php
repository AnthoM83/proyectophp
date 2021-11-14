
<?php 
	echo('<ul class="navbar-nav mr-auto">');
	echo('
		<li class="nav-item active">
			<a class="nav-link" href="index.php">Inicio <span class="sr-only">(current)</span></a>
		</li>
	');
	echo('
		<li class="nav-item active">
			<a class="nav-link" href="lista_items.php">Lista ítems<span class="sr-only">(current)</span></a>
		</li>
	');
	if(empty($_SESSION['logged'])) {
		echo('
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Iniciar Sesión
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="login_admin.php">Administrador</a>
					<a class="dropdown-item" href="login_cliente.php">Cliente</a>
				</div>
			</li>
		');
	}
	echo('</ul>');
	echo('<ul class="navbar-nav mr-auto">');
	if(!empty($_SESSION['logged'])){
		if($_SESSION['logged'] == "admin") {
			echo('
				<li class="nav-item active">
					<a class="nav-link" href="alta_cliente.php">Alta cliente<span class="sr-only">(current)</span></a>
				</li>
			');
			echo('
				<li class="nav-item active">
					<a class="nav-link" href="lista_clientes.php">Lista clientes<span class="sr-only">(current)</span></a>
				</li>
			');
			echo('
				<li class="nav-item active">
					<a class="nav-link" href="alta_item.php">Alta ítem<span class="sr-only">(current)</span></a>
				</li>
			');
		}
	}
	echo('</ul>');
	echo('<ul class="navbar-nav ml-auto">');
	if(!empty($_SESSION['logged'])){
		if ($_SESSION['logged'] != "admin") {
			echo('
				<li class="nav-item active">
					<a class="nav-link" href="mi_perfil.php">Mi perfil<span class="sr-only">(current)</span></a>
				</li>
			');
			echo('
				<li class="nav-item active">
					<a class="nav-link" href="carrito.php">Mi carrito<span class="sr-only">(current)</span></a>
				</li>
			');
		}
	}
	if(! empty($_SESSION['logged'])) {
		echo('
		<li class="nav-item active">
			<a class="nav-link" href="logout.php">Cerrar sesión<span class="sr-only">(current)</span></a>
		</li>
		');
	}
	echo('</ul>');
?>
<hr />