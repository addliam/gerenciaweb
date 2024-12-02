<?php
session_start();
require_once("../config/conexion.php");
require_once("../models/Gasto.php");

// Controlamos las operaciones a través de la operación enviada por el método GET
switch ($_GET["op"]) {
    case 'obtenerRacha':
        // $data = json_decode(file_get_contents("php://input"), true);
        // $username = $data["username"] ?? "";
        // $password = $data["password"] ?? "";

        $gasto = new Gasto();
        // $gast = $gasto->obtenerRachaDeDias($_SESSION['usuario_id']);
        $gast = $gasto->obtenerRachaDeDias($_SESSION["usuario_id"]);


        echo json_encode($gast);

}

?>