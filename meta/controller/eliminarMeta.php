<?php
require '../model/metaModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $meta_id = $_POST['meta_id'];

    $metaModel = new MetaModel();
    $metaModel->deleteMeta($meta_id);

    header("Location: ../view/VverListaMetas.php");
    exit();
}
?>
