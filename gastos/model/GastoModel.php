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
            $stmt = $this->conexion->prepare("CALL insertar_gasto(:usuario_id, :nombre, :monto, :categoria)");
            $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':monto', $monto, PDO::PARAM_STR);
            $stmt->bindParam(':categoria', $categoria, PDO::PARAM_STR);
            $stmt->execute();
            echo "Gasto registrado exitosamente.";
        } catch (PDOException $e) {
            echo "Error al insertar el gasto: " . $e->getMessage();
        }
    }

    // TODO: debe ser gastos del usuario actual, no todos
    public function obtenerGastos($usuario_id)
    {
        try {
            $stmt = $this->conexion->prepare("SELECT g.gasto_id, cg.nombre AS categoria_nombre, g.nombre AS gasto_nombre, g.monto, g.fecha FROM Gasto g JOIN CategoriaGasto cg ON g.categoriagasto_id = cg.categoriagasto_id WHERE g.usuario_id=:usuario_id ORDER BY g.gasto_id");
            $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $resultados;
        } catch (PDOException $e) {
            echo "Error al obtener los gastos: " . $e->getMessage();
        }
    }

    public function actualizarGasto($usuario_id, $nombre, $monto, $categoria)
    {
        try {
            $stmt = $this->conexion->prepare("CALL actualizar_gasto(:usuario_id, :nombre, :monto, :categoria)");
            $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':monto', $monto, PDO::PARAM_STR);
            $stmt->bindParam(':categoria', $categoria, PDO::PARAM_STR);
            $stmt->execute();
            echo "Gasto actualizado exitosamente.";
        } catch (PDOException $e) {
            echo "Error al actualizar el gasto: " . $e->getMessage();
        }
    }

    public function eliminarGasto($gasto_id)
    {
        try {
            $stmt = $this->conexion->prepare("CALL eliminar_gasto(:gasto_id)");
            $stmt->bindParam(':gasto_id', $gasto_id, PDO::PARAM_INT);
            $stmt->execute();
            echo "Gasto eliminado exitosamente.";
        } catch (PDOException $e) {
            echo "Error al eliminar el gasto: " . $e->getMessage();
        }
    }
}
