<?php
session_start(); // Iniciar sesión
include("../controller/conexion.php");

if (!empty($_POST['btningresar'])) {
    if (empty($_POST["email"]) || empty($_POST["password"])) {
        echo "LOS CAMPOS ESTÁN VACÍOS";
    } else {
        $email = $_POST["email"];
        $clave = $_POST["password"]; // Contraseña ingresada por el usuario

        // Buscar el usuario por email
        $stmt = $conexion->prepare("SELECT usuario_id, contrasena FROM usuario WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($datos = $resultado->fetch_object()) {
            // Verificar la contraseña ingresada con el hash almacenado
            if (password_verify($clave, $datos->contrasena)) {
                $_SESSION['usuario_id'] = $datos->usuario_id; // Guardar el ID del usuario en la sesión
                // Redirigir a la vista principal
                header("location: ../../gastos/view/VhistorialGastos.php");
                exit;
            } else {
                echo '<div class="alert alert-danger">CREDENCIALES INCORRECTAS</div>';
            }
        } else {
            echo '<div class="alert alert-danger">CREDENCIALES INCORRECTAS</div>';
        }

        $stmt->close();
    }
}
$conexion->close();
?>
