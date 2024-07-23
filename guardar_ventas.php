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
        $query = "SELECT * FROM ventas WHERE id = $id";
        $result = mysqli_query($conn, $query);
        if (!$result) {
            die("Error al obtener los datos de la venta: " . mysqli_error($conn));
        }
        $row = mysqli_fetch_assoc($result);
        
        // Mostrar el formulario con los datos actuales
        echo "<h2 style='text-align: center;'>Editar venta</h2>";
        echo "<form method='post' style='text-align: center;'>";
        echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
        
        echo "<label for='codigo_menu'>Código de Menú:</label><br>";
        echo "<input type='text' id='codigo_menu' name='codigo_menu' value='" . $row['codigo_menu'] . "'><br>";
        
        echo "<label for='usuario_id'>ID de Usuario:</label><br>";
        echo "<input type='text' id='usuario_id' name='usuario_id' value='" . $row['usuario_id'] . "'><br>";
        
        
        
        echo "<label for='total'>Total:</label><br>";
        echo "<input type='text' id='total' name='total' value='" . $row['total'] . "'><br>";
        
        echo "<input type='hidden' name='action' value='GUARDAR'>";
        echo "<button type='submit'>Guardar Cambios</button>";
        echo "</form>";

    } elseif ($_POST['action'] == 'GUARDAR') {
       
        $codigo_menu = limpiarDatos($_POST['codigo_menu']);
        $usuario_id = limpiarDatos($_POST['usuario_id']);
       
        $total = limpiarDatos($_POST['total']);
       
        $update_query = "UPDATE ventas SET 
                         codigo_menu = '$codigo_menu', 
                         usuario_id = '$usuario_id', 
                    
                         total = '$total' 
                         WHERE id = $id";

        $update_result = mysqli_query($conn, $update_query);

        if (!$update_result) {
            echo "Error al actualizar venta: " . mysqli_error($conn);
        } else {
            echo "Venta actualizada correctamente.";
        }
    } elseif ($_POST['action'] == 'eliminar') {
        $delete_query = "DELETE FROM ventas WHERE id = $id";
        $delete_result = mysqli_query($conn, $delete_query);

        if (!$delete_result) {
            echo "Error al eliminar la venta: " . mysqli_error($conn);
        } else {
            echo "Venta eliminada correctamente.";
        }
    }
}

// Manejar la inserción de nuevas ventas
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['action'])) {

    $codigo_menu = limpiarDatos($_POST['codigo_menu']);
    $usuario_id = limpiarDatos($_POST['usuario_id']);
   
    $total = limpiarDatos($_POST['total']);
    
    $sql_insert = "INSERT INTO ventas (codigo_menu, usuario_id, total) 
                   VALUES ('$codigo_menu', '$usuario_id', '$total')";

    if ($conn->query($sql_insert) === TRUE) {
        echo "Nueva venta registrada correctamente.";
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}

// Consulta para obtener todas las ventas
$sql_select = "SELECT * FROM ventas";
$result = $conn->query($sql_select);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr>";
    echo "<th><h1>ID</h1></th>";
    echo "<th><h1>Código de Menú</h1></th>";
    echo "<th><h1>ID de Usuario</h1></th>";
    
    echo "<th><h1>Total</h1></th>";
    echo "<th><h1>Acciones</h1></th>";
    echo "</tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><h2>" . $row['id'] . "</h2></td>";
        echo "<td><h2>" . $row['codigo_menu'] . "</h2></td>";
        echo "<td><h2>" . $row['usuario_id'] . "</h2></td>";
       
        echo "<td><h2>$" . $row['total'] . "</h2></td>";
        
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
    echo "No hay ventas registradas.";
}

$conn->close();
?>

<a href="ventas.html">Volver Atrás</a>

</body>
</html>
