<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="icon" type="image/x-icon" href="/gerenciaweb/favicon/favicon.ico">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow-sm" style="max-width: 400px; width: 100%;">
            <h3 class="text-center mb-4">Registro</h3>
            <form method="POST" action="" class="formulario">
                <?php
                include("../controller/conexion.php");
                include("../controller/usuario.controlador.php");
                ?>
                <div class="email">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp"
                        placeholder="Ingrese su correo" required>
                    <div id="emailHelp" class="form-text">Ingresar correo electrónico</div>
                </div>
                <div class="contrasena">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="contrasena"
                        placeholder="Ingrese su contraseña" required>
                </div>
                <div class="mb-3">
                    <label for="repeat_password" class="form-label">Repetir Contraseña</label>
                    <input type="password" class="form-control" id="repeat_password" name="repeat_password"
                        placeholder="Repita su contraseña" required>
                    <div id="passwordHelp" class="form-text text-danger" style="display:none;">Las contraseñas no
                        coinciden.</div>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                    <label class="form-check-label" for="terms">Acepto los términos y condiciones</label>
                </div>
                <input name="btnregistrar" id="btnregistrar" class="btn btn-primary w-100" type="submit"
                    value="REGISTRAR" disabled>
                <div class="text-center mt-3">
                    <small>¿Ya tienes una cuenta? <a href="VistaLogin.php">Inicia sesión aquí</a></small>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN6jIeHz"
        crossorigin="anonymous"></script>
    <script>
        const passwordInput = document.getElementById('password');
        const repeatPasswordInput = document.getElementById('repeat_password');
        const submitButton = document.getElementById('btnregistrar');
        const passwordHelp = document.getElementById('passwordHelp');

        function validateForm() {
            if (passwordInput.value !== repeatPasswordInput.value) {
                passwordHelp.style.display = 'block';
                return false;
            }
            return true;
        }


        function toggleSubmitButton() {
            if (passwordInput.value === repeatPasswordInput.value && passwordInput.value.length > 0) {
                submitButton.disabled = false;
                passwordHelp.style.display = 'none';
            } else {
                submitButton.disabled = true;
                passwordHelp.style.display = 'block';
            }
        }

        passwordInput.addEventListener('input', toggleSubmitButton);
        repeatPasswordInput.addEventListener('input', toggleSubmitButton);
    </script>
</body>

</html>