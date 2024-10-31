<?php

require_once 'conexion.php';

class Categoria
{
    private $conexion;

    public function __construct()
    {
        $conexionDB = new DataBase();
        $this->conexion = $conexionDB->getConnection();
    }

    public function insertarCategoriaGasto($nombre)
    {
        try {
            $stmt = $this->conexion->prepare("CALL insertar_categoria_gasto(:nombre)");
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->execute();
            // echo "Categoría registrada exitosamente.";
        } catch (PDOException $e) {
            // echo "Error al insertar la categoría: " . $e->getMessage();
        }
    }

    public function obtenerCategorias()
    {
        try {
            $stmt = $this->conexion->prepare("CALL obtener_categorias_gasto()");
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $resultados;
        } catch (PDOException $e) {
            echo "Error al obtener las categorías: " . $e->getMessage();
        }
    }

    public function actualizarCategoriaGasto($categoriagasto_id, $nombre)
    {
        try {
            $stmt = $this->conexion->prepare("CALL actualizar_categoria_gasto(:categoriagasto_id, :nombre)");
            $stmt->bindParam(':categoriagasto_id', $categoriagasto_id, PDO::PARAM_INT);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->execute();
            echo "Categoría actualizada exitosamente.";
        } catch (PDOException $e) {
            echo "Error al actualizar la categoría: " . $e->getMessage();
        }
    }

    public function eliminarCategoriaGasto($categoriagasto_id)
    {
        try {
            $stmt = $this->conexion->prepare("CALL eliminar_categoria_gasto(:categoriagasto_id)");
            $stmt->bindParam(':categoriagasto_id', $categoriagasto_id, PDO::PARAM_INT);
            $stmt->execute();
            echo "Categoría eliminada exitosamente.";
        } catch (PDOException $e) {
            echo "Error al eliminar la categoría: " . $e->getMessage();
        }
    }
}
