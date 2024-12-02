<?php

class Gasto extends DataBase
{

    function obtenerRachaDeDias($usuario_id)
    {

        $conexion = parent::getConnection();

        $query = " SELECT * FROM Gasto WHERE usuario_id = :usuario_id ORDER BY fecha ASC";

        $stmt = $conexion->prepare($query);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();

        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultados;

    }

}

?>