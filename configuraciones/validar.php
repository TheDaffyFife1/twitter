<?php
ini_set('display_errors', 1); error_reporting(E_ALL);

$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];
session_start();
$_SESSION['usuario'] = $usuario;

$conexion = mysqli_connect("localhost", "root", "", "twitter");

$consulta = "SELECT * FROM usuarios WHERE usuario='$usuario' AND contrasena='$contrasena'";
$resultado = mysqli_query($conexion, $consulta);

$filas = mysqli_fetch_array($resultado);

function tieneAcceso($permiso, $rol)
{
    // Verificar los permisos basados en el rol del usuario
    if ($rol == 1) { // Administrador
        return true; // El administrador tiene acceso a todos los permisos
    } elseif ($rol == 2) { // Operador
        // Verificar los permisos específicos para el operador
        if ($permiso == 'Operador') {
            return true; // El operador tiene acceso al permiso 'Operador'
        }
    }

    return false; // Si no se cumple ninguna condición, el usuario no tiene acceso al permiso
}

if ($filas['id_cargo'] == 1) { // Administrador
    // Verificar si el usuario tiene acceso a operadorAdmin.php
    if (tieneAcceso('Administrador', $filas['id_cargo'])) {
        header("Location: ../secciones/index.php");
        exit; // Importante: añadir 'exit' después de la redirección para evitar que el resto del código se ejecute
    } else {
        // Redirigir a otra página o mostrar un mensaje de error
        header("Location: ../secciones/pagina_de_error.php");
        exit; // Importante: añadir 'exit' después de la redirección para evitar que el resto del código se ejecute
    }
} elseif ($filas['id_cargo'] == 2) { // Operador
    // Verificar si el usuario tiene acceso a operadores.php
    if (tieneAcceso('Operador', $filas['id_cargo'])) {
        header("Location: ../secciones/index.php");
        exit; // Importante: añadir 'exit' después de la redirección para evitar que el resto del código se ejecute
    } else {
        // Redirigir a otra página o mostrar un mensaje de error
        header("Location: ../secciones/pagina_de_error.php");
        exit; // Importante: añadir 'exit' después de la redirección para evitar que el resto del código se ejecute
    }
} else {
    header("Location: ../index.php");
    exit; // Importante: añadir 'exit' después de la redirección para evitar que el resto del código se ejecute
}

?>
