<?php

require("logica.php");

$opcion = $_POST['opcion'];
if ($opcion == "alta_cliente") {
  $ci = $_POST['ci'];
  $pass = $_POST['pass'];
  $nombre_completo = $_POST['nombre_completo'];
  alta_cliente($ci, $pass, $nombre_completo);
} elseif ($opcion == "baja_cliente") {
  baja_cliente($ci);
} elseif ($opcion == "modificar_cliente") {
  $pass = $_GET['pass'];
  $nombre_completo = $_GET['nombre_completo'];
  modificar_cliente($ci, $pass, $nombre_completo);
} elseif ($opcion == "alta_item") {
  $nombre = $_POST['nombre'];
  $precio = $_POST['precio'];
  $stock_inicial = $_POST['stock_inicial'];
  alta_item($nombre, $precio, $stock_inicial);
} elseif ($opcion == "baja_item") {

} elseif ($opcion == "modificar_item") {

} elseif ($opcion == "comprar") {

}
?>