<?php
// 1. Conectar a la base de datos (ejemplo con MySQLi)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "twitter";


$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// 2. Procesar datos enviados por el formulario de edición
if (isset($_POST['submit'])) {
    $cuenta = $_POST['cuenta'];
    $operador = $_POST['operador'];
    $turno = $_POST['turno'];
    $entidad = $_POST['entidad'];
    $partido = $_POST['partido'];
    $coalicion = $_POST['coalicion'];
    $cliente = $_POST['cliente'];
    $identidad_perfil = $_POST['identidad_perfil'];
    $tipo_reaccion = $_POST['tipo_reaccion'];
    $nombre_usuario = $_POST['nombre_usuario'];
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $compania = $_POST['compania'];
    $nacimiento = $_POST['nacimiento'];
    $sexo = $_POST['sexo'];

    // Actualizar los datos en la base de datos
    $sql = "UPDATE tabla_estatus SET
                operador='$operador',
                turno='$turno',
                entidad='$entidad',
                partido='$partido',
                coalicion='$coalicion',
                cliente='$cliente',
                identidad_perfil='$identidad_perfil',
                tipo_reaccion='$tipo_reaccion',
                nombre_usuario='$nombre_usuario',
                usuario='$usuario',
                contrasena='$contrasena',
                correo='$correo',
                telefono='$telefono',
                compania='$compania',
                nacimiento='$nacimiento',
                exo='$sexo'
            WHERE Cuenta='$cuenta'";

    if ($conn->query($sql) === TRUE) {
        echo "Datos actualizados exitosamente.";
    } else {
        echo "Error al actualizar los datos: " . $conn->error;
    }
}

// 3. Mostrar los datos en la tabla y los formularios de edición
$sql = "SELECT * FROM tabla_estatus"; // Reemplaza "nombre_de_la_tabla" con el nombre real de tu tabla
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<form method='post'>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><input type='hidden' name='cuenta' value='" . $row['Cuenta'] . "'>" . $row['Cuenta'] . "</td>";
        echo "<td><input type='text' name='operador' value='" . $row['Operador'] . "'></td>";
        echo "<td><input type='text' name='turno' value='" . $row['Turno'] . "'></td>";
        echo "<td><input type='text' name='entidad' value='" . $row['Entidad'] . "'></td>";
        echo "<td><input type='text' name='partido' value='" . $row['Partido'] . "'></td>";
        echo "<td><input type='text' name='coalicion' value='" . $row['Coalicion'] . "'></td>";
        echo "<td><input type='text' name='cliente' value='" . $row['Cliente'] . "'></td>";
        echo "<td><input type='text' name='identidad_perfil' value='" . $row['IdentidadPerfil'] . "'></td>";
        echo "<td><input type='text' name='tipo_reaccion' value='" . $row['TipoReaccion'] . "'></td>";
        echo "<td><input type='text' name='nombre_usuario' value='" . $row['NombreUsuario'] . "'></td>";
        echo "<td><input type='text' name='usuario' value='" . $row['Usuario'] . "'></td>";
        echo "<td><input type='text' name='contrasena' value='" . $row['Contrasena'] . "'></td>";
        echo "<td><input type='text' name='correo' value='" . $row['Correo'] . "'></td>";
        echo "<td><input type='text' name='telefono' value='" . $row['Telefono'] . "'></td>";
        echo "<td><input type='text' name='compania' value='" . $row['Compania'] . "'></td>";
        echo "<td><input type='text' name='nacimiento' value='" . $row['Nacimiento'] . "'></td>";
        echo "<td><input type='text' name='sexo' value='" . $row['Sexo'] . "'></td>";
        echo "<td><input type='submit' name='submit' value='Guardar'></td>";
        echo "</tr>";
    }
    echo "</form>";
} else {
    echo "<tr><td colspan='18'>No se encontraron registros</td></tr>";
}

// Cerrar la conexión a la base de datos
$conn->close();
?>