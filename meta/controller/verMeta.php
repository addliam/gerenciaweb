<?php require_once '../includes/sessionmanager.php' ?>
<?php

$SESSION_USUARIO_ID = $_SESSION['usuario_id'];

require_once 'model/metaModel.php';
$metaModel = new MetaModel();
$metas = $metaModel->getAllMetas($SESSION_USUARIO_ID);
$categoria = $metaModel->getAllCategoriagasto();
require 'view/VverMeta.php';

?>