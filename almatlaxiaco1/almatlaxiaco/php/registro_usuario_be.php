<?php
include 'conexion_be.php';

$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$correo_electronico = $_POST['correo_electronico'];
$usuario = $_POST['usuario'];
$contraseña = $_POST['contraseña'];
$contraseña = hash('sha512', $contraseña);

// Corregir la cadena SQL para la inserción
$query = "INSERT INTO usuarios(nombres, apellidos, direccion, telefono, correo_electronico, usuario, contraseña) 
          VALUES('$nombres', '$apellidos', '$direccion', '$telefono', '$correo_electronico', '$usuario', '$contraseña')";

// Verificar que el teléfono no se repita en la base de datos
$verificar_telefono = mysqli_query($conexion, "SELECT * FROM usuarios WHERE telefono='$telefono'");

if (mysqli_num_rows($verificar_telefono) > 0) {
    echo '
    <script>
    alert("Este teléfono ya está registrado, intenta con otro diferente");
    window.location = "../index.php";
    </script>
    ';
    exit();
}

// Verificar que el correo electrónico no se repita en la base de datos
$verificar_correo_electronico = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo_electronico='$correo_electronico'");

if (mysqli_num_rows($verificar_correo_electronico) > 0) {
    echo '
    <script>
    alert("Este correo ya está registrado, intenta con otro diferente");
    window.location = "../index.php";
    </script>
    ';
    exit();
}

// Verificar que el nombre de usuario no se repita en la base de datos
$verificar_usuario = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario='$usuario'");

if (mysqli_num_rows($verificar_usuario) > 0) {
    echo '
    <script>
    alert("Este usuario ya está registrado, intenta con otro diferente");
    window.location = "../index.php";
    </script>
    ';
    exit();
}

// Ejecutar la consulta de inserción
$ejecutar = mysqli_query($conexion, $query);

if ($ejecutar) {
    echo '
    <script>
    alert("Usuario almacenado exitosamente");
    window.location = "../index.php";
    </script>
    ';
} else {
    echo '
    <script>
    alert("Inténtalo de nuevo, usuario no almacenado ");
    window.location = "../index.php";
    </script>
    ';
}

mysqli_close($conexion);
?>
