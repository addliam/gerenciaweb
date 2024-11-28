<?php

require_once 'model/metaModel.php';
$metaModel = new MetaModel();
$metas = $metaModel->getAllMetas();
$categoria = $metaModel->getAllCategoriagasto();
require 'view/VverMeta.php';

?>