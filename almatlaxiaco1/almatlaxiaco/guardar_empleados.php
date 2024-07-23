<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta DB</title>
    <style type="text/css">
        table {
            border: solid 2px #7e7c7c;
            border-collapse: collapse;
        }
        th, h1 {
            background-color: #B9848C;
        }
        td, th {
            border: solid 1px #7e7c7c;
            padding: 2px;
            text-align: center;
        }
    </style>
</head>
<body>

<?php
// Conectar a la base de datos (cambiar estos valores por los de tu configuración)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "almatlaxiaco";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

// Función para limpiar datos
function limpiarDatos($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Recibir datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $id = limpiarDatos($_POST['id']);

    if ($_POST['action'] == 'editar') {
        $query = "SELECT * FROM empleados WHERE id = $id";
        $result = mysqli_query($conn, $query);
        if (!$result) {
            die("Error al obtener los datos del empleado: " . mysqli_error($conn));
        }
        $row = mysqli_fetch_assoc($result);
        
        // Mostrar el formulario con los datos actuales
        echo "<h2 style='text-align: center;'>Editar Empleado</h2>";
        echo "<form method='post' style='text-align: center;'>";
        echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
        echo "<label for='nombre'>Nombre:</label><br>";
        echo "<input type='text' id='nombre' name='nombre_completo' value='" . $row['nombre_completo'] . "'><br>";
        echo "<label for='puesto'>Puesto:</label><br>";
        echo "<input type='text' id='puesto' name='puesto' value='" . $row['puesto'] . "'><br>";
        echo "<label for='horario'>Horario de Trabajo:</label><br>";
        echo "<input type='text' id='horario' name='horario_trabajo' value='" . $row['horario_trabajo'] . "'><br>";
        echo "<label for='contacto'>Contacto:</label><br>";
        echo "<input type='text' id='contacto' name='telefono' value='" . $row['telefono'] . "'><br>";
        echo "<label for='salario'>Salario:</label><br>";
        echo "<input type='text' id='salario' name='salario' value='" . $row['salario'] . "'><br>";
        echo "<label for='fecha'>Fecha de Contratación:</label><br>";
        echo "<input type='text' id='fecha' name='fecha_contratacion' value='" . $row['fecha_contratacion'] . "'><br>";
        echo "<input type='hidden' name='action' value='guardar'>";
        echo "<button type='submit'>Guardar Cambios</button>";
        echo "</form>";
    } elseif ($_POST['action'] == 'guardar') {
        $nombre_completo = limpiarDatos($_POST['nombre_completo']);
        $puesto = limpiarDatos($_POST['puesto']);
        $horario_trabajo = limpiarDatos($_POST['horario_trabajo']);
        $telefono = limpiarDatos($_POST['telefono']);
        $salario = limpiarDatos($_POST['salario']);
        $fecha_contratacion = limpiarDatos($_POST['fecha_contratacion']);

        $update_query = "UPDATE empleados SET 
                         nombre_completo = '$nombre_completo', 
                         puesto = '$puesto', 
                         horario_trabajo = '$horario_trabajo', 
                         telefono = '$telefono', 
                         salario = '$salario', 
                         fecha_contratacion = '$fecha_contratacion'
                         WHERE id = $id";

        $update_result = mysqli_query($conn, $update_query);

        if (!$update_result) {
            echo "Error al actualizar el empleado: " . mysqli_error($conn);
        } else {
            echo "Empleado actualizado correctamente.";
        }
    } elseif ($_POST['action'] == 'eliminar') {
        $delete_query = "DELETE FROM empleados WHERE id = $id";
        $delete_result = mysqli_query($conn, $delete_query);

        if (!$delete_result) {
            echo "Error al eliminar el empleado: " . mysqli_error($conn);
        } else {
            echo "Empleado eliminado correctamente.";
        }
    }
}

// Manejar la inserción de nuevos empleados
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['action'])) {
    $nombre_completo = limpiarDatos($_POST['nombre_completo']);
    $puesto = limpiarDatos($_POST['puesto']);
    $horario_trabajo = limpiarDatos($_POST['horario_trabajo']);
    $telefono = limpiarDatos($_POST['telefono']);
    $salario = limpiarDatos($_POST['salario']);
    $fecha_contratacion = limpiarDatos($_POST['fecha_contratacion']);


    // Verificar que el nombre completo no se repita en la base de datos
$verificar_nombre = mysqli_query($conn, "SELECT * FROM empleados WHERE nombre_completo='$nombre_completo'");
if (mysqli_num_rows($verificar_nombre) > 0) {
      echo '
    <script>
    alert("El Nombre completo ya está registrado, intenta con otro diferente");
    window.location = "empleados.html";
    </script>
    ';
    exit();
}

// Verificar que el teléfono no se repita en la base de datos
$verificar_telefono = mysqli_query($conn, "SELECT * FROM empleados WHERE telefono='$telefono'");
if (mysqli_num_rows($verificar_telefono) > 0) {
    echo '
    <script>
    alert("El teléfono ya está registrado, intenta con otro diferente");
    window.location = "empleados.html";
    </script>
    ';
    exit();
}

    $sql_insert = "INSERT INTO empleados (nombre_completo, puesto, horario_trabajo, telefono, salario, fecha_contratacion) 
                   VALUES ('$nombre_completo', '$puesto', '$horario_trabajo', '$telefono', '$salario', '$fecha_contratacion')";

    if ($conn->query($sql_insert) === TRUE) {
        echo "Nuevo empleado registrado correctamente.";
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}

// Consulta para obtener todos los empleados
$sql_select = "SELECT * FROM empleados";
$result = $conn->query($sql_select);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr>";
    echo "<th><h1>ID</h1></th>";
    echo "<th><h1>Nombre Completo</h1></th>";
    echo "<th><h1>Puesto</h1></th>";
    echo "<th><h1>Horario de Trabajo</h1></th>";
    echo "<th><h1>Teléfono</h1></th>";
    echo "<th><h1>Salario</h1></th>";
    echo "<th><h1>Fecha de Contratación</h1></th>";
    echo "<th><h1>Acciones</h1></th>";
    echo "</tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><h2>" . $row['id'] . "</h2></td>";
        echo "<td><h2>" . $row['nombre_completo'] . "</h2></td>";
        echo "<td><h2>" . $row['puesto'] . "</h2></td>";
        echo "<td><h2>" . $row['horario_trabajo'] . "</h2></td>";
        echo "<td><h2>" . $row['telefono'] . "</h2></td>";
        echo "<td><h2>$" . $row['salario'] . "</h2></td>";
        echo "<td><h2>" . $row['fecha_contratacion'] . "</h2></td>";
        echo "<td>
                <form method='post' style='display:inline;'>
                    <input type='hidden' name='id' value='" . $row['id'] . "'>
                    <input type='hidden' name='action' value='editar'>
                    <button type='submit'>Editar</button>
                </form>
                <form method='post' style='display:inline;'>
                    <input type='hidden' name='id' value='" . $row['id'] . "'>
                    <input type='hidden' name='action' value='eliminar'>
                    <button type='submit'>Eliminar</button>
                </form>
              </td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No hay empleados registrados.";
}




$conn->close();
?>

<a href="empleados.html">Volver Atrás</a>

</body>
</html>
