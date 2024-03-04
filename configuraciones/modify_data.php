<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "twitter";


$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['modify_data']) && isset($_POST['record_id'])) {
    // Here, you should implement the logic to modify the data in the database

    $recordId = $_POST['record_id'];
    $cuenta =  $_POST['cuenta'];
    $operador = $_POST['operador'];
    $turno = $_POST['turno'];
    $entidad = $_POST['entidad'];
    $partido = $_POST['partido'];
    $coalicion = $_POST['coalicion'];
    $cliente = $_POST['cliente'];
    $identidad_perfil = $_POST['identidad_perfil'];
    $reaccion = $_POST['reaccion'];
    $nombre_usuario = $_POST['nombre_usuario'];
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $compania = $_POST['compania'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $sexo = $_POST['sexo'];

    // Prepare the SQL query to update the record (replace 'your_table_name', and 'id' with your actual table name and primary key column name)
    $sql = "UPDATE tabla_estatus SET cuenta = ?, operador = ?, turno = ?, entidad = ?, partido = ?, coalicion = ?, cliente = ?, identidad_perfil = ?, reaccion = ?, nombre_usuario = ?, usuario = ?, contraseña = ?, correo = ?, telefono = ?, compania = ?, fecha_nacimiento = ?, sexo = ? WHERE id = ? LIMIT 1";

    // Create a prepared statement
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Bind the parameters to the prepared statement
        mysqli_stmt_bind_param(
            $stmt,
            "sssssssssssssssssi",
            $cuenta,
            $operador,
            $turno,
            $entidad,
            $partido,
            $coalicion,
            $cliente,
            $identidad_perfil,
            $reaccion,
            $nombre_usuario,
            $usuario,
            $contrasena,
            $correo,
            $telefono,
            $compania,
            $fecha_nacimiento,
            $sexo,
            $recordId
        );

        // Execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Check the number of affected rows
            $affectedRows = mysqli_stmt_affected_rows($stmt);

            if ($affectedRows > 0) {
                // Send a success response back to the client
                $response = array('status' => 'success', 'message' => 'Data modified successfully.');
            } else {
                // No rows were affected (Record not found or already updated)
                $response = array('status' => 'error', 'message' => 'No record found or data already up to date.');
            }
        } else {
            // Error executing the prepared statement
            $response = array('status' => 'error', 'message' => 'Error updating data: ' . mysqli_error($conn));
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);

    } else {
        // Error creating the prepared statement
        $response = array('status' => 'error', 'message' => 'Error: ' . mysqli_error($conn));
    }

    // Send the JSON response back to the client
    echo json_encode($response);

    exit; // End the script after handling the modification request
}

// Close the database connection
mysqli_close($conn);
?>
