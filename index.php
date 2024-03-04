<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesion</title>
    <link rel="stylesheet" href="./estilos/style.css">
<head>


<body>
	<header>
    <h2 class="logo">Twitter</h2>
    <nav class="navigation">
	</header>
       

<div class="wrapper">

   

    <div class="form-box login">
        <h2>Login</h2>
        <form action="configuraciones/validar.php" method="post">
            <div class="input-box">
                <span class="icon"><ion-icon name="person-circle-outline"></ion-icon></span>
                <input type="Usuario" name="usuario" id="usuario" required>
                <label>Usuario</label>
            </div>
            <div class="input-box">
                <span class="icon"><ion-icon name="lock-closed-outline"></ion-icon></span>
                <input type="password" name="contrasena" id="contrasena" required>
                <label>Contraseña</label>
            </div>
            <div>
            <button type="submit" class="btn">Login</buttom>
        </form>
    </div>
</div>


<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

<body>
</html>