<?php

class Gasto extends DataBase
{
    // Insertar un nuevo gasto
    public function insertarGasto($usuario_id, $nombre, $monto, $categoria)
    {
        try {
            $conectar = parent::getConnection();
            $sql = "INSERT INTO Gasto (usuario_id, categoriagasto_id, nombre, monto, fecha)
                    VALUES (:usuario_id, :categoria, :nombre, :monto, CURDATE())";

            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':monto', $monto, PDO::PARAM_STR);
            $stmt->bindParam(':categoria', $categoria, PDO::PARAM_INT);

            $stmt->execute();

            return [
                "success" => true,
                "message" => "Gasto registrado exitosamente."
            ];
        } catch (PDOException $e) {
            return [
                "success" => false,
                "message" => "Error al insertar el gasto: " . $e->getMessage()
            ];
        }
    }

    // Obtener los gastos de un usuario
    public function obtenerGastos($usuario_id)
    {
        try {
            $conectar = parent::getConnection();
            $sql = "SELECT g.gasto_id, cg.nombre AS categoria_nombre, g.nombre AS gasto_nombre, g.monto, g.fecha 
                    FROM Gasto g 
                    JOIN CategoriaGasto cg ON g.categoriagasto_id = cg.categoriagasto_id 
                    WHERE g.usuario_id = :usuario_id 
                    ORDER BY g.gasto_id";

            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [
                "success" => false,
                "message" => "Error al obtener los gastos: " . $e->getMessage()
            ];
        }
    }

    // Obtener la fecha del último gasto
    public function obtenerFechaUltimoGasto($usuario_id)
    {
        try {
            $conectar = parent::getConnection();
            $sql = "SELECT MAX(fecha) AS fecha_ultimo_gasto FROM Gasto WHERE usuario_id = :usuario_id";

            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $stmt->execute();

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado['fecha_ultimo_gasto'] ?? null;
        } catch (PDOException $e) {
            return [
                "success" => false,
                "message" => "Error al obtener la fecha del último gasto: " . $e->getMessage()
            ];
        }
    }
}
