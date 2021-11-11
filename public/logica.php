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
  } else {
    echo "Error: " . mysqli_error($conex);
  }
}

function modificar_cliente($ci, $pass, $nombre_completo)
{
  $conex = conectar_db();
  $modificar_cliente_ps = $conex->prepare("UPDATE clientes SET pass=?, nombre_completo=? WHERE ci=?");
  $modificar_cliente_ps->bind_param("sss", $pass, $nombre_completo, $ci);
  if ($modificar_cliente_ps->execute()) {
    echo "Query exitosa";
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
}

// Lógica Comprar
function comprar($ci, $tipo_pago, $feedback, $items)
{
  $conex = conectar_db();
  $comprar_ps = $conex->prepare("INSERT INTO compras(ci, tipo_pago, feedback) VALUES (?, ?, ?");
  $comprar_ps->bind_param("sssi", $ci, $tipo_pago, $feedback);
  if ($comprar_ps->execute()) {
    echo "Query exitosa";
  } else {
    echo "Error: " . mysqli_error($conex);
  }
  $id_compra = $conex->insert_id; // autoincremental generado en la última query
  $comprar_items_ps = $conex->prepare("INSERT INTO compras_items(id_compra, codigo_item, cantidad) VALUES (?, ?, ?)");
  foreach ($items as $codigo_item => $cantidad) {
    $comprar_items_ps->bind_param("iii", $id_compra, $codigo_item, $cantidad);
    if ($comprar_ps->execute()) {
      echo "Query exitosa";
    } else {
      echo "Error: " . mysqli_error($conex);
    }
  }
  unset($item);
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
  while ($listar_items_ps->fetch()) {
    // Esto sería si el logeado es un cliente
    echo ("Código: " . $codigo . "<br />"
      . "Nombre: " . $nombre . "<br />"
      . "Precio: " . $precio . "<br />"
      . "Stock: " . $stock . "<br />");

    // Esto sería si el logeado es el admin
    // echo ("Código: " . $codigo);
    // echo('<form action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '" method="post">');
    // echo('<input type="hidden" name="codigo" value="' . $codigo . '" />');
    // echo('Nombre: <input type="text" name="nombre" value="' . $nombre . '" required /><br />');
    // echo(' Precio: <input type="number" step="0.01" min="0.01" name="precio" value="' . $precio . '" required /><br />');
    // echo(' Stock: <input type="number" step="1" min="0" name="stock" value="' . $stock . '" required /><br />');
    // echo('<input type="submit" name="submit_modif" value="Modificar ítem" /></form>');
    $listar_fotos_items_ps->bind_param("i", $codigo);
    $listar_fotos_items_ps->execute();
    $listar_fotos_items_ps->store_result();
    $listar_fotos_items_ps->bind_result($foto_tipo, $foto_datos);
    $tiene_foto = false;
    while ($listar_fotos_items_ps->fetch()) {
      $tiene_foto = true;
      echo '<img src="data:' . $foto_tipo . ';base64,' . base64_encode($foto_datos) . '" width="200px" / >';
    }
    if (!$tiene_foto) {
      $foto_datos = base64_encode(file_get_contents(__DIR__ . '/../public/img/defaults/noimg.jpg'));
      echo '<img src="data:image/jpeg;base64,' . $foto_datos . '" width="100px" />';
    }
    // De nuevo, esto en caso del admin
    // echo('<form action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '" method="post">');
    // echo('<input type="hidden" name="codigo" value="' . $codigo . '" />');
    // echo('<input type="submit" name="submit_baja" value="Baja ítem" /></form>');
    echo("<br />");
  }
}

?>