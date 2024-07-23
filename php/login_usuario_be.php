<?php
session_start();
include 'conexion_be.php';

if (isset($_POST['usuario']) && isset($_POST['contraseña'])) {
    $usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
    $contraseña = mysqli_real_escape_string($conexion, $_POST['contraseña']);
    $contraseña = hash('sha512', $contraseña);

    $validar_login = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario='$usuario' AND contraseña='$contraseña'");

    if (mysqli_num_rows($validar_login) > 0) {
        $_SESSION['usuario'] = $usuario;
        header("location: ../bienvenida.php");
        exit;
    } else {
        echo '<script>
                alert("Usuario no existe o la contraseña es incorrecta, por favor verifique los datos introducidos");
                window.location = "../index.php";
              </script>';
        exit;
    }
} else {
    // Redireccionar si no se enviaron usuario y contraseña
    header("location: ../index.php");
    exit;
}
?>
