<?php

require("conexion.php");

// Fix input
function fix_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// ABM Clientes
function alta_cliente($ci, $pass, $nombre_completo)
{
  $conex = conectar_db();
  $agregar_cliente_ps = $conex->prepare("INSERT INTO clientes(ci, pass, nombre_completo) VALUES (?, ?, ?)");
  $agregar_cliente_ps->bind_param("sss", $ci, $pass, $nombre_completo);
  if ($agregar_cliente_ps->execute()) {
    echo "Query exitosa";
    header("Location: exito.php");
  } else {
    echo "Error: " . mysqli_error($conex);
  }
}

function baja_cliente($ci)
{
  $conex = conectar_db();
  $borrar_cliente_ps = $conex->prepare("DELETE FROM clientes WHERE ci=?");
  $borrar_cliente_ps->bind_param("s", $ci);
  if ($borrar_cliente_ps->execute()) {
    echo "Query exitosa";
    header("Location: exito.php");
  } else {
    echo "Error: " . mysqli_error($conex);
  }
}

function modificar_cliente_nombre($ci, $nombre_completo)
{
  $conex = conectar_db();
  $modificar_cliente_nombre_ps = $conex->prepare("UPDATE clientes SET nombre_completo=? WHERE ci=?");
  $modificar_cliente_nombre_ps->bind_param("ss", $nombre_completo, $ci);
  if ($modificar_cliente_nombre_ps->execute()) {
    echo "Query exitosa";
    header("Location: exito.php");
  } else {
    echo "Error: " . mysqli_error($conex);
  }
}

function modificar_cliente_pass($ci, $n_pass)
{
  $conex = conectar_db();
  $modificar_cliente_pass_ps = $conex->prepare("UPDATE clientes SET pass=? WHERE ci=?");
  $modificar_cliente_pass_ps->bind_param("ss", $n_pass, $ci);
  if ($modificar_cliente_pass_ps->execute()) {
    echo "Query exitosa";
    header("Location: exito.php");
  } else {
    echo "Error: " . mysqli_error($conex);
  }
}

// ABM Items
function alta_item($nombre, $precio, $stock_inicial)
{
  $conex = conectar_db();
  $cod = rand(10000000, 99999999);
  $agregar_item_ps = $conex->prepare("INSERT INTO items(codigo, nombre, precio, stock) VALUES (?, ?, ?, ?)");
  $agregar_item_ps->bind_param("isdi", $cod, $nombre, $precio, $stock_inicial);
  $okay = false;
  if ($agregar_item_ps->execute()) {
    echo "Query exitosa";
    $okay = true;
  } else {
    echo "Error: " . mysqli_error($conex);
  }

  if (count($_FILES) > 0) {
    if (is_uploaded_file($_FILES['foto']['tmp_name'])) {
      $foto_datos = addslashes(file_get_contents($_FILES['foto']['tmp_name']));
      $foto_propiedades = getimageSize($_FILES['foto']['tmp_name']);
      $sql = "INSERT INTO fotos_items(codigo_item, foto_tipo , foto_datos) VALUES($cod, '{$foto_propiedades['mime']}', '{$foto_datos}')";
      $current_id = mysqli_query($conex, $sql) or die("<b>Error:</b> Problema al insertar imagen<br/>" . mysqli_error($conex));
      if (isset($current_id)) {
        $okay = true;
      }
    }
  }

  if ($okay) header("Location: exito.php");
}

function baja_item($cod)
{
  $conex = conectar_db();
  $borrar_item_ps = $conex->prepare("DELETE FROM items WHERE codigo=?");
  $borrar_item_ps->bind_param("s", $cod);
  if ($borrar_item_ps->execute()) {
    echo "Query exitosa";
    header("Location: exito.php");
  } else {
    echo "Error: " . mysqli_error($conex);
  }
}

function modificar_item($cod, $nombre, $precio, $stock)
{
  $conex = conectar_db();
  $modificar_item_ps = $conex->prepare("UPDATE items SET nombre=?, precio=?, stock=? WHERE codigo=?");
  $modificar_item_ps->bind_param("sdii", $nombre, $precio, $stock, $cod);
  if ($modificar_item_ps->execute()) {
    echo "Query exitosa";
    header("Location: exito.php");
  } else {
    echo "Error: " . mysqli_error($conex);
  }
}

function agregar_foto($cod)
{
  $conex = conectar_db();
  if (count($_FILES) > 0) {
    if (is_uploaded_file($_FILES['foto']['tmp_name'])) {
      $foto_datos = addslashes(file_get_contents($_FILES['foto']['tmp_name']));
      $foto_propiedades = getimageSize($_FILES['foto']['tmp_name']);
      $sql = "INSERT INTO fotos_items(codigo_item, foto_tipo , foto_datos) VALUES($cod, '{$foto_propiedades['mime']}', '{$foto_datos}')";
      $current_id = mysqli_query($conex, $sql) or die("<b>Error:</b> Problema al insertar imagen<br/>" . mysqli_error($conex));
      if (isset($current_id)) {
        header("Location: exito.php");
      }
    }
  }
}

// Lógica Comprar
function comprar($ci, $tipo_pago, $total, $feedback, $items)
{
  $conex = conectar_db();
  $comprar_ps = $conex->prepare("INSERT INTO compras(ci_cliente, tipo_pago, total, feedback) VALUES (?, ?, ?, ?)");
  $comprar_ps->bind_param("ssds", $ci, $tipo_pago, $total, $feedback);
  if ($comprar_ps->execute()) {
    echo "Query exitosa";
  } else {
    echo "Error: " . mysqli_error($conex);
  }
  $id_compra = $conex->insert_id; // autoincremental generado en la última query
  $comprar_items_ps = $conex->prepare("INSERT INTO compras_items(id_compra, codigo_item, cantidad) VALUES (?, ?, ?)");
  $restar_stock_ps = $conex->prepare("UPDATE items SET stock = stock - ? WHERE codigo=?");
  foreach ($items as $codigo_item => $cantidad) {
    $comprar_items_ps->bind_param("isi", $id_compra, $codigo_item, $cantidad);
    $restar_stock_ps->bind_param("is", $cantidad, $codigo_item);
    if ($comprar_items_ps->execute() && $restar_stock_ps->execute()) {
      echo "Query exitosa";
    } else {
      echo "Error: " . mysqli_error($conex);
    }
  }
  header("Location: exito.php");
  unset($codigo_item);
  $_SESSION['carrito'] = array();
}

// Lógica Listar
function listar_items()
{
  $conex = conectar_db();
  $listar_items_ps = $conex->prepare("SELECT * FROM items");
  $listar_items_ps->execute();
  $listar_items_ps->store_result();
  $listar_items_ps->bind_result($codigo, $nombre, $precio, $stock);
  $listar_fotos_items_ps = $conex->prepare("SELECT foto_tipo, foto_datos FROM fotos_items WHERE codigo_item=?");
  $artCount = 0;
  echo("<div class='container'>");
  while ($listar_items_ps->fetch()) {

    $esAdmin = 0;
    $logged = 0;
    if(!empty($_SESSION['logged'])){
      $logged = 1;
      if($_SESSION['logged'] == "admin"){
        $esAdmin = 1;
      }
    }

    if($artCount % 3 == 0){
      echo("<div class='row'>");
    }
    $artCount = $artCount + 1;
    echo("<div class='col'>");

    $listar_fotos_items_ps->bind_param("i", $codigo);
    $listar_fotos_items_ps->execute();
    $listar_fotos_items_ps->store_result();
    $listar_fotos_items_ps->bind_result($foto_tipo, $foto_datos);
    $tiene_foto = false;
    while ($listar_fotos_items_ps->fetch()) {
      $tiene_foto = true;
      echo ' <img src="data:' . $foto_tipo . ';base64,' . base64_encode($foto_datos) . '" width="200px" / >';
    }
    if (!$tiene_foto) {
      $foto_datos = base64_encode(file_get_contents(__DIR__ . '/../public/img/defaults/noimg.jpg'));
      echo '<img src="data:image/jpeg;base64,' . $foto_datos . '" width="100px" />';
    }

    if ($esAdmin == 0) {
      echo("Código: " . $codigo . "<br />"
      . "Nombre: " . $nombre . "<br />"
      . "Precio: " . $precio . "<br />"
      . "Stock: " . $stock . "<br />");
      if (! empty($_SESSION['logged'])) {
        echo('<form action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '" method="post">');
        echo('<input type="hidden" name="codigo" value="' . $codigo . '" />');
        echo('<input type="hidden" name="stock" value="' . $stock . '" />');
        echo(' Cantidad: <input type="number" step="1" min="0" name="cantidad" required />');
        echo('<input type="submit" name="submit_carrito" value="Añadir al carrito" /></form>');
      }
    }

    if ($esAdmin) {
      echo ("Código: " . $codigo);
      echo('<form action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '" method="post">');
      echo('<input type="hidden" name="codigo" value="' . $codigo . '" />');
      echo('Nombre: <input type="text" name="nombre" value="' . $nombre . '" required /><br />');
      echo(' Precio: <input type="number" step="0.01" min="0.01" name="precio" value="' . $precio . '" required /><br />');
      echo(' Stock: <input type="number" step="1" min="0" name="stock" value="' . $stock . '" required /><br />');
      echo('<input type="submit" name="submit_modif" value="Modificar ítem" /></form>');
      echo('<form action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '" method="post">');
      echo('<input type="hidden" name="codigo" value="' . $codigo . '" />');
      echo('<input type="submit" name="submit_baja" value="Baja ítem" /></form>');
    }

    
    if ($esAdmin) {
      echo('<form action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '" enctype="multipart/form-data" method="post">');
      echo('<input type="hidden" name="codigo" value="' . $codigo . '" />');
      echo('<input type="file" name="foto" required /><br /> ');
      echo('<input type="submit" name="submit_foto" value="Agregar foto" /></form>');
    }
    echo("</div>");
    if($artCount % 3 == 0){
      echo("</div>");
    }
    //$artCount = $artCount + 1;
    //echo("<br /><br />");
  }
  echo("</div>");
}

function listar_carrito() {
  if(empty($_SESSION['carrito'])) {
    echo("<p> Su carrito está vacío. </p>");
  } else {
    $total = 0;
    foreach ($_SESSION['carrito'] as $codigo => $cantidad) {
      $conex = conectar_db();
      $listar_items_ps = $conex->prepare("SELECT codigo, nombre, precio FROM items WHERE codigo=?");
      $listar_items_ps->bind_param("i", $codigo);
      $listar_items_ps->execute();
      $listar_items_ps->store_result();
      $listar_items_ps->bind_result($codigo, $nombre, $precio);
      $listar_fotos_items_ps = $conex->prepare("SELECT foto_tipo, foto_datos FROM fotos_items WHERE codigo_item=?");
      while ($listar_items_ps->fetch()) {
        echo("Código: " . $codigo . "<br />"
          . "Nombre: " . $nombre . "<br />"
          . "Precio: " . $precio . "<br />"
          . "Cantidad: " . $cantidad . "<br />");
        $listar_fotos_items_ps->bind_param("i", $codigo);
        $listar_fotos_items_ps->execute();
        $listar_fotos_items_ps->store_result();
        $listar_fotos_items_ps->bind_result($foto_tipo, $foto_datos);
        $tiene_foto = false;
        while ($listar_fotos_items_ps->fetch()) {
          $tiene_foto = true;
          echo ' <img src="data:' . $foto_tipo . ';base64,' . base64_encode($foto_datos) . '" width="200px" / >';
        }
        if (!$tiene_foto) {
          $foto_datos = base64_encode(file_get_contents(__DIR__ . '/../public/img/defaults/noimg.jpg'));
          echo '<img src="data:image/jpeg;base64,' . $foto_datos . '" width="100px" />';
        }
        echo("<br /><br />");
      }
      $total = $total + ($precio * $cantidad);
    }
    echo('TOTAL: $' . $total . "<br /><br />");
    echo('<form action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '" method="post">');
    echo('<input type="hidden" name="codigo" value="' . $codigo . '" />');
    echo('<input type="hidden" name="total" value="' . $total . '" />');
    echo('Forma de pago: <select name="tipo_pago" required />');
    echo('<option selected value="contado">Contado</option>');
    echo('<option value="debito">Débito</option>');
    echo('<option value="credito">Crédito</option></select><br /><br />');
    echo('<textarea name="feedback" rows="4" cols="50" placeholder="¿Desea dejar un comentario?"></textarea><br /><br />');
    echo('<input type="submit" name="submit_compra" value="Realizar compra" /></form>');
  }
}

function listar_clientes() {
  $conex = conectar_db();
  $listar_clientes_ps = $conex->prepare("SELECT ci, nombre_completo FROM clientes");
  $listar_clientes_ps->execute();
  $listar_clientes_ps->store_result();
  $listar_clientes_ps->bind_result($ci, $nombre_completo);
  while ($listar_clientes_ps->fetch()) {
    echo("Cédula: " . $ci . "<br />"
    . "Nombre: " . $nombre_completo . "<br />");
    if ($_SESSION['logged'] == "admin") {
      echo('<form action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '" method="post">');
      echo('<input type="hidden" name="cedula" value="' . $ci . '" />');
      echo('<input type="submit" name="submit_borrar" value="Baja usuario" /></form>');
    }
    echo("<br />");
  }
}

function mostrar_cliente($ci) {
  $conex = conectar_db();
  $mostrar_cliente_ps = $conex->prepare("SELECT ci, nombre_completo FROM clientes WHERE ci=?");
  $mostrar_cliente_ps->bind_param("s", $ci);
  $mostrar_cliente_ps->execute();
  $mostrar_cliente_ps->store_result();
  $mostrar_cliente_ps->bind_result($ci, $nombre_completo);
  while ($mostrar_cliente_ps->fetch()) {
    echo('Cédula: ' . $ci . '<br />');
    echo('<form action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '" method="post">');
    echo('<input type="hidden" name="cedula" value="' . $ci . '" />');
    echo('Nombre: <input type="text" name="nombre_completo" value="' . $nombre_completo . '" required /><br />');
    echo('<input type="submit" name="submit_nombre" value="Modificar nombre" /></form>');
    echo('<form action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '" method="post">');
    echo('<input type="hidden" name="cedula" value="' . $ci . '" />');
    echo('<br />Nueva contraseña: <input type="password" name="n_pass" required /><br />');
    echo('Verificar contraseña: <input type="password" name="n_pass2" required /><br />');
    echo('<input type="submit" name="submit_pass" value="Modificar contraseña" /></form><br />');
  }
}

function historial_compras($ci) {
  $conex = conectar_db();
  $historial_compras_ps = $conex->prepare("SELECT id, tipo_pago, total, feedback FROM compras WHERE ci_cliente=?");
  $historial_compras_ps->bind_param("s", $ci);
  $historial_compras_ps->execute();
  $historial_compras_ps->store_result();
  $historial_compras_ps->bind_result($id, $tipo_pago, $total, $feedback);
  $historial_items_ps = $conex->prepare("SELECT c_i.codigo_item, i.nombre, c_i.cantidad FROM compras_items AS c_i JOIN items AS i ON c_i.codigo_item=i.codigo WHERE c_i.id_compra=?");
  while($historial_compras_ps->fetch()) {
    echo("ID: " . $id . "<br />");
    echo("Forma de pago: " . $tipo_pago . "<br />");
    echo("Total: $" . $total . "<br />");
    if ($feedback != "") echo("Feedback: " . $feedback . "<br />");
    $historial_items_ps->bind_param("i", $id);
    $historial_items_ps->execute();
    $historial_items_ps->store_result();
    $historial_items_ps->bind_result($cod, $nombre, $cant);
    while($historial_items_ps->fetch()) {
      echo("x" .$cant . " " . $nombre . "<br />");
    }
    echo("<br />");
  }
}


// Login cliente
function login_cliente($ci, $pass) {
  $conex = conectar_db();
  $login_cliente_ps = $conex->prepare("SELECT ci, pass FROM clientes WHERE ci=? AND pass=?");
  $login_cliente_ps->bind_param("ss", $ci, $pass);
  $login_cliente_ps->execute();
  $login_cliente_ps->store_result();
  $login_cliente_ps->bind_result($ci_res, $pass_res);
  $existe = $login_cliente_ps->fetch();
  if ($existe == null || !$existe) {
    return false;
  } else {
    return true;
  }
}


?>