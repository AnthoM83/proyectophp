<?php session_start() ?>
<?php
require("logica.php");
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
  <?php include("header.php") ?>
  <title>Iniciar sesión como cliente</title>
</head>

<body>
  <h3>Iniciar sesión como cliente</h3>
  <?php
  if (isset($error) && $error != "") {
    echo ("<p>ERROR: " . $error . "</p>");
  }
  ?>
  <form action=<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?> method="post">
    <input type="hidden" name="opcion" value="login" />
    <label for="ci">Cédula:</label>
    <input type="text" name="ci" required /><br /><br />
    <label for="pass">Contraseña:</label>
    <input type="password" name="pass" required /><br /><br />
    <input type="submit" value="Iniciar sesión" />
  </form>
  <?php include("footer.php") ?>
</body>

</html>