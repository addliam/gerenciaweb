<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-sm" style="max-width: 400px; width: 100%;">
        <h3 class="text-center mb-4">Inicio de Sesión</h3>
        <form method="post" action="">
        <?php
        include("../controller/conexion.php");
        include("../controller/login.controlador.php");
        ?>
    <div class="div">
        
        <label for="exampleInputEmail1" class="form-label">Email</label>
        <input type="email" class="form-control" id="usuario" name="email" aria-describedby="emailHelp" placeholder="Ingrese su correo">
        <div id="emailHelp" class="form-text">Ingresar correo electrónico</div>
    </div>
    <div class="div">
        
        <label for="exampleInputPassword1" class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="input" name="password" placeholder="Ingrese su contraseña">
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Recuérdame</label>
    </div>
    <input name="btningresar" class="btn btn-primary w-100" type="submit" value="INICIAR SESION"></button>
    <div class="text-center mt-3">
            <small>¿No tienes una cuenta? <a href="VistaRegistro.php">Regístrate aquí</a></small>
    </div>
     </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
