<?php
require_once '../model/CategoriaModel.php';

// class Ccategoria extends Categoria
// {
//     public function actualizarCategoria()
//     {
//             $categoriagasto_id = $_POST['categoriagasto_id'];
//             $nombre = $_POST['nombre'];

//             try {
//                 $this->actualizarCategoriaGasto($categoriagasto_id, $nombre);
//                 echo json_encode(["status" => "success", "message" => "Categoría actualizada exitosamente."]);
//             } catch (Exception $e) {
//                 echo json_encode(["status" => "error", "message" => $e->getMessage()]);
//             }
//     }
// }
// // Instancia el controlador y ejecuta la función
// $categoriaController = new Ccategoria();
// $categoriaController->actualizarCategoria();

echo json_encode(["status" => $nombre, "message" => $categoriagasto_id]);
