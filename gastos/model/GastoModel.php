<?php

require_once 'conexion.php';

class Gasto
{
    private $conexion;

    public function __construct()
    {
        $conexionDB = new DataBase();
        $this->conexion = $conexionDB->getConnection();
    }

    public function insertarGasto($usuario_id, $nombre, $monto, $categoria)
    {
        try {
            // Define la consulta SQL como una variable
            $sql = "INSERT INTO Gasto (usuario_id, categoriagasto_id, nombre, monto, fecha)
                    VALUES (:usuario_id, :categoria, :nombre, :monto, CURDATE())";
    
            // Prepara la consulta
            $stmt = $this->conexion->prepare($sql);
    
            // Asocia los parámetros con sus valores
            $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':monto', $monto, PDO::PARAM_STR);
            $stmt->bindParam(':categoria', $categoria, PDO::PARAM_INT);
    
            // Ejecuta la consulta
            $stmt->execute();
    
            // Mensaje de éxito
            echo "Gasto registrado exitosamente.";
        } catch (PDOException $e) {
            // Manejo de errores
            echo "Error al insertar el gasto: " . $e->getMessage();
        }
    }

        // TODO: debe ser gastos del usuario actual, no todos
        public function obtenerGastos($usuario_id)
        {
            try {
                $stmt = $this->conexion->prepare("SELECT g.gasto_id, cg.nombre AS categoria_nombre, g.nombre AS gasto_nombre, g.monto, g.fecha, g.fecha_hora FROM Gasto g JOIN CategoriaGasto cg ON g.categoriagasto_id = cg.categoriagasto_id WHERE g.usuario_id=:usuario_id ORDER BY g.gasto_id");
                $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
                $stmt->execute();
                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $resultados;
            } catch (PDOException $e) {
                echo "Error al obtener los gastos: " . $e->getMessage();
            }
        }

  

function actualizarGasto($gasto_id, $usuario_id, $categoriagasto_id, $nombre, $monto, $fecha, $conexion) {
    // Verificar si el gasto existe
    $sql = "SELECT COUNT(*) FROM Gasto WHERE gasto_id = ?";
    if ($stmt = $conexion->prepare($sql)) {
        // Enlazar el parámetro
        $stmt->bind_param("i", $gasto_id);
        $stmt->execute();
        $stmt->bind_result($gasto_existente);
        $stmt->fetch();
        $stmt->close();

        if ($gasto_existente == 0) {
            return "No se encontró el gasto con ID {$gasto_id}.";
        }

        // Verificar si el usuario existe
        $sql_usuario = "SELECT COUNT(*) FROM Usuario WHERE usuario_id = ?";
        if ($stmt_usuario = $conexion->prepare($sql_usuario)) {
            $stmt_usuario->bind_param("i", $usuario_id);
            $stmt_usuario->execute();
            $stmt_usuario->bind_result($usuario_existente);
            $stmt_usuario->fetch();
            $stmt_usuario->close();

            if ($usuario_existente == 0) {
                return "No se encontró el usuario con ID {$usuario_id}.";
            }
        }

        // Verificar si la categoría de gasto existe
        $sql_categoria = "SELECT COUNT(*) FROM CategoriaGasto WHERE categoriagasto_id = ?";
        if ($stmt_categoria = $conexion->prepare($sql_categoria)) {
            $stmt_categoria->bind_param("i", $categoriagasto_id);
            $stmt_categoria->execute();
            $stmt_categoria->bind_result($categoria_existente);
            $stmt_categoria->fetch();
            $stmt_categoria->close();

            if ($categoria_existente == 0) {
                return "No se encontró la categoría con ID {$categoriagasto_id}.";
            }
        }

        // Si todo es válido, proceder con la actualización
        $sql_update = "
            UPDATE Gasto
            SET usuario_id = ?, categoriagasto_id = ?, nombre = ?, monto = ?, fecha = ?
            WHERE gasto_id = ?
        ";

        if ($stmt_update = $conexion->prepare($sql_update)) {
            // Enlazar los parámetros
            $stmt_update->bind_param("iisdsi", $usuario_id, $categoriagasto_id, $nombre, $monto, $fecha, $gasto_id);
            
            // Ejecutar la actualización
            $stmt_update->execute();
            $stmt_update->close();

            return "El gasto con ID {$gasto_id} ha sido actualizado exitosamente.";
        } else {
            return "Error al preparar la consulta de actualización.";
        }
    } else {
        return "Error al preparar la consulta para verificar el gasto.";
    }
}

function eliminarGasto($gasto_id) {
    // Verificar si el gasto existe
    $sql = "SELECT COUNT(*) FROM Gasto WHERE gasto_id = ?";
    
    if ($stmt = $conexion->prepare($sql)) {
        // Enlazar el parámetro
        $stmt->bind_param("i", $gasto_id);
        $stmt->execute();
        $stmt->bind_result($gasto_existente);
        $stmt->fetch();
        $stmt->close();

        if ($gasto_existente == 0) {
            return "No se encontró el gasto con ID {$gasto_id}.";
        }

        // Si el gasto existe, proceder a eliminarlo
        $sql_delete = "DELETE FROM Gasto WHERE gasto_id = ?";
        
        if ($stmt_delete = $conexion->prepare($sql_delete)) {
            // Enlazar el parámetro
            $stmt_delete->bind_param("i", $gasto_id);
            
            // Ejecutar la eliminación
            $stmt_delete->execute();
            $stmt_delete->close();
            
            return "El gasto con ID {$gasto_id} ha sido eliminado exitosamente.";
        } else {
            return "Error al preparar la consulta de eliminación.";
        }
    } else {
        return "Error al preparar la consulta para verificar el gasto.";
    }
}
}
