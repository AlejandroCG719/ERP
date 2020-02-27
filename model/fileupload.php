<?php
if ($_FILES['archivo']["error"] > 0) {
  echo "Error: " . $_FILES['archivo']['error'] . "<br>";
}else {
  $file_name = $_POST["FileName"];
  /*
  echo "Nombre: " . $_FILES['archivo']['name'] . "<br>";
  echo "Tipo: " . $_FILES['archivo']['type'] . "<br>";
  echo "Tamaño: " . ($_FILES["archivo"]["size"] / 1024) . " kB<br>";
  echo "Carpeta temporal: " . $_FILES['archivo']['tmp_name'];
  */

  $b=0;
  $ext = "";
  for ($i=0; $i < strlen($_FILES['archivo']['name']) ; $i++) {
    if ($b==1) {
      $ext.= $_FILES['archivo']['name'][$i];
    }
    if ($_FILES['archivo']['name'][$i] == ".") {
      $b= 1;
      $ext.= $_FILES['archivo']['name'][$i];
    }
  }

  /*ahora co la funcion move_uploaded_file lo guardaremos en el destino que queramos*/
  move_uploaded_file($_FILES['archivo']['tmp_name'], "../cv/".$file_name.$ext);
}
?>
