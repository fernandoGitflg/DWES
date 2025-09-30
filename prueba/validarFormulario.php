 <?php
 // Variables para almacenar los errores
 $errores = array();
 // Verifica si se ha enviado el formulario
 if(isset($_POST["enviar"])) {
 // Validamos el campo llamado "nombre"
 if (empty($_POST["nombre"])) {
   $errores[] = "El campo 'Nombre' es obligatorio.";
 }
 // Verifica si hay errores
 if (count($errores) > 0) {
  echo "<h2>Formulario con Errores:</h2>";
  echo "<ul>";
 foreach ($errores as $error) {
   echo "<li>$error</li>";
  }
  echo "</ul>";
  // Mostrar el formulario
  include("formulario.php");
 } else {
  // Procesar el formulario si no hay errores
 }
 } else {
 // Mostrar el formulario
 include("formulario.php");
 }
 ?>