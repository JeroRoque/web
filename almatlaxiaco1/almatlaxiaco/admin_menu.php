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
            width: 100%;
        }
        th, h1 {
            background-color: #B9848C;
        }
        td, th {
            border: solid 1px #7e7c7c;
            padding: 8px;
            text-align: center;
        }
    </style>
    <script>
        function confirmarEliminacion() {
            return confirm("¿Estás seguro de que deseas eliminar este registro?");
        }
    </script>
</head>
<body>

<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "almatlaxiaco ";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
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

// Manejar la edición, guardado y eliminación
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $id = limpiarDatos($_POST['id']);

    if ($_POST['action'] == 'editar') {
        // Preparar y ejecutar la consulta de selección
        $stmt = $conn->prepare("SELECT * FROM menu WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Mostrar el formulario con los datos actuales
            echo "<h2 style='text-align: center;'>Editar menu</h2>";
            echo "<form method='post' style='text-align: center;'>";
            echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
            echo "<label for='codigo'>Código:</label><br>";
            echo "<input type='text' id='codigo' name='codigo' value='" . $row['codigo'] . "'><br>";
            echo "<label for='descripcion'>Descripción:</label><br>";
            echo "<input type='text' id='descripcion' name='descripcion' value='" . $row['descripcion'] . "'><br>";
            echo "<label for='categoria'>Categoría:</label><br>";
            echo "<input type='text' id='categoria' name='categoria' value='" . $row['categoria'] . "'><br>";
            echo "<label for='precio'>Precio:</label><br>";
            echo "<input type='number' id='precio' name='precio' value='" . substr($row['precio'], 1) . "'><br>"; // Remove the dollar sign for input

            echo "<input type='hidden' name='action' value='guardar'>";
            echo "<button type='submit'>Guardar Cambios</button>";
            echo "</form>";
        } else {
            echo "No se encontraron datos para editar.";
        }
        $stmt->close();

    } elseif ($_POST['action'] == 'guardar') {
        $codigo = limpiarDatos($_POST['codigo']);
        $descripcion = limpiarDatos($_POST['descripcion']);
        $categoria = limpiarDatos($_POST['categoria']);
        $precio = "$" . limpiarDatos($_POST['precio']);

        // Preparar y ejecutar la consulta de actualización
        $stmt = $conn->prepare("UPDATE menu SET codigo = ?, descripcion = ?, categoria = ?, precio = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $codigo, $descripcion, $categoria, $precio, $id);
        if ($stmt->execute()) {
            echo "Menú actualizado.";
        } else {
            echo "Error al actualizar el menú: " . $stmt->error;
        }
        $stmt->close();

    } elseif ($_POST['action'] == 'eliminar') {
        // Preparar y ejecutar la consulta de eliminación
        $stmt = $conn->prepare("DELETE FROM menu WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "Menú eliminado correctamente.";
        } else {
            echo "Error al eliminar el menú: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Manejar la inserción de nuevos menús
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['action'])) {
    $codigo = limpiarDatos($_POST['codigo']);
    $descripcion = limpiarDatos($_POST['descripcion']);
    $categoria = limpiarDatos($_POST['categoria']);
    $precio = "$" . limpiarDatos($_POST['precio']);
    
    // Preparar y ejecutar la consulta de inserción
    $stmt = $conn->prepare("INSERT INTO menu (codigo, descripcion, categoria, precio) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $codigo, $descripcion, $categoria, $precio);
    if ($stmt->execute()) {
        echo "Nuevo menú registrado correctamente.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Consultar todos los menús
$sql_select = "SELECT * FROM menu";
$result = $conn->query($sql_select);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr>";
    echo "<th><h1>ID</h1></th>";
    echo "<th><h1>Código</h1></th>";
    echo "<th><h1>Descripción</h1></th>";
    echo "<th><h1>Categoría</h1></th>";
    echo "<th><h1>Precio</h1></th>";
    echo "<th><h1>Acciones</h1></th>";
    echo "</tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><h2>" . $row['id'] . "</h2></td>";
        echo "<td><h2>" . $row['codigo'] . "</h2></td>";
        echo "<td><h2>" . $row['descripcion'] . "</h2></td>";
        echo "<td><h2>" . $row['categoria'] . "</h2></td>";
        echo "<td><h2>" . $row['precio'] . "</h2></td>";
        echo "<td>
                <form method='post' style='display:inline;'>
                    <input type='hidden' name='id' value='" . $row['id'] . "'>
                    <input type='hidden' name='action' value='editar'>
                    <button type='submit'>Editar</button>
                </form>
                <form method='post' style='display:inline;' onsubmit='return confirmarEliminacion();'>
                    <input type='hidden' name='id' value='" . $row['id'] . "'>
                    <input type='hidden' name='action' value='eliminar'>
                    <button type='submit'>Eliminar</button>
                </form>
              </td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No hay menús registrados.";
}

$conn->close();
?>

<a href="menu.html">Volver Atrás</a>

</body>
</html>
