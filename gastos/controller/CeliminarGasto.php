<?php
// Configuración de la base de datos
$host = "localhost";
$dbname = "bdgerencia";
$username = "root";
$password = "";

// Crear conexión
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Error al conectar a la base de datos: " . $e->getMessage()]);
    exit;
}

// Obtener datos de la solicitud
$data = json_decode(file_get_contents("php://input"), true);
$gasto_id = $data["gasto_id"] ?? "";

if (empty($gasto_id)) {
    echo json_encode(["success" => false, "message" => "El ID del gasto es requerido."]);
    exit;
}

// Eliminar registro de la tabla Gasto
try {
    $query = "DELETE FROM Gasto WHERE gasto_id = :gasto_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":gasto_id", $gasto_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Gasto eliminado correctamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "No se pudo eliminar el gasto."]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Error al eliminar el gasto: " . $e->getMessage()]);
}
