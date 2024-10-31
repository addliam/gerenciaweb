<?php

require_once '../model/CategoriaModel.php';

$categoriaModel = new Categoria();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos de la solicitud JSON
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Verificar si se está insertando
    if (isset($data['nombre'])) {
        // Llamar al método para insertar la categoría
        $categoriaModel->insertarCategoriaGasto($data['nombre']);
        echo json_encode(['message' =>$data['nombre']]);
    } else {
        echo json_encode(['message' => 'Datos incompletos.']);
    }
}

// echo json_encode(['message' => 'Datos incompletos.']);


?>
