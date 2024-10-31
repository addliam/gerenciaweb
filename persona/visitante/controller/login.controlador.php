<?php
session_start(); //iniciar sesión

if (!empty($_POST['btningresar'])) {
    if (empty($_POST["email"]) || empty($_POST["password"])) {
        echo "LOS CAMPOS ESTAN VACIOS";
    } else {
        $email = $_POST["email"];
        $clave = $_POST["password"];

        
        $sql = $conexion->query("SELECT * FROM usuario WHERE email='$email' AND contraseña='$clave'");

        if ($datos = $sql->fetch_object()) {
            
            $_SESSION['usuario_id'] = $datos->usuario_id; 
            header("location:../view/VistaUsuarioReg.php"); 
            exit; 
        } else {
            echo '<div class="alert alert-danger">ACCESS DENEGADO</div>'; 
        }
    }
}
?>
