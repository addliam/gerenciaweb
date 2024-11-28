<?php
session_start();
$SESSION_USUARIO_ID = $_SESSION['usuario_id'];
if (empty($SESSION_USUARIO_ID)) {
    // La variable usuario_id esta vacia.
    $baseURL = "/gerenciaweb";
    header("Location: $baseURL/persona/view/VistaLogin.php");
    exit();
}
?>