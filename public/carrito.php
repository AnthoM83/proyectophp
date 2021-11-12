<?php session_start() ?>
<?php
require("logica.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST['submit_compra'])) {
    $feedback = null;
    if ($_POST['feedback'] != "") {
      $feedback = $_POST['feedback'];
    }
    comprar("12345678", $_POST['tipo_pago'], $_POST['total'], $feedback, $_SESSION['carrito']);
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <?php include("header.php") ?>
  <title>Mi carrito</title>
</head>

<body>
  <h3>Mi carrito</h3>
  <?php
  if (isset($error) && $error != "") {
    echo ("<p>ERROR: " . $error . "</p>");
  }
  listar_carrito();
  ?>

</body>

</html>