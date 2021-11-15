<?php session_start() ?>
<?php
  include 'logica.php';
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $okay = login_cliente($_POST['ci'], $_POST['pass']);
    if ($okay) {
      $_SESSION['logged'] = $_POST['ci'];
      header("Location: exito.php");
    } else {
      $error = "Credenciales incorrectas.";
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
	<title>TecnoStore - Iniciar Sesión</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<a class="navbar-brand" href="#">TecnoStore</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<?php include("header.php") ?>
		</div>
	</nav>
  
  
  <div class="simple-login-container">
    <h3>Iniciar sesión como cliente</h3>
    <?php
    if (isset($error) && $error != "") {
      echo ("<p>ERROR: " . $error . "</p>");
    }?>
    <form action=<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?> method="post">
    <input type="hidden" name="opcion" value="login" />
    <div class="row">
        <div class="col-md-12 form-group">
            <input type="text" id="ci" class="fadeIn first" name="ci" placeholder="Cedula Ej:12345678" required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 form-group">
            <input type="password" id="pass" class="fadeIn second" name="pass" placeholder="Contraseña">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 form-group">
            <input type="submit" class="fadeIn third" value="Iniciar sesión">
        </div>
    </div>
    </form>
  </div>
</body>

</html>