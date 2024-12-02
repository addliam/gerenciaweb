<?php

header("Content-Type: application/json");

require "../model/conexion.php";
require "../model/GastoModel.php";

$nombreGasto = $_POST["nombre_gasto"] ?? '';
$montoGasto = $_POST["monto_gasto"] ?? '';
$categoriaGasto = $_POST["nombre_categoria"] ?? '';

$gasto = new Gasto();
session_start();
$SESSION_USUARIO_ID = $_SESSION['usuario_id'];
// automatic en controlador
$gasto->insertarGasto($SESSION_USUARIO_ID, $nombreGasto, $montoGasto, $categoriaGasto);

?>