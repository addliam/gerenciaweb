<?php
session_start();
$_SESSION = array();
session_destroy();
header('Location: /gerenciaweb/persona/view/VistaLogin.php');
exit();
?>