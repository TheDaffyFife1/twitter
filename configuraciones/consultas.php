<?php
// buscar_cliente.php

// Conectar a la base de datos (asegúrate de configurar las credenciales adecuadamente)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "twitter";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el término de búsqueda del formulario


if (isset($_POST['consulta'])) {
    $consulta = $_POST['consulta'];

    // Consulta a la base de datos para obtener el cliente y estado desde ambas tablas
$sql = "
    (SELECT clientes AS cliente, paises AS pais, estado, NULL AS partido
     FROM tabla_consulta
     WHERE clientes LIKE '%$consulta%')
    UNION
    (SELECT cliente, NULL AS pais, entidad AS estado, partido
     FROM tabla_estatus
     WHERE cliente LIKE '%$consulta%')
";


    $result = $conn->query($sql);

    if ($result === false) {
        // Handle the query error here
        $error_message = $conn->error;
        echo json_encode(array('error' => $error_message));
        die(); // Stop script execution
    }

    // Obtener los resultados y devolverlos como JSON
    $results_array = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $results_array[] = $row;
        }
    }

    echo json_encode($results_array);
}
$conn->close();
