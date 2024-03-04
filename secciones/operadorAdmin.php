<?php include('../templates/cabecera.php'); ?>

<?php

ini_set('display_errors', 1); error_reporting(E_ALL);

session_start();
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $admin = $_SESSION['usuario'];



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
?>
        <?php
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
        $conexion = new mysqli("localhost", "root", "", "twitter");

        if ($conexion->connect_error) {
            die("Error en la conexión a la base de datos: " . $conexion->connect_error);
        }

        // Get the counts for each operator
        $sql_operators = "SELECT operador, 
                        SUM(CASE WHEN cuenta = 'Activa' THEN 1 ELSE 0 END) AS activas,
                        SUM(CASE WHEN cuenta = 'Bloqueada' THEN 1 ELSE 0 END) AS bloqueadas,
                        SUM(CASE WHEN cuenta = 'Nueva' THEN 1 ELSE 0 END) AS nuevas,
                        SUM(CASE WHEN cuenta = 'Apelacion' THEN 1 ELSE 0 END) AS apelacion,
                        SUM(CASE WHEN partido = 'PAN' THEN 1 ELSE 0 END) AS partido_pan,
                        SUM(CASE WHEN partido = 'MORENA' THEN 1 ELSE 0 END) AS partido_morena,
                        SUM(CASE WHEN partido = 'PARTIDO VERDE' THEN 1 ELSE 0 END) AS partido_verde
                FROM tabla_estatus
                GROUP BY operador";

        $result_operators = $conexion->query($sql_operators);

        if ($result_operators) {
            // Fetch operator data and store them in an array
            $operators_data = array();
            while ($row = $result_operators->fetch_assoc()) {
                $operators_data[] = $row;
            }
        } else {
            echo "Error al obtener los datos: " . $conexion->error;
        }

        $conexion->close();
        ?>

           <div class="container">
            <div class="row">
                <div class="col-12">
                    <br>
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-white">Activas</th>
                                <th class="text-white">Bloqueadas</th>
                                <th class="text-white col-md-4">Apelación</th>
                                <th class="text-white col-md-3">Turno</th>
                                <th class="text-white">Ejecutivo</th>
                            </tr>
                        </thead>
                        <tbody id="tablaDatosBody">
                            <tr>
                                <td class="text-white"><?php echo $cuentasActivas ?></td>
                                <td class="text-white"><?php echo $cuentasBloqueadas ?></td>
                                <td class="text-white"><?php echo $cuentasApelacion ?></td>
                                <td class="text-white"><?php echo $funcionTiempo ?></td>
                                <td class="text-white"><?php echo $admin ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <h2 class="text-right">Búsqueda</h2>

                </div>
                <div class="col-4">
                    <form method="POST" action="">
                        <input type="text" class="form-control" name="consulta" placeholder="Buscar cliente...">
                        <br>
                        <input type="submit" value="Buscar">
                    </form>
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-white col-5">Cliente</th>
								<th>Pais</th>
                                <th class="text-white col-5">Estado</th>
                                <th>Partido</th>
                            </tr>
                        </thead>
                        <tbody id="tablaDatosBodya">
                            <!-- Los datos se agregarán dinámicamente aquí -->

                        </tbody>
                    </table>
                </div>
                <div class="col-8">
                    <br>
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-white col-2"></th>
                                <th class="text-white col-2">Activas</th>
                                <th class="text-white col-2">Bloqueadas</th>
                                <th class="text-white col-2">Nuevas</th>
                                <th class="text-white col-2">Apelación</th>
                                <th class="text-white col-2">PAN</th>
                                <th class="text-white col-2">Morena</th>
                                <th class="text-white">Partido Verde</th>
                            </tr>
                        </thead>

                        <tbody id="tablaDatosBodyss">
                            <?php
                            // Display data for each operator
                            foreach ($operators_data as $operator_data) {
                                echo '<tr>';
                                echo '<td class="text-white">' . $operator_data['operador'] . '</td>';
                                echo '<td class="text-white">' . $operator_data['activas'] . '</td>';
                                echo '<td class="text-white">' . $operator_data['bloqueadas'] . '</td>';
                                echo '<td class="text-white">' . $operator_data['nuevas'] . '</td>';
                                echo '<td class="text-white">' . $operator_data['apelacion'] . '</td>';
                                echo '<td class="text-white">' . $operator_data['partido_pan'] . '</td>';
                                echo '<td class="text-white">' . $operator_data['partido_morena'] . '</td>';
                                echo '<td class="text-white">' . $operator_data['partido_verde'] . '</td>';
                                echo '</tr>';
                            }
                            ?>
                            <!-- Los datos se agregarán dinámicamente aquí -->
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-5">
                    <h2 class="text-right">Búsqueda 1:</h2>
                    <br>
                    <form id="searchForm2">
                        <input type="text" class="form-control" name="consultar" placeholder="Buscar cliente...">
                        <br>
                        <input type="submit" value="Buscar">
                    </form>
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-white">Clientes</th>
                                <th class="text-white">Fechas</th>
                                <th class="text-white col-md-4">Tweet atendidos</th>
                                <th class="text-white col-md-3">Likes</th>
                                <th class="text-white">Comentarios</th>
                                <th class="text-white">RT</th>
                                <th class="text-white">Etiquetas</th>
                                <th class="text-white">Tweet Generados</th>
                            </tr>
                        </thead>
                        <tbody id="tablaDatosBodys">
                            <!-- Los datos se agregarán dinámicamente aquí -->
                        </tbody>
                    </table>
                </div>
            </div>

        </div>


        <!-- Your HTML form and table -->

<script>
    // Capturar el formulario
    const form = document.querySelector('form');

    // Agregar un evento de escucha para el envío del formulario
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        // Obtener el valor del input de búsqueda
        const searchTerm = form.elements.consulta.value;

        // Realizar la solicitud POST al servidor
        fetch('../configuraciones/consultas.php', {
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
					throw new Error('Error en la solicitud al servidor');
				}
				return response.json();
			})
            .then(data => {
                if (Array.isArray(data)) {
                    // Manipular la tabla con los resultados recibidos
                    const tablaDatosBody = document.getElementById('tablaDatosBodya');
                    tablaDatosBody.innerHTML = ''; // Limpiar contenido actual de la tabla

                    data.forEach(result => {
                        const row = document.createElement('tr');
                        const clienteCell = document.createElement('td');
						const paisCell = document.createElement('td');
                        const estadoCell = document.createElement('td');
                        const partidoCell = document.createElement('td');
                        clienteCell.textContent = result.cliente;
						paisCell.textContent = result.pais;
                        estadoCell.textContent = result.estado;
                        partidoCell.textContent = result.partido;

                        row.appendChild(clienteCell);
						row.appendChild(paisCell);
                        row.appendChild(estadoCell);
                        row.appendChild(partidoCell);
                        tablaDatosBody.appendChild(row);
                    });
                } else if (data.error) {
                    // Handle the error case
                    console.error('Error en la solicitud:', data.error);
                }
            })
            .catch(error => {
                console.error('Error en la solicitud:', error);
            });
    });
</script>


        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById('searchForm2').addEventListener('submit', function(event) {
                    event.preventDefault();
                    const searchTerm = document.querySelector('input[name="consultar"]').value;

                    fetch('../configuraciones/consultar.php', {
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
                            const tablaDatosBody = document.getElementById('tablaDatosBodys');
                            tablaDatosBody.innerHTML = ''; // Clear current content of the table

                            if (Array.isArray(data)) {
                                // If the response is an array, populate the table with the data
                                data.forEach(result => {
                                    const row = document.createElement('tr');
                                    row.innerHTML = `
                <td>${result.clientes}</td>
                <td>${result.fecha_publicacion}</td>
                <td></td>
                <td>${result.likes}</td>
                <td>${result.comentarios}</td>
                <td>${result.rt}</td>
                <td></td>
                <td></td>
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
        </script>


<?php
    } else {
        // Redirigir a otra página o mostrar un mensaje de error
        header("Location: ../secciones/pagina_de_error.php");
        exit; // Importante: añadir 'exit' después de la redirección para evitar que el resto del código se ejecute
    }

    // Move this line to the end, after all database operations are completed.
} else {
    // Redirigir a la página de inicio de sesión si no hay sesión activa
    header("Location: ../index.php");
    exit; // Importante: añadir 'exit' después de la redirección para evitar que el resto del código se ejecute
}
?>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php include('../templates/pie.php'); ?>