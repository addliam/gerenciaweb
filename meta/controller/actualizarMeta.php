<?php
require_once '../model/metaModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['meta_id'], $_POST['nombre'], $_POST['monto_maximo'], $_POST['categoriagasto_id'], $_POST['plazo'])) {
        $meta_id = $_POST['meta_id'];
        $nombre = $_POST['nombre'];
        $monto_maximo = $_POST['monto_maximo'];
        $categoriagasto_id = $_POST['categoriagasto_id'];
        $plazo = $_POST['plazo'];

        $metaModel = new MetaModel();
        $metaModel->updateMeta($meta_id, $nombre, $monto_maximo, $categoriagasto_id, $plazo);
        $progreso = $metaModel->calcularProgreso($meta_id);
        $metaModel->actualizarEstadoMetas();

        header("Location: ../view/VverListaMetas.php");
        exit();
    } else {
        echo "Error: No se enviaron todos los datos necesarios para actualizar la meta.";
    }
} else {
    echo "Error: Solicitud no válida.";
}
?>
