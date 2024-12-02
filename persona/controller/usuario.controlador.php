<?php
include("../controller/conexion.php");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Procesar el formulario de registro
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $contrasena = trim($_POST["contrasena"]);

    // Validar campos vacíos
    if (empty($email) || empty($contrasena)) {
        echo "<div class='alert alert-danger'>Todos los campos son obligatorios.</div>";
    } else {
        // Validar email no exista en la base de datos
        $stmt = $conexion->prepare("SELECT COUNT(*) AS total FROM Usuario WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $fila = $resultado->fetch_assoc();

        if ($fila["total"] > 0) {
            echo "<div class='alert alert-warning'>El correo electrónico ya está registrado.</div>";
        } else {
            // Insertar el nuevo usuario
            $stmt = $conexion->prepare("INSERT INTO Usuario (email, contrasena) VALUES (?, ?)");
            $stmt->bind_param("ss", $email, $contrasena);

            if ($stmt->execute()) {
                echo "<div class='alert alert-success'>Usuario registrado con éxito.</div>";
            } else {
                echo "<div class='alert alert-danger'>Error al registrar el usuario.</div>";
            }
        }

        $stmt->close();
    }
}
$conexion->close();
?>
