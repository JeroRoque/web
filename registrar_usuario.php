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
        th, td {
            border: solid 1px #7e7c7c;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #B9848C;
        }
    </style>
</head>
<body>
    <?php
   
        // Ejemplo de conexión a la base de datos MySQL
$servername = "localhost";
$username = "root";
$password = "";  // Aquí debes poner tu contraseña si la tienes configurada
$dbname = "restaurantealma";

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
        $query = "SELECT * FROM usuarios WHERE id = $id";
        $result = mysqli_query($conn, $query);
        if (!$result) {
            die("Error al obtener los datos de los  usuarios: " . mysqli_error($conn));
        }
        $row = mysqli_fetch_assoc($result);
        
        // Mostrar el formulario con los datos actuales
        echo "<h2 style='text-align: center;'>Editar Empleado</h2>";
        echo "<form method='post' style='text-align: center;'>";
        echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
        
        echo "<label for='nombres'>nombres:</label><br>";
        echo "<input type='text' id='nombres' name='nombres' value='" . $row['nombres'] . "'><br>";
        
        echo "<label for='apellidos'>apellidos:</label><br>";
        echo "<input type='text' id='apellidos' name='apellidos' value='" . $row['apellidos'] . "'><br>";
       
        echo "<label for='direccion'>direccion:</label><br>";
        echo "<input type='text' id='direccion' name='direccion' value='" . $row['direccion'] . "'><br>";
       
        echo "<label for='numero_telefono'>numero_telefono:</label><br>";
        echo "<input type='tel' id='numero_telefono' name='numero_telefono' value='" . $row['numero_telefono'] . "'><br>";
        
        echo "<label for='correo_electronico'>correo_electronico:</label><br>";
        echo "<input type='email' id='correo_electronico' name='correo_electronico' value='" . $row['correo_electronico'] . "'><br>";

        echo "<label for='usuario'>usuario:</label><br>";
        echo "<input type='text' id='usuario' name='usuario' value='" . $row['usuario'] . "'><br>";

        echo " <label for='contraseña'>contraseña:</label><br>";
        echo "<input type='text' id='contraseña' name='contraseña' value='" . $row['contraseña'] . "'><br>";
        
       
        echo "<input type='hidden' name='action' value='guardar'>";
        echo "<button type='submit'>Guardar Cambios</button>";
        echo "</form>";
    } elseif ($_POST['action'] == 'guardar') {
        $nombres = limpiarDatos($_POST['nombres']);
        $apellidos= limpiarDatos($_POST['apellidos']);
        $direccion = limpiarDatos($_POST['direccion']);
        $numero_telefono = limpiarDatos($_POST['numero_telefono']);
        $correo_electronico = isset($_POST['correo_electronico']) ? limpiarDatos($_POST['correo_electronico']) : '';
    
        $usuario = limpiarDatos($_POST['usuario']);
        $contraseña = md5(limpiarDatos($_POST['contraseña']));

        $update_query = "UPDATE usuarios SET 
                         nombres = '$nombres', 
                         	apellidos = '$apellidos', 
                        direccion = '$direccion', 
                         numero_telefono= '$numero_telefono', 
                          correo_electronico = '$correo_electronico',
                         usuario = '$usuario', 
                         contraseña = '$contraseña'
                         WHERE id = $id";

        $update_result = mysqli_query($conn, $update_query);

        if (!$update_result) {
            echo "Error al actualizar el usuario: " . mysqli_error($conn);
        } else {
            echo "USUARIO actualizado correctamente.";
        }
    } elseif ($_POST['action'] == 'eliminar') {
        $delete_query = "DELETE FROM usuarios WHERE id = $id";
        $delete_result = mysqli_query($conn, $delete_query);

        if (!$delete_result) {
            echo "Error al eliminar el Usuario: " . mysqli_error($conn);
        } else {
            echo "usuario eliminado correctamente.";
        }
    }
}

// Manejar la inserción de nuevos empleados
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['action'])) {
    $nombres = limpiarDatos($_POST['nombres']);
    $apellidos= limpiarDatos($_POST['apellidos']);
    $direccion = limpiarDatos($_POST['direccion']);
   $numero_telefono = limpiarDatos($_POST['numero_telefono']);
$correo_electronico = limpiarDatos($_POST['correo_electronico']);

    $usuario = limpiarDatos($_POST['usuario']);
    $contraseña = limpiarDatos($_POST['contraseña']);
    $contraseña_encriptada = password_hash($contraseña, PASSWORD_DEFAULT);
    $sql_insert = "INSERT INTO usuarios (nombres, apellidos, direccion, numero_telefono, correo_electronico, usuario, contraseña) 
    VALUES ('$nombres', '$apellidos', '$direccion', '$numero_telefono', '$correo_electronico', '$usuario', '$contraseña_encriptada')";
    if ($conn->query($sql_insert) === TRUE) {
        echo "Nuevo empleado registrado correctamente.";
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}

// Consulta para obtener todos los empleados
$sql_select = "SELECT * FROM usuarios";
$result = $conn->query($sql_select);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr>";
    echo "<th><h1>ID</h1></th>";
    echo "<th><h1>nombres</h1></th>";
    echo "<th><h1>apellidos</h1></th>";
    echo "<th><h1>direccion</h1></th>";
    echo "<th><h1>numero_telefono</h1></th>";
    echo "<th><h1>correo_electronico</h1></th>";
    echo "<th><h1>usuario</h1></th>";
    echo "<th><h1>contraseña</h1></th>";
    echo "<th><h1>Acciones</h1></th>";
    echo "</tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><h2>" . $row['id'] . "</h2></td>";
        echo "<td><h2>" . $row['nombres'] . "</h2></td>";
        echo "<td><h2>" . $row['apellidos'] . "</h2></td>";
        echo "<td><h2>" . $row['direccion'] . "</h2></td>";
        echo "<td><h2>" . $row['numero_telefono'] . "</h2></td>";
        echo "<td><h2>" . $row['correo_electronico'] . "</h2></td>";
        echo "<td><h2>" . $row['usuario'] . "</h2></td>";
        echo "<td><h2>" . $row['contraseña'] . "</h2></td>";
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
    echo "No hay Usuarios registrados.";
}



$conn->close();
?>

<a href="login.html">Volver Atrás</a>

</body>
</html>
