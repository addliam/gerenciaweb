<?php 

    require_once("../config/conexion.php");
    require_once("../model/Gasto.php");

    // Controlamos las operaciones a través de la operación enviada por el método GET
    switch ($_GET["op"]) {
        
        case 'insertarrr':

            $data = json_decode(file_get_contents("php://input"), true);
    
            // Asignar valores con manejo de vacíos
            $nombreCategoriaAgregar = !empty($data["nombreCategoriaAgregar"]) ? $data["nombreCategoriaAgregar"] : null;
            $descripcionCategoriaAgregar = !empty($data["descripcionCategoriaAgregar"]) ? $data["descripcionCategoriaAgregar"] : null;
    
            // Verificar que el nombre de la categoria no este vacio
            if (empty($nombreCategoriaAgregar)) {
                echo json_encode([
                    "success" => false,
                    "title" => "Error",
                    "message" => "El campo 'nombre' no puede estar vacío."
                ]);
                exit;
            }

            // Instanciar el modelo
            $categoriaModel = new Categoria();
    
            // Llamar a la función de búsqueda flexible
            $resultados = $categoriaModel->insert_categoria($nombreCategoriaAgregar,$descripcionCategoriaAgregar);
            $resultados;

            // Manejar la respuesta del modelo
            if ($resultados["success"] === false) {
                // Error del modelo (por ejemplo, nombre duplicado)
                echo json_encode([
                    "success" => false,
                    "title" => $resultados["title"],
                    "message" => $resultados["message"]
                ]);
            } else {
                // Inserción exitosa
                echo json_encode([
                    "success" => true,
                    "title" => $resultados["title"],
                    "message" => $resultados["message"],
                    "data" => $resultados["data"]
                ]);
            }

        break;

        case "obtenerFechaUltimoGasto":

            $data = json_decode(file_get_contents("php://input"), true);

            // Asignar valores con manejo de vacíos
            $usuario_id = !empty($data["usuario_id"]) ? $data["usuario_id"] : null;
     
            $gastoModel = new Gasto();
    
            // // Llamar a la función de búsqueda flexible
            $resultados = $gastoModel->obtenerFechaUltimoGasto($usuario_id);

            echo json_encode([
                "success" => true,
                "title" => "Obtenido",
                "message" => "Fecha obtenida con exito",
                "data" => $resultados
            ]);
        break;

         

    }
?>
