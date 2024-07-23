<!--?php
session_start();

if(!isset($_SESSION['usuario'])){
    echo '
    <script>
    alert("Por favor debes iniciar sesión");
    window.location = "index.php";
    </script>
    ';
    session_destroy();
    die();
    
}

session_destroy();
?-->
<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    echo '
    <script>
    alert("Por favor debes iniciar sesión");
    window.location = "index.php";
    </script>
    ';
    session_destroy();
    die();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenida al Restaurante Alma de Tlaxiaco</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url("pri.gif");
            background-color: #330202;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            border: 3px solid rgb(201, 120, 66);
            height: 90vh;
            margin: 0;
            background-image: url("di.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            padding: 20px;
            border-radius: 20px;
            max-width: 50%;
            margin: 20px auto;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.8);
            color: rgb(255, 255, 255);
        }

        .menu-button {
            display: inline-block;
            padding: 15px 25px;
            background-color: rgb(251, 251, 255);
            color: rgb(14, 10, 10);
            text-decoration: none;
            border-radius: 10px;
            margin: 15px 0;
            transition: background-color 0.3s, transform 0.3s;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .menu-button:hover {
            background-color: rgba(58, 161, 11, 0.568);
            transform: scale(1.05);
        }

        img {
    margin-top: 20px;
    border-radius: 40%;
    border: 3px solid rgba(235, 75, 27, 0.986); /* Este borde blanco */
    max-width: 100%;
    height: auto;
}




h1 {
    margin-bottom: 20px;
    font-size: 2.5em;
    color: #fc4007;
    text-shadow: 
        -1px -1px 0 #babd37,  
        1px -1px 0 #87ca1a,
        -1px 1px 0 #2ab5ec,
        1px 1px 0 #000;
}


        .top-menu {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between; /* Cambiado a space-between para dispersar */
            width: 100%;
            background-color: black;
            padding: 10px 0;
            box-sizing: border-box;
            margin-bottom: 20px;
            border-radius: 20px;
        }

        .top-menu a {
            color: rgb(255, 255, 255);
            text-decoration: none;
            font-size: 1.2em;
            transition: color 0.3s;
            margin: 5px 10px;
        }

        .top-menu a:hover {
            color: #ff9800;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2em;
            }

            .menu-button {
                padding: 10px 20px;
                font-size: 1em;
            }

            .top-menu {
                flex-direction: column;
                align-items: center;
            }

            .top-menu a {
                font-size: 1em;
                margin: 5px 5px;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 10px;
                border-width: 1px;
            }

            h1 {
                font-size: 1.5em;
            }

            .top-menu {
                flex-direction: column;
                align-items: center;
                justify-content: space-around; /* Ajustado para dispositivos móviles */
            }

            .top-menu a {
                font-size: 0.9em;
                margin: 5px 0; /* Reducido el margen para dispositivos móviles */
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="top-menu">
            <a href="php/cerrar_sesión.php"🧑> Cerrar sesión</a>
            <a href="http://localhost/almatlaxiaco1/almatlaxiaco/empleados.html">🧑‍💼 Empleados</a>
            <a href="http://localhost/almatlaxiaco/menu.html">📋 Menu</a>
           
            <a href="http://localhost/almatlaxiaco/ventas.html">💸 Ventas</a>
        </div>
        <h1>Restaurante El Alma De Tlaxiaco</h1>
        <img src="LOGO12.jpg" height="200" width="220" alt="Logo"/>
    </div>
</body>
</html>

