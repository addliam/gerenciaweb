<?php

header("Content-Type: application/json");

require "../model/conexion.php";
require "../model/GastoModel.php";

$nombreGasto = $_POST["nombre_gasto"] ?? '';
$montoGasto = $_POST["monto_gasto"] ?? '';
$categoriaGasto = $_POST["nombre_categoria"] ?? '';

echo $categoriaGasto;

$gasto = new Gasto();

$gasto->insertarGasto(1, $nombreGasto, $montoGasto, $categoriaGasto);

?>