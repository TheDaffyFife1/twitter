<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "twitter";


// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $operador = $_POST["operador"];
    $turno = $_POST["turno"];
    $entidad = $_POST["entidad"];
    $partido = $_POST["partido"];
    $coalicion = $_POST["coalicion"];
    $cliente = $_POST["cliente"];
    $identidad_perfil = $_POST["identidad_perfil"];
    $reaccion = $_POST["reaccion"];
    $nombre_usuario = $_POST["nombre_usuario"];
    $usuario = $_POST["usuario"];
    $contraseña = $_POST["contraseña"];
    $correo = $_POST["correo"];
    $telefono = $_POST["telefono"];
    $compañia = $_POST["compañia"];
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
    $sexo = $_POST["sexo"];
    $link = $_POST["link"];

    // Crear una conexión a la base de datos
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar si la conexión fue exitosa
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Preparar la consulta SQL para insertar los datos en la tabla tabla_consulta
    $sql = "INSERT INTO tabla_consulta (cliente, estado, publica, link, fecha_publicacion, enfoque, likes, comentarios, rt) 
            VALUES ('$cliente', '$estado', '$publica', '$link', '$fecha_publicacion', '$enfoque', '$likes', '$comentarios', '$rt')";

    // Ejecutar la consulta SQL
    if ($conn->query($sql) === TRUE) {
        echo "Los datos se guardaron correctamente en la tabla_consulta.";
    } else {
        echo "Error al guardar los datos en la tabla_consulta: " . $conn->error;
    }

    // Obtener el ID del último registro insertado en tabla_consulta
    $consulta_id = $conn->insert_id;

    // Preparar la consulta SQL para insertar los datos en la tabla tabla_estatus
    $sql = "INSERT INTO tabla_estatus (consulta_id, operador, turno, entidad, partido, coalicion, identidad_perfil, reaccion, nombre_usuario, usuario, contraseña, correo, telefono, compañia, fecha_nacimiento, sexo) 
            VALUES ('$consulta_id', '$operador', '$turno', '$entidad', '$partido', '$coalicion', '$identidad_perfil', '$reaccion', '$nombre_usuario', '$usuario', '$contraseña', '$correo', '$telefono', '$compañia', '$fecha_nacimiento', '$sexo')";

    // Ejecutar la consulta SQL
    if ($conn->query($sql) === TRUE) {
        echo "Los datos se guardaron correctamente en la tabla_estatus.";
    } else {
        echo "Error al guardar los datos en la tabla_estatus: " . $conn->error;
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
}
?>
