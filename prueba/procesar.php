<?php
 if (isset($_FILES['imagen']) && 
is_uploaded_file($_FILES['imagen']['tmp_name'])) {
   //se ha enviado un archivo con ese nombre y se ha cargado correctamente
   $nombreTemporal = $_FILES['imagen']['tmp_name'];
   if (is_file($nombreTemporal)) {
    // Se mueve el archivo a su ubicación deseada
    $directorioDestino = "./";
    $nombreArchivo = time()."-".$_FILES['imagen']['name'];
    $rutaCompleta = $directorioDestino . $nombreArchivo;
    if (move_uploaded_file($nombreTemporal, 
$rutaCompleta)) {
      echo "El archivo se ha subido y movido con 
éxito.";
    } else {
      echo "Error al mover el archivo.";
    }
   } else {
    echo "Error: El archivo no es válido.";
   }
  } else {
   echo "Error: No se recibió un archivo válido.";
  }
 ?>