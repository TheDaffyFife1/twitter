<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Start or resume the session
session_start();

$servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "twitter";

// Verificar si la sesión está iniciada
if (!isset($_SESSION['usuario'])) {
    // La sesión no está iniciada, puedes redirigir al usuario a otra página o mostrar un mensaje de error // Redirigir a la página de inicio de sesión
    exit(); // Terminar el script
}


// Obtener el operador de la sesión
$operador = $_SESSION['usuario'];

// Función para determinar el turno (matutino o vespertino) basado en la hora actual
function obtenerFuncionTiempo()
{
    date_default_timezone_set('America/Mexico_City'); // Establecer la zona horaria deseada, por ejemplo, Ciudad de México

    $hora_actual = date('H:i'); // Obtener la hora actual en formato HH:MM

    // Comparar la hora actual con los límites del turno matutino y vespertino
    if ($hora_actual >= '06:00' && $hora_actual < '14:00') {
        return 'Matutino';
    } elseif ($hora_actual >= '14:00' && $hora_actual < '22:00') {
        return 'Vespertino';
    } else {
        return 'Fuera de horario';
    }
}

$funcionTiempo = obtenerFuncionTiempo();


// Verificar si se enviaron los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $clientes = $_POST['clientes'];
	$paises = $_POST['paises'];
    $estado = $_POST['estado'];
    $publica = $_POST['publica'];
    $links = $_POST['links'];
    $fecha_publicacion = $_POST['fecha_publicacion'];
    $enfoque = $_POST['enfoque'];
    $likes = $_POST['likes'];
    $comentarios = $_POST['comentarios'];
    $rt = $_POST['rt'];

    // Aquí puedes realizar las operaciones necesarias para guardar los datos en la base de datos

    // Ejemplo: Guardar el operador y el turno en la base de datos
    $conexion = new mysqli("rimgsa.com", "adminTwitter", "x4E277bt!", "twitter");

    if ($conexion->connect_error) {
        die("Error en la conexión a la base de datos: " . $conexion->connect_error);
    }

    // Preparar la consulta SQL
    $sql = "INSERT INTO tabla_consulta (clientes,paises, estado, publica, links, fecha_publicacion, enfoque, likes, comentarios, rt, operador, turno) VALUES ('$clientes','$paises', '$estado', '$publica', '$links', '$fecha_publicacion', '$enfoque', '$likes', '$comentarios', '$rt', '$operador', '$funcionTiempo')";
    // Ejecutar la consulta
    if ($conexion->query($sql) === true) {
        header("Location: ../secciones/operadores.php");
        } else {
        echo "Error al guardar los datos: " . $conexion->error;
    }

    $conexion->close();

    exit(); // Terminar el script después de procesar los datos
}
?>