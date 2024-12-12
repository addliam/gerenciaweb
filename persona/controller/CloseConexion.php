<?php
session_start(); 

session_unset();

// Destruye la sesión
session_destroy();

// Redirige al usuario a la página de inicio de sesión
header("Location: ../../persona/view/VistaLogin.php");
exit();
?>
