<?php include('../templates/cabecera.php'); ?>

<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar si la sesión está iniciada
if (!isset($_SESSION['usuario'])) {
    // La sesión no está iniciada, puedes redirigir al usuario a otra página o mostrar un mensaje de error
    header("Location: ../index.php"); // Redirigir a la página de inicio de sesión
    exit(); // Terminar el script
}

// Obtener el operador de la sesión
$operador = $_SESSION['usuario'];
$cuenta = "Nueva";

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

// Obtener el turno actual
$funcionTiempo = obtenerFuncionTiempo();

// Verificar si se enviaron los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
	$pais = $_POST['pais'];
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
	$id_chip = $_POST['id_chip'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $sexo = $_POST['sexo'];


    // Aquí puedes realizar las operaciones necesarias para guardar los datos en la base de datos

    // Ejemplo: Guardar el operador y el turno en la base de datos
    $conexion = new mysqli("localhost", "root", "", "twitter");
		

    if ($conexion->connect_error) {
        die("Error en la conexión a la base de datos: " . $conexion->connect_error);
    }

    // Preparar la consulta SQL
    $sql = "INSERT INTO tabla_estatus (operador, turno, pais, entidad, partido, coalicion, cliente, identidad_perfil, reaccion, nombre_usuario, usuario, contrasena, correo, telefono, compania,id_chip, fecha_nacimiento, sexo,cuenta) VALUES ('$operador', '$funcionTiempo', '$pais', '$entidad', '$partido', '$coalicion', '$cliente', '$identidad_perfil', '$reaccion', '$nombre_usuario', '$usuario', '$contrasena', '$correo', '$telefono', '$compania','$id_chip', '$fecha_nacimiento', '$sexo','$cuenta')";
    // Ejecutar la consulta
    if ($conexion->query($sql) === true) {
        echo "Los datos se guardaron correctamente en la base de datos.";
        header("Location:operadores.php");
    } else {
        echo "Error al guardar los datos: " . $conexion->error;
    }

    $conexion->close();

    exit(); // Terminar el script después de procesar los datos
}
?>


<?php
// Placeholder values for demonstration purposes
$cuentasActivas = 0;
$cuentasBloqueadas = 0;
$cuentasNuevas = 0;
$cuentasApelacion = 0;

$conexion = new mysqli("localhost", "root", "", "twitter");

if ($conexion->connect_error) {
    die("Error en la conexión a la base de datos: " . $conexion->connect_error);
}

$sql_activas = "SELECT COUNT(*) AS cuentas_activas FROM tabla_estatus WHERE cuenta = 'Activa'";
$resultado_activas = $conexion->query($sql_activas);

$sql_bloqueadas = "SELECT COUNT(*) AS cuentas_bloqueadas FROM tabla_estatus WHERE cuenta = 'Bloqueada'";
$resultado_bloqueadas = $conexion->query($sql_bloqueadas);

$sql_nuevas = "SELECT COUNT(*) AS cuentas_nuevas FROM tabla_estatus WHERE cuenta = 'Nueva'";
$resultado_nuevas = $conexion->query($sql_nuevas);

$sql_apelacion = "SELECT COUNT(*) AS cuentas_apelacion FROM tabla_estatus WHERE cuenta = 'Apelacion'";
$resultado_apelacion = $conexion->query($sql_apelacion);

if ($resultado_activas && $resultado_bloqueadas && $resultado_nuevas && $resultado_apelacion) {
    $fila_activas = $resultado_activas->fetch_assoc();
    $cuentasActivas = $fila_activas['cuentas_activas'];

    $fila_bloqueadas = $resultado_bloqueadas->fetch_assoc();
    $cuentasBloqueadas = $fila_bloqueadas['cuentas_bloqueadas'];

    $fila_nuevas = $resultado_nuevas->fetch_assoc();
    $cuentasNuevas = $fila_nuevas['cuentas_nuevas'];

    $fila_apelacion = $resultado_apelacion->fetch_assoc();
    $cuentasApelacion = $fila_apelacion['cuentas_apelacion'];
} else {
    echo "Error al obtener los datos: " . $conexion->error;
}

$conexion->close();

?>

<?php

$conn = new mysqli("localhost", "root", "", "twitter");

if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

// Realiza la consulta en la tabla "consulta"
$sql = "SELECT * FROM tabla_consulta";
$result = $conn->query($sql);


?>



<div class="container">
    <div class="row">
        <div class="col-12">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-white">Activos</th>
                        <th class="text-white">Bloqueados</th>
                        <th class="text-white">Nueva</th>
                        <th class="text-white">Apelacion</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-white"><?php echo $cuentasActivas; ?></td>
                        <td class="text-white"><?php echo $cuentasBloqueadas; ?></td>
                        <td class="text-white"><?php echo $cuentasNuevas; ?></td>
                        <td class="text-white"><?php echo $cuentasApelacion; ?></td>
                    </tr>
                    <!-- Los datos se agregarán dinámicamente aquí -->
                </tbody>
            </table>
        </div>

        <!-- Código HTML para mostrar el formulario -->
        <div class="row formulario-transparente">
            <div class="col-12">
            </div>
            <br>
            <br>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="operador">Operador:</label>
                    <input type="text" class="formcontrol" id="operador" name="operador" value="<?php echo $operador; ?>" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="turno">Turno:</label>
                    <input type="text" class="formcontrol" id="turno" name="turno" value="<?php echo $funcionTiempo; ?>" readonly>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h2 class="text-right">Estatus</h2>
            </div>
            <div class="col-md-2">
        <form method="POST" action="operadores.php">
            <div class="form-group">
                <label for="pais">Selecciona un país:</label>
                <select class="form-control" id="pais" name="pais" onchange="loadStates()">
                    <option value="Selecciona">Selecciona un país</option>
                    <option value="Mexico">México</option>
                    <option value="Argentina">Argentina</option>
                    <option value="Brasil">Brasil</option>
                    <option value="Chile">Chile</option>
                </select>
            </div>
    </div>
    
    <div class="col-md-2">
        <div class="form-group">
            <label for="entidad">Selecciona un estado:</label>
            <select class="form-control" id="entidad" name="entidad">
                <option value="">Primero selecciona un país</option>
                <!-- Los estados se cargarán dinámicamente aquí -->
            </select>
        </div>
    </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="partido">Partido:</label>
                    <select class="form-control" id="partido" name="partido" required>
                        <option value="">Seleccionar...</option>
                        <option value="PAN">PAN</option>
						<option value="PRI">PRI</option>
						<option value="PRD">PRD</option>
                        <option value="Partido Verde">Partido Verde</option>
						<option value="PT">Partido del Trabajo (PT)</option>
						<option value="PC">Movimiento Ciudadano</option>
                        <option value="Morena">Morena</option>
						<option value="Partido no mexicano">Partido no mexicano</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="coalicion">Ideologia politica:</label>
                    <input type="text" class="form-control" id="coalicion" name="coalicion" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="cliente">Cliente:</label>
                    <input type="text" class="form-control" id="cliente" name="cliente"  required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="identidad_perfil">Gustos personales:</label>
                    <select type="text" class="form-control" id="identidad_perfil" name="identidad_perfil" required>
                        <option value="">Seleccionar...</option>
                        <option value="Estudiante">Anime</option>
                        <option value="Profesor">Arte</option>
                        <option value="Profesional">Musica</option>
                        <option value="Otro">Videojuegos</option>
                        <option value="Investigador">Lectura</option>
                        <option value="Artista">Comida</option>
                        <option value="Empresario">Deportes</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="reaccion">Tipo de reaccion:</label>
                    <select class="form-control" id="reaccion" name="reaccion" required>
                        <option value="">Seleccionar...</option>
                        <option value="positiva">Positiva</option>
                        <option value="negativa">Negativa</option>
                        <option value="adulacion">Adulación</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="nombre_usuario">Nombre de Usuario:</label>
                    <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="usuario">Usuario:</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="contraseña">Contraseña:</label>
                    <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="correo">Correo:</label>
                    <input type="text" class="form-control" id="correo" name="correo" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="telefono">Teléfono:</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" oninput="validarNumeros(this)" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="compañia">Compañía:</label>
                    <input type="text" class="form-control" id="compania" name="compania" onkeyup="convertirAMayusculas(this)" required>
                </div>
            </div>
				<div class="col-md-2">
                <div class="form-group">
                    <label for="correo">ID del CHIP:</label>
                    <input type="text" class="form-control" id="id_chip" name="id_chip" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                    <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="sexo">Sexo:</label>
                     <select class="form-control" id="sexo" name="sexo" required>
                        <option value="">Seleccionar...</option>
                        <option value="Masculina">Masculino</option>
                        <option value="Femenino">Femenino</option>
                        <option value="Indefinido">Indefinido</option>
                    </select>
                </div>
            </div>
			<div class="col-md-2">
				<div class="form-group">
                <br>
                <button type="submit" class="btn btn-primary" id="guardar-btn">Guardar</button>
					</form> <!-- Cerrar el formulario -->
            </div>
        </div>
    </div>
        <div class="col-12">
            <br>
            <form id="searchForm2">
                <h2 class="text-right">Consulta:</h2>
                <input type="text" class="form-control" name="consultar" placeholder="Buscar cliente...">
                <br>
                <input type="submit" value="Buscar">
            </form>
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-white">Usuario</th>
                        <th class="text-white">Partido</th>
                        <th class="text-white">Cliente</th>
						<th>Pais</th>
                        <th class="text-white">Entidad</th>
                        <th>Cuenta</th>
						<th>ID Chip</th>
                        <!-- Add a column for action buttons -->
                    </tr>
                </thead>
                <tbody id="tablaDatosBody">
                    
                    <!-- The data will be added dynamically here -->
                </tbody>
            </table>

        </div>
        <div class="col-12">
            <h2 class="text-right">Datos:</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <form method="POST" action="../configuraciones/formulario.php">
                            <label for="clientes">Cliente:</label>
                            <input type="text" class="form-control" id="clientes" name="clientes"  required>
                    </div>
                </div>
				 <div class="col-md-6">
                <div class="form-group">
                    <label for="paises">Pais:</label>
                    <select class="form-control" id="paises" name="paises" onchange="loadClientStates()" required>
                        <option value="">Seleccionar...</option>
                        <option value="Mexico">México</option>
						<option value="Argentina">Argentina</option>
        				<option value="Brasil">Brasil</option>
        				<option value="Chile">Chile</option>
                    </select>
                </div>
            </div>
                <div class="col-md-6">
                    <div class="form-group">
						<label for="estado">Selecciona un estado:</label>
						<select class="form-control" id="estado" name="estado">
							<option value="">Primero selecciona un país</option>
							<!-- Los estados se cargarán dinámicamente aquí -->
						</select>
					</div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="publica">Publicación:</label>
                        <input type="text" class="form-control" id="publica" name="publica" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="links">Link:</label>
                        <input type="text" class="form-control" id="links" name="links" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fecha_publicacion">Fecha de Publicación:</label>
                        <input type="date" class="form-control" id="fecha_publicacion" name="fecha_publicacion" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="enfoque">Enfoque:</label>
                        <input type="text" class="form-control" id="enfoque" name="enfoque" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="likes">Likes:</label>
                        <input type="text" class="form-control" id="likes" name="likes" oninput="validarNumeros(this)" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="comentarios">Comentarios:</label>
                        <input type="text" class="form-control" id="comentarios" name="comentarios" oninput="validarNumeros(this)" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="rt">RT:</label>
                        <input type="text" class="form-control" id="rt" name="rt" oninput="validarNumeros(this)" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Guardar</button>
						</form>
                    </div>
                </div>
            </div>
        </div>
                <div class="col-12">
                    <h2 class="text-right">Respuestas</h2>
                </div>
                <div class="col-12">
                    <table class="table">
                        <!-- Contenido de la tabla 2 -->
                        <thead>
                            <tr>
                                <th>Operador</th>
                                <th>Turno</th>
                                <th class="text-white">Cliente</th>
								<th class="text-white">Pais</th>
                                <th class="text-white">Estado</th>
                                <th class="text-white">Publicacion</th>
                                <th class="text-white">Link</th>
                                <th class="text-white">Fecha</th>
                                <th class="text-white">Enfoque</th>
                                <th class="text-white">Likes</th>
                                <th class="text-white">Comentarios</th>
                                <th class="text-white">RT</th>
                            </tr>
                        </thead>
                        <tbody id="tablaDatosBodyas">
                            <?php
                            // Recorre los resultados de la consulta y agrega los datos a la tabla
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td class=\"text-white\">" . $row["operador"] . "</td>";
                                    echo "<td class=\"text-white\">" . $row["turno"] . "</td>";
                                    echo "<td class=\"text-white\">" . $row["clientes"] . "</td>";
									echo "<td class=\"text-white\">" . $row["paises"] . "</td>";
                                    echo "<td class=\"text-white\">" . $row["estado"] . "</td>";
                                    echo "<td class=\"text-white\">" . $row["publica"] . "</td>";
                                    echo "<td><button onclick=\"copyTextAndRedirect('" . $row["links"] . "')\">Copiar</button></td>";
                                    echo "<td class=\"text-white\">" . $row["fecha_publicacion"] . "</td>";
                                    echo "<td class=\"text-white\">" . $row["enfoque"] . "</td>";
                                    echo "<td class=\"text-white\">" . $row["likes"] . "</td>";
                                    echo "<td class=\"text-white\">" . $row["comentarios"] . "</td>";
                                    echo "<td class=\"text-white\">" . $row["rt"] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td class=\"text-white\" colspan=\"8\">No hay datos disponibles</td></tr>";
                            }
                            ?>
                            <!-- Los datos se agregarán dinámicamente aquí -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    <script>
        function copyTextAndRedirect(text, url) {
            const tempInput = document.createElement('input');
            tempInput.value = text;
            document.body.appendChild(tempInput);
            tempInput.select();

            try {
                document.execCommand('copy');
                alert('Texto copiado: ' + text);
            } catch (err) {
                console.error('Error al copiar el texto:', err);
                prompt('Presiona Ctrl+C (Cmd+C en Mac) para copiar el texto:', text);
            }

            document.body.removeChild(tempInput);

            // Open a new tab with the specified URL
            window.open(text, '_blank');
        }



        function validarNumeros(input) {
            input.value = input.value.replace(/\D/g, ''); // Eliminar caracteres que no sean números
        }

        function validarMayusculas(input) {
            input.value = input.value.replace(/[^A-Z]/g, ''); // Eliminar caracteres que no sean letras mayúsculas
        }

        function validarLetras(input) {
            input.value = input.value.replace(/[^A-Za-z]/g, ''); // Eliminar caracteres que no sean letras
        }
		
		 function convertirAMayusculas(input) {
            input.value = input.value.toUpperCase();
        }
    </script>

<script>
        function updateCuenta(selectElement) {
            const newValue = selectElement.value;
            const row = selectElement.parentNode.parentNode;
            const usuario = row.cells[0].innerText;

            // Update the front-end display immediately
            row.cells[4].innerText = newValue;

            // Make a PUT request to update the "cuenta" value in the database
            fetch('../configuraciones/consultass.php', {
                method: 'PUT',
                body: new URLSearchParams({
                    usuario: usuario,
                    cuenta: newValue
                }),
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Check if the update was successful and handle the response as needed
                if (data.success) {
                    console.log(`Cuenta for usuario ${usuario} updated to: ${newValue}`);
                    // Optionally, you can update the front-end display to reflect the change immediately.
                } else if (data.error) {
                    console.error('Error in the update:', data.error);
                }
            })
            .catch(error => {
                console.error('Error in the fetch:', error);
            });
        }

        // Function to save the changes in the database
        function saveChangesForRow(buttonElement) {
        const row = buttonElement.parentNode.parentNode;
        const usuario = row.cells[0].innerText;
        const cuentaElement = row.cells[4].querySelector('select[name="cuenta"]');

        // Check if the 'select' element is found before accessing its value
        if (cuentaElement) {
            const cuenta = cuentaElement.value;

            // Update the front-end display immediately
            row.cells[4].innerText = cuenta;

            // Make a PUT request to update the "cuenta" value in the database
            fetch('../configuraciones/consultass.php', {
                method: 'PUT',
                body: new URLSearchParams({
                    usuario: usuario,
                    cuenta: cuenta
                }),
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Check if the update was successful and handle the response as needed
                if (data.success) {
                    console.log(`Cuenta for usuario ${usuario} updated to: ${cuenta}`);
                    // Optionally, you can update the front-end display to reflect the change immediately.
                } else if (data.error) {
                    console.error('Error in the update:', data.error);
                }
            })
            .catch(error => {
                console.error('Error in the fetch:', error);
            });
        } else {
            console.error("Select element not found in the row.");
        }
    }

    // Add event listeners to each "Save" button
    const saveButtons = document.querySelectorAll('button[data-action="save"]');
    saveButtons.forEach(button => {
        button.addEventListener('click', function () {
            saveChangesForRow(this);
        });
    });


        // Load initial data when the page is loaded
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById('searchForm2').addEventListener('submit', function (event) {
                event.preventDefault();
                const searchTerm = document.querySelector('input[name="consultar"]').value;

                fetch('../configuraciones/consultass.php', {
                    method: 'POST',
                    body: new URLSearchParams({
                        consulta: searchTerm
                    }),
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    const tablaDatosBody = document.getElementById('tablaDatosBody');
                    tablaDatosBody.innerHTML = ''; // Clear current content of the table

                    if (Array.isArray(data)) {
                        // If the response is an array, populate the table with the data
                        data.forEach(result => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${result.usuario}</td>
                                <td>${result.partido}</td>
                                <td>${result.cliente}</td>
								<td>${result.pais}</td>
                                <td>${result.entidad}</td>
                                <td>
                                    <select class="form-control" name="cuenta" onchange="updateCuenta(this)">
                                        <option value="Nueva" ${result.cuenta === 'Nueva' ? 'selected' : ''}>Nueva</option>
                                        <option value="Activa" ${result.cuenta === 'Activa' ? 'selected' : ''}>Activa</option>
                                        <option value="Bloqueada" ${result.cuenta === 'Bloqueada' ? 'selected' : ''}>Bloqueada</option>
                                        <option value="Apelacion" ${result.cuenta === 'Apelacion' ? 'selected' : ''}>Apelacion</option>
                                    </select>
                                </td>
							<td>${result.id_chip}</td>
                            `;
                            tablaDatosBody.appendChild(row);
                        });
                    } else if (data.error) {
                        // If the response contains an "error" field, log the error to the console
                        console.error('Error in the fetch:', data.error);
                    }
                })
                .catch(error => {
                    console.error('Error in the fetch:', error);
                });
            });
        });

        // Function to save changes for individual rows
        function saveChangesForRow(rowIndex) {
            const row = document.getElementById(`row-${rowIndex}`);
            if (!row) {
                console.error(`Row with index ${rowIndex} not found.`);
                return;
            }

            const usuario = row.cells[0].innerText;
            const cuentaElement = row.cells[4].querySelector('select[name="cuenta"]');  

            // Check if the 'select' element is found before accessing its value
            if (cuentaElement) {
                const cuenta = cuentaElement.value;

                // Update the front-end display immediately
                row.cells[4].innerText = cuenta;

                // Make a PUT request to update the "cuenta" value in the database
                fetch('../configuraciones/consultass.php', {
                    method: 'PUT',
                    body: new URLSearchParams({
                        usuario: usuario,
                        cuenta: cuenta
                    }),
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Check if the update was successful and handle the response as needed
                    if (data.success) {
                        console.log(`Cuenta for usuario ${usuario} updated to: ${cuenta}`);
                        // Optionally, you can update the front-end display to reflect the change immediately.
                    } else if (data.error) {
                        console.error('Error in the update:', data.error);
                    }
                })
                .catch(error => {
                    console.error('Error in the fetch:', error);
                });
            } else {
                console.error("Select element not found in the row.");
            }
        }

        // Event delegation for handling clicks on "Save" buttons
        document.addEventListener('click', function (event) {
            if (event.target && event.target.dataset.action === 'save') {
                const rowIndex = event.target.dataset.rowIndex;
                saveChangesForRow(rowIndex);
            }
        });
	// Definimos un objeto con los estados de México
const mexicoStates = ["Aguascalientes", "Baja California", "Baja California Sur", "Campeche", "Chiapas", "Chihuahua", "Coahuila", "Colima", "Durango", "Guanajuato", "Guerrero", "Hidalgo", "Jalisco", "México", "Michoacán", "Morelos", "Nayarit", "Nuevo León", "Oaxaca", "Puebla", "Querétaro", "Quintana Roo", "San Luis Potosí", "Sinaloa", "Sonora", "Tabasco", "Tamaulipas", "Tlaxcala", "Veracruz", "Yucatán", "Zacatecas"];

function loadStates() {
    const countrySelect = document.getElementById("pais");
    const stateSelect = document.getElementById("entidad");
    const selectedCountry = countrySelect.value;

    // Limpiamos la lista de estados antes de cargar los nuevos
    stateSelect.innerHTML = '<option value="">Primero selecciona un país</option>';

    if (selectedCountry === "Mexico") {
        // Agregamos cada estado de México como una opción en el select
        mexicoStates.forEach((entidad) => {
            const option = document.createElement("option");
            option.value = entidad;
            option.textContent = entidad;
            stateSelect.appendChild(option);
        });
    } else {
        // Si se selecciona un país diferente a México, mostramos un mensaje especial
        const option = document.createElement("option");
        option.textContent = "Estados que no son de México";
        stateSelect.appendChild(option);
    }
}
	// Función para cargar estados en función del país seleccionado en el formulario de cliente
function loadClientStates() {
    const countrySelect = document.getElementById("paises");
    const stateSelect = document.getElementById("estado");
    const selectedCountry = countrySelect.value;

    stateSelect.innerHTML = '<option value="">Primero selecciona un país</option>';

    if (selectedCountry === "Mexico") {
        mexicoStates.forEach((estado) => {
            const option = document.createElement("option");
            option.value = estado;
            option.textContent = estado;
            stateSelect.appendChild(option);
        });
    } else {
        const option = document.createElement("option");
        option.textContent = "Estados que no son de México";
        stateSelect.appendChild(option);
    }
}

    </script>

    <?php include('../templates/pie.php'); ?>