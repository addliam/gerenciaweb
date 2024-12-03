<?php
require_once '../includes/sessionmanager.php';
require_once './model/conexion.php';

try {
    // CNX
    $conexionDB = new DataBase();
    $conexion = $conexionDB->getConnection();

    // De sesion
    $usuario_id = $SESSION_USUARIO_ID;

    // 1. DATOS DE GASTOS
    $sql = "SELECT cg.nombre as categoria,
    g.nombre,
    g.monto,
    g.fecha
     FROM gasto g
     JOIN categoriagasto cg ON g.categoriagasto_id = cg.categoriagasto_id
     WHERE usuario_id = :usuario_id
     ORDER BY g.fecha DESC LIMIT 50";

    $stmt = $conexion->prepare($sql);

    $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener resultados
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Convertir resultados a JSON
    $gastos_json = json_encode($resultados);

    if (json_last_error() !== JSON_ERROR_NONE) {
        die("Error al convertir los datos a JSON.");
    }

    // 2. DATOS PERSONALES
    $sql = "SELECT fecha_nacimiento, ocupacion, ingresos 
    FROM Persona 
    WHERE usuario_id = :usuario_id";

    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    $stmt->execute();
    $res2 = $stmt->fetch(PDO::FETCH_ASSOC);
    $datospersonales_json = json_encode($res2);

    if (json_last_error() !== JSON_ERROR_NONE) {
        die("Error al convertir los datos a JSON.");
    }
} catch (PDOException $e) {
    // Manejo de errores
    echo "Error fatal: " . $e->getMessage();
}
?>