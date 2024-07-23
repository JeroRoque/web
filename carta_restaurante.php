<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú del Restaurante</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            background-image: url('15.jpg'); /* Ruta de tu imagen de fondo */
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 280vh; /* Ajustado para ocupar toda la altura de la ventana */
            flex-direction: column;
        }
        .menu-container {
            display: flex;
            flex-wrap: wrap;
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 30px rgba(12, 55, 196, 0.705);
            border-radius: 10px;
            max-width: 90%;
            justify-content: space-around;
            margin-bottom: 20px; /* Espacio debajo del contenedor del menú */
        }
        .menu-title {
            text-align: center;
            margin-bottom: 30px;
            color: #df3b7a;
            font-size: 2.5em;
            font-weight: bold;
        }
        .menu-section {
            margin: 10px;
            width: 250px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            background-color: #ffffff;
        }
        .menu-section h2 {
            text-align: center;
            margin: 10px 0;
            color: #333;
            font-size: 1.5em;
            background-color: #f9f9f9;
            padding: 10px;
            border-bottom: 2px solid #e68e1b;
        }
        .menu-section ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .menu-section ul li {
            background-color: #fdfdfd;
            margin: 5px 0;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            box-shadow: 0 0 5px rgba(4, 170, 156, 0.2);
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .menu-section ul li .details {
            flex-grow: 1;
            text-align: center;
            font-weight: bold;
        }
        .menu-section ul li .price {
            margin-top: 5px;
            font-weight: bold;
            color: #e68e1b;
        }
        .menu-section ul li .code {
            margin-top: 5px;
            font-style: italic;
            color: #07ca90;
        }
        .menu-section .images {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 10px;
        }
        .menu-section .images img {
            width: 100%;
            height: auto;
            max-width: 100px; /* Ajusta el tamaño máximo de las imágenes */
            border-radius: 5px;
            object-fit: cover;
            margin: 5px;
            box-shadow: 0 0 5px rgba(160, 4, 4, 0.3);
        }
        .action-buttons, .logout-button-container {
            margin: 20px 0; /* Espacio entre botones */
            display: flex;
            justify-content: center;
            gap: 20px; /* Espacio entre los botones */
        }
        .action-buttons button, .logout-button-container a {
            background-color: #e68e1b;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            text-align: center;
        }
        .action-buttons button:hover, .logout-button-container a:hover {
            background-color: #0d8bdf;
        }
        .form-container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #7e7c7c;
            border-radius: 5px;
            background-color: #f9f9f9;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        input {
            width: calc(100% - 16px); /* Ajusta el ancho para incluir padding */
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #7e7c7c;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            padding: 10px 20px;
            background-color: #B9848C;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            font-weight: bold;
            display: block;
            margin-top: 10px;
            width: 100%;
        }
        button:hover {
            background-color: #a87368;
        }
    </style>
    <script>
        function confirmarEliminacion() {
            return confirm("¿Estás seguro de que deseas eliminar este registro?");
        }
        
        function mostrarFormulario() {
            document.getElementById('add-form').style.display = 'block';
        }

        function editarPlatillo(id, codigo, descripcion, categoria, precio) {
            document.getElementById('id').value = id;
            document.getElementById('codigo').value = codigo;
            document.getElementById('descripcion').value = descripcion;
            document.getElementById('categoria').value = categoria;
            document.getElementById('precio').value = precio;
            document.getElementById('action').value = 'editar';
            document.getElementById('add-form').style.display = 'block';
        }
    </script>
</head>
<body>

<div class="menu-title">La Carta de Hoy</div>

<div class="menu-container">
    <!-- Existing menu items will be displayed here -->
    <?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "restaurantealma";

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

    // Manejar solicitudes POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['action']) && $_POST['action'] == 'agregar') {
            $codigo = limpiarDatos($_POST['codigo']);
            $descripcion = limpiarDatos($_POST['descripcion']);
            $categoria = limpiarDatos($_POST['categoria']);
            $precio = limpiarDatos($_POST['precio']);

            // Asegúrate de que el precio incluye el signo de pesos
            $precio = "$" . $precio;

            $sql_insert = "INSERT INTO menu (codigo, descripcion, categoria, precio) 
                            VALUES ('$codigo', '$descripcion', '$categoria', '$precio')";

            if ($conn->query($sql_insert) === TRUE) {
                echo "<p>Nuevo platillo registrado correctamente.</p>";
            } else {
                echo "<p>Error: " . $sql_insert . "<br>" . $conn->error . "</p>";
            }
        } elseif (isset($_POST['action']) && $_POST['action'] == 'eliminar') {
            $id = limpiarDatos($_POST['id']);
            $delete_query = "DELETE FROM menu WHERE id = $id";
            $delete_result = $conn->query($delete_query);

            if (!$delete_result) {
                echo "<p>Error al eliminar el menú: " . $conn->error . "</p>";
            } else {
                echo "<p>Menú eliminado correctamente.</p>";
            }
        } elseif (isset($_POST['action']) && $_POST['action'] == 'editar') {
            $id = limpiarDatos($_POST['id']);
            $codigo = limpiarDatos($_POST['codigo']);
            $descripcion = limpiarDatos($_POST['descripcion']);
            $categoria = limpiarDatos($_POST['categoria']);
            $precio = limpiarDatos($_POST['precio']);

            // Asegúrate de que el precio incluye el signo de pesos
            $precio = "$" . $precio;

            $sql_update = "UPDATE menu SET codigo='$codigo', descripcion='$descripcion', categoria='$categoria', precio='$precio' WHERE id=$id";

            if ($conn->query($sql_update) === TRUE) {
                echo "<p>Platillo actualizado correctamente.</p>";
            } else {
                echo "<p>Error: " . $sql_update . "<br>" . $conn->error . "</p>";
            }
        }
    }

    // Consulta para obtener todos los menús visibles
    $sql_select = "SELECT * FROM menu";
    $result = $conn->query($sql_select);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='menu-section'>";
            echo "<h2>" . $row['categoria'] . "</h2>";
            echo "<ul>";
            echo "<li><span class='details'>" . $row['descripcion'] . "</span>";
            echo "<span class='price'>" . $row['precio'] . "</span>";
            echo "<span class='code'>" . $row['codigo'] . "</span>";
            echo "<form method='post' style='display:inline;' onsubmit='return confirmarEliminacion();'>";
            echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
            echo "<input type='hidden' name='action' value='eliminar'>";
            echo "<button type='submit'>Eliminar</button>";
            echo "</form>";
            echo "<button onclick=\"editarPlatillo('" . $row['id'] . "', '" . $row['codigo'] . "', '" . $row['descripcion'] . "', '" . $row['categoria'] . "', '" . $row['precio'] . "')\">Editar</button>";
            echo "</li>";
            echo "</ul>";
            echo "</div>";
        }
    } else {
        echo "<p>No hay menús disponibles.</p>";
    }

    $conn->close();
    ?>
</div>

<div class="action-buttons">
    <button onclick="mostrarFormulario()">Agregar Platillo</button>
</div>

<div id="add-form" class="form-container" style="display: none;">
    <h2>Agregar/Editar Platillo</h2>
    <form method="post" action="">
        <input type="hidden" id="id" name="id">
        
        <label for="codigo">Código:</label>
        <input type="text" id="codigo" name="codigo" required>
        
        <label for="descripcion">Descripción:</label>
        <input type="text" id="descripcion" name="descripcion" required>
        
        <label for="categoria">Categoría:</label>
        <input type="text" id="categoria" name="categoria" required>
        
        <label for="precio">Precio:</label>
        <input type="text" id="precio" name="precio" required>
        
        <input type="hidden" id="action" name="action" value="agregar">
        
        <button type="submit">Guardar</button>
    </form>
</div>

<div class="logout-button-container">
    <a href="http://localhost/restaurantealma/restaurantealma/login.html" class="logout-button">Cerrar Sesión</a>
</div>

</body>
</html>
