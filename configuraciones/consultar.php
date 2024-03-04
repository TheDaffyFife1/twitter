<?php
// Verificar si la solicitud es de tipo POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener el término de búsqueda enviado desde el formulario
    $searchTerm = $_POST["consulta"];

    // Conectar a la base de datos (suponiendo que utilizas las credenciales que proporcionaste)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "twitter";


    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar si hay un error en la conexión
    if ($conn->connect_error) {
        die(json_encode(array("error" => "Error en la conexión: " . $conn->connect_error)));
    }

    // Escapar el término de búsqueda para evitar ataques de inyección de SQL
    $searchTerm = $conn->real_escape_string($searchTerm);

    // Consulta SQL para obtener los resultados basados en el término de búsqueda
    $sql = "SELECT clientes, fecha_publicacion, likes, comentarios, rt
            FROM tabla_consulta 
            WHERE clientes LIKE '%$searchTerm%'
            OR estado LIKE '%$searchTerm%'
            OR enfoque LIKE '%$searchTerm%'";

    $result = $conn->query($sql);

    // Verificar si hay resultados y construir el array de resultados
    $resultsArray = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $resultsArray[] = $row;
        }
    }

    // Cerrar la conexión a la base de datos
    $conn->close();

    // Devolver los resultados en formato JSON
    header("Content-Type: application/json");
    echo json_encode($resultsArray);
} else {
    // Si la solicitud no es de tipo POST, devolver un mensaje de error
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode(array("error" => "Método no permitido"));
}
?>
