<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="icon" type="image/x-icon" href="/gerenciaweb/favicon/favicon.ico">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Persona</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow-sm" style="max-width: 500px; width: 100%;">
            <h3 class="text-center mb-4">Registro de Datos Personales</h3>
            <form method="POST" action="" class="formulario">
                <?php
                session_start();
                include("../controller/conexion.php");


                if (!isset($_SESSION['usuario_id'])) { //Sesión guardada
                    echo '<div class="alert alert-danger">Debes iniciar sesión para registrar tus datos personales.</div>';
                    exit;
                }

                $usuario_id = $_SESSION['usuario_id'];


                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $nombre = $_POST['nombre'];
                    $apellidos = $_POST['apellidos'];
                    $fecha_nacimiento = $_POST['fecha_nacimiento'];
                    $ocupacion = $_POST['ocupacion'];
                    $ingresos = $_POST['ingresos'];

                    $query = "INSERT INTO persona (usuario_id, nombre, apellidos, fecha_nacimiento, ocupacion, ingresos, fecha_registro) VALUES (?, ?, ?, ?, ?, ?, CURRENT_DATE)";
                    $stmt = $conexion->prepare($query);
                    $stmt->bind_param("issssi", $usuario_id, $nombre, $apellidos, $fecha_nacimiento, $ocupacion, $ingresos);

                    if ($stmt->execute()) {
                        echo '<div class="alert alert-success">Registro de persona exitoso.</div>';
                    } else {
                        echo '<div class="alert alert-danger">Error al registrar la persona.</div>';
                    }
                    $stmt->close();
                }
                ?>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese su nombre"
                        required>
                </div>
                <div class="mb-3">
                    <label for="apellidos" class="form-label">Apellidos</label>
                    <input type="text" class="form-control" id="apellidos" name="apellidos"
                        placeholder="Ingrese sus apellidos" required>
                </div>
                <div class="mb-3">
                    <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                    <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                </div>
                <div class="mb-3">
                    <label for="ocupacion" class="form-label">Ocupación</label>
                    <input type="text" class="form-control" id="ocupacion" name="ocupacion"
                        placeholder="Ingrese su ocupación" required>
                </div>
                <div class="mb-3">
                    <label for="ingresos" class="form-label">Ingresos</label>
                    <input type="number" class="form-control" id="ingresos" name="ingresos"
                        placeholder="Ingrese sus ingresos" required>
                </div>
                <input name="btnregistrar" id="btnregistrar" class="btn btn-primary w-100" type="submit"
                    value="REGISTRAR">
                <div class="text-center mt-3">
                    <small>¿Ya registraste a alguien? <a href="VistaListarPersonas.php">Ver listado aquí</a></small>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>