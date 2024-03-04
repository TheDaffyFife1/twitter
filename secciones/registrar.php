<?php
include('../templates/cabecera.php');
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];

    $conexion = mysqli_connect("localhost", "root", "", "twitter");


    $consulta = "SELECT * FROM usuarios WHERE usuario='$usuario'";
    $resultado = mysqli_query($conexion, $consulta);
    $filas = mysqli_fetch_array($resultado);

    function tieneAcceso($permiso, $rol)
    {
        // Verificar los permisos basados en el rol del usuario
        if ($rol == 1) { // Administrador
            return true; // El administrador tiene acceso a todos los permisos
        }
        return false; // Si no se cumple ninguna condición, el usuario no tiene acceso al permiso
    }

    if (tieneAcceso('Administrador', $filas['id_cargo'])) {
        // Contenido para el administrador
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Procesar el formulario de creación de usuarios

            // Validación y limpieza de datos
            $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
            $usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
            $contrasena = mysqli_real_escape_string($conexion, $_POST['contrasena']);
            $id_cargo = (int)$_POST['id_cargo'];

            // Hash de la contraseña (mejor opción que almacenarla en texto plano)
            $contraseña_hashed = password_hash($contrasena, PASSWORD_DEFAULT);

            // Realizar las operaciones necesarias para crear el usuario en la base de datos
            $sql = "INSERT INTO usuarios(nombre, usuario, contrasena, id_cargo) VALUES ('$nombre', '$usuario', '$contrasena', $id_cargo)";

            if ($conexion->query($sql) === true) {
                echo "Los datos se guardaron correctamente en la base de datos.";
            } else {
                echo "Error al guardar los datos: " . $conexion->error;
            }
        }
?>

<div class="wrapper">

    <span class="icon-close"><ion-icon name="close-outline"></ion-icon>
</span>

    <div class="form-box login">
        <h2>Registro de usuario</h2>
        <form method="POST" action="">
            <div class="input-box">
                <span class="icon"><ion-icon name="person-circle-outline"></ion-icon></span>
                <input type="text" id="nombre" name="nombre"  required>
                <label>Nombre</label>
            </div>
            <div class="input-box">
                <span class="icon"><ion-icon name="lock-closed-outline"></ion-icon></span>
                <input type="text" id="usuario" name="usuario"  required>
                <label>Nombre de usuario</label>
            </div>
            <div class="input-box">
                <span class="icon"><ion-icon name="lock-closed-outline"></ion-icon></span>
                <input type="password" id="contrasena" name="contrasena"  required>
                <label>Contraseña</label>
            </div>
            <div class="form-group">
                    <label for="id_cargo">Rol:</label>
                    <select id="id_cargo" name="id_cargo" class="form-control">
                        <option value="1">Administrador</option>
                        <option value="2">Operador</option>
                    </select>
                </div>
            <div>
            <button type="submit" class="btn">Registrar usuario</buttom>
        </form>
        </div>
    </div>

<?php
    } else {
        // Redirigir a otra página o mostrar un mensaje de error
        header("Location: ../secciones/pagina_de_error.php");
        exit; // Importante: añadir 'exit' después de la redirección para evitar que el resto del código se ejecute
    }

    mysqli_free_result($resultado);
    mysqli_close($conexion);
} else {
    // Redirigir a la página de inicio de sesión si no hay sesión activa
    header("Location: ../index.php");
    exit; // Importante: añadir 'exit' después de la redirección para evitar que el resto del código se ejecute
}
?>

<?php include('../templates/pie.php'); ?>
