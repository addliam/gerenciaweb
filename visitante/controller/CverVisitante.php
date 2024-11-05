<?php

require 'model/VisitanteModel.php';
$visitanteModel = new VisitanteModel();
$visitantes = $visitanteModel->getAllVisitantes();
require 'view/VverVisitante.php';

?>