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
    $sql = "SELECT usuario, partido, cliente,pais, entidad, cuenta,id_chip
            FROM tabla_estatus 
            WHERE usuario LIKE '%$searchTerm%'
            OR partido LIKE '%$searchTerm%'
			OR pais LIKE '%$searchTerm%'
            OR entidad LIKE '%$searchTerm%'
            OR cuenta LIKE '%$searchTerm%'
			OR id_chip LIKE '%$searchTerm%'";
			

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
} elseif ($_SERVER["REQUEST_METHOD"] === "PUT") {
    // Obtener los datos enviados desde la solicitud PUT
    parse_str(file_get_contents("php://input"), $putData);
    $usuario = $putData["usuario"];
    $cuenta = $putData["cuenta"];

    // Conectar a la base de datos (actualiza con tus credenciales)
    $servername = "rimgsa.com";
    $username = "adminTwitter";
    $password = "x4E277bt!";
    $dbname = "twitter";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar si hay un error en la conexión
    if ($conn->connect_error) {
        die(json_encode(array("error" => "Error en la conexión: " . $conn->connect_error)));
    }

    // Escapar los datos para evitar ataques de inyección de SQL
    $usuario = $conn->real_escape_string($usuario);
    $cuenta = $conn->real_escape_string($cuenta);

    // Actualizar el valor de la cuenta en la base de datos
    $updateSql = "UPDATE tabla_estatus
                  SET cuenta = '$cuenta'
                  WHERE usuario = '$usuario'";

    if ($conn->query($updateSql) === TRUE) {
        // Éxito en la actualización
        echo json_encode(array("success" => true));
    } else {
        // Error en la actualización
        echo json_encode(array("error" => "Error al actualizar la cuenta: " . $conn->error));
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
} else {
    // Si la solicitud no es de tipo POST o PUT, devolver un mensaje de error
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode(array("error" => "Método no permitido"));
}
?>
