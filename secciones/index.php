<?php include('../templates/cabecera.php'); ?>
<?php
session_start();

// Verificar si la sesión está iniciada
if (isset($_SESSION['usuario'])) {
  // La sesión está iniciada, puedes continuar con el código aquí
} else {
  // La sesión no está iniciada, puedes redirigir al usuario a otra página o mostrar un mensaje de error
  header("Location: ../index.php"); // Redirigir a la página de inicio de sesión
  exit(); // Terminar el script
}
?>


<div class="container">
  <div class="container-fluid vh-100 d-flex align-items-center justify-content-center">
    <div class="welcome-caja text-center">
      <h1 class="input-boxwelcome">¡Bienvenido!</h1>
      <p class="input box">Gracias por visitar nuestra página.</p>
      <a href="operadores.php" class="btn btn-primary btn-lg">Comenzar</a>
    </div>
  </div>
</div>
<?php include('../templates/pie.php'); ?>