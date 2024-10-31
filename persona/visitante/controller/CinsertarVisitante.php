<?php
require '../model/VisitanteModel.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];

    $visitanteModel = new VisitanteModel();
    $visitanteModel->insertVisitante($nombre, $apellido);

    header("Location: ../index.php");
    exit();
}
?>