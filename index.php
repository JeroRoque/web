<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y Register</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <main>
        <div class="contenedor__todo">
            <div class="caja__trasera">
                <div class="caja__trasera-login">
                    <h3>¿Ya tienes una cuenta?</h3>
                    <p>Inicia sesión para entrar en la página</p>
                    <button id="btn__iniciar-sesion">Iniciar Sesión</button>
                </div>
                <div class="caja__trasera-register">
                    <h3>¿Aún no tienes una cuenta?</h3>
                    <p>Regístrate para que puedas iniciar sesión</p>
                    <button id="btn__registrarse">Regístrarse</button>
                </div>
            </div>

            <!-- Formulario de Login y registro -->
            <div class="contenedor__login-register">
                <!-- Login -->
                <form action="php/login_usuario_be.php" method="POST" class="formulario__login">
                    <h2>Iniciar Sesión</h2>
                    <input type="text" placeholder="Usuario" name="usuario" required>
                    <input type="password" placeholder="Contraseña" name="contraseña" required maxlength="10">
                    <center>
                        <button type="submit">Adminstrador</button>
                        <button type="button" onclick="window.location.href='http://localhost/almatlaxiaco1/almatlaxiaco/carta_restaurante.html'">usuario</button>
                    </center>
                </form>

                <!-- Register -->
                <form action="php/registro_usuario_be.php" method="POST" class="formulario__register">
                    <h2>Regístrarse</h2>
                    <input type="text" placeholder="Nombres" name="nombres" pattern="[A-Za-zÑñáéíóúÁÉÍÓÚ\s]+" title="Solo se permiten letras y espacios" oninput="validateNOMBRE(this)" required>
                    <input type="text" placeholder="Apellidos" name="apellidos" pattern="[A-Za-zÑñáéíóúÁÉÍÓÚ\s]+" title="Solo se permiten letras y espacios" oninput="validateNOMBRE(this)" required>
                    <input type="text" placeholder="Dirección" name="direccion" required>
                    <input type="tel" placeholder="Teléfono" name="telefono" pattern="\d{10}" title="Solo se permiten 10 números" maxlength="10" oninput="validateNUMERO(this)" required>
                    <input type="email" placeholder="Correo Electrónico" name="correo_electronico" required>
                    <input type="text" placeholder="Usuario" name="usuario" required>
                    <input type="password" placeholder="Contraseña" name="contraseña" required maxlength="10">
                    <center><button type="submit">Regístrarse</button></center>
                </form>
            </div>
        </div>
    </main>

    <script src="assets/js/script.js"></script>
    <script>
        function validateNOMBRE(input) {
            const value = input.value;
            const newValue = value.replace(/[^a-zA-ZÑñáéíóúÁÉÍÓÚ\s]/g, '');
            if (value !== newValue) {
                input.value = newValue;
            }
        }

        function validateNUMERO(input) {
            const value = input.value;
            const newValue = value.replace(/\D/g, '');
            if (value !== newValue) {
                input.value = newValue;
            }
        }
    </script>
</body>
</html>
