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
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-center mt-5">
                <h1 class="display-1">404</h1>
                <h2 class="display-4">Página no encontrada</h2>
                <p class="lead">Lo sentimos, la página que estás buscando no se encuentra disponible.</p>
                <a href="index.php" class="btn btn-primary">Volver a la página de inicio</a>
            </div>
        </div>
    </div>
</div>
<?php include('../templates/pie.php'); ?>