<?php 
    session_start();
    require_once("../config/conexion.php");
    require_once("../models/Gasto.php");
    
    // Controlamos las operaciones a través de la operación enviada por el método GET
    switch ($_GET["op"]) {
        case 'obtenerRacha':
        // $data = json_decode(file_get_contents("php://input"), true);
        // $username = $data["username"] ?? "";
        // $password = $data["password"] ?? "";
        
        $gasto = new Gasto();
        // $gast = $gasto->obtenerRachaDeDias($_SESSION['usuario_id']);
        $gast = $gasto->obtenerRachaDeDias($_SESSION["usuario_id"]);


        echo json_encode($gast);



        // echo json_encode([
        //     "success" => false,
        //     "message" => "Por favor, ingresa usuario y contraseña."
        // ]);
        
    
        // case 'guardar':
        //     // Crear o actualizar un usuario
        //     if (empty($_POST["id_usuario"])) {
        //         $usuario->insert_usuario($_POST["nombre"], $_POST["correo"], $_POST["password"], $_POST["rol"]);
        //     } else {
        //         $usuario->update_usuario($_POST["id_usuario"], $_POST["nombre"], $_POST["correo"], $_POST["password"], $_POST["rol"]);
        //     }
        //     break;
    
        // case 'eliminar':
        //     // Eliminar un usuario (ponerlo inactivo)
        //     $usuario->delete_usuario($_POST["id_usuario"]);
        //     break;
    
        // default:
        //     echo "Operación inválida";
        //     break;
    }
    
?>