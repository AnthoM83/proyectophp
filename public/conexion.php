<?php

function conectar_db() {
  $dbhost = "localhost";
  $dbuser = "anthom"; // cambiar acorde
  $dbpass = "1234"; // cambiar acorde
  $dbname = "php_db"; // cambiar acorde
  $conex = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
  if (!$conex) {
    die("Conexión fallida: " . mysqli_connect_error());
  }
  return $conex;
}

?>