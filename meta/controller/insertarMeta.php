<?php
require_once '../model/metaModel.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario_id = 1;
    //$usuario_id = $_POST['usuario_id'];
    $nombre = $_POST['nombre'];
    $monto_maximo = $_POST['monto_maximo'];
    $categoriagasto_id = $_POST['categoriagasto_id'];
    $plazo = $_POST['plazo'];

    $metaModel = new MetaModel();
    $metaModel->insertMeta($usuario_id, $nombre, $monto_maximo, $categoriagasto_id, $plazo);
    $metaModel->actualizarEstadoMetas();
    

    header("Location: ../view/VverListaMetas.php");
    exit();
}
/*ALTER TABLE `Meta` 
ADD COLUMN `progreso_actual` DECIMAL(5, 2) DEFAULT 0;

ALTER TABLE Meta
ADD estado ENUM('Alcanzado', 'No Alcanzado') DEFAULT NULL;

UPDATE Meta
SET progreso_actual = (
    SELECT IFNULL(SUM(G.monto), 0) / Meta.monto_maximo * 100
    FROM Gasto G
    WHERE G.categoriagasto_id = Meta.categoriagasto_id
    AND G.usuario_id = Meta.usuario_id
);

*/
?>
