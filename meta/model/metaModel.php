<?php
class MetaModel
{
    private $host = 'localhost';
    private $dbname = 'bdgerencia';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Conexión fallida: " . $this->conn->connect_error);
        }
    }

    public function executeQuery($query)
    {
        return $this->conn->query($query);
    }

    public function getAllMetas($usuario_id)
    {
        $query = "
        SELECT Meta.*, CategoriaGasto.nombre as categoria_nombre 
        FROM Meta 
        JOIN CategoriaGasto ON Meta.categoriagasto_id = CategoriaGasto.categoriagasto_id 
        WHERE (Meta.plazo >= CURDATE() OR Meta.progreso_actual >= 100)
        AND Meta.usuario_id = ?
        ORDER BY Meta.meta_id ASC
    ";

        // Preparar la consulta
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            die('Error en la preparación de la consulta: ' . $this->conn->error);
        }

        // Vincular el parámetro
        $stmt->bind_param('i', $usuario_id); // 'i' indica que el parámetro es un entero

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }


    public function getAllCategoriagasto()
    {
        $result = $this->conn->query("SELECT * FROM categoriagasto");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function insertMeta($usuario_id, $nombre, $monto_maximo, $categoriagasto_id, $plazo)
    {
        $gastosQuery = "
            SELECT IFNULL(SUM(monto), 0) AS total_gastos
            FROM Gasto
            WHERE categoriagasto_id = ? AND usuario_id = ?
        ";

        $stmtGastos = $this->conn->prepare($gastosQuery);
        if ($stmtGastos === false) {
            die('Error en la preparación de la consulta de gastos: ' . $this->conn->error);
        }

        $stmtGastos->bind_param("ii", $categoriagasto_id, $usuario_id);
        $stmtGastos->execute();
        $result = $stmtGastos->get_result();
        $row = $result->fetch_assoc();
        $total_gastos = $row['total_gastos'];

        if ($monto_maximo > 0) {
            $progreso_actual = round(($total_gastos / $monto_maximo) * 100, 2);
        } else {
            $progreso_actual = 0;
        }

        $color_progreso = ($progreso_actual > 100) ? 'red' : 'blue';

        $insertMetaQuery = "
            INSERT INTO Meta (usuario_id, nombre, monto_maximo, categoriagasto_id, plazo, progreso_actual)
            VALUES (?, ?, ?, ?, ?, ?)
        ";

        $stmt = $this->conn->prepare($insertMetaQuery);
        if ($stmt === false) {
            die('Error en la preparación de la consulta de inserción: ' . $this->conn->error);
        }

        $stmt->bind_param("isdssi", $usuario_id, $nombre, $monto_maximo, $categoriagasto_id, $plazo, $progreso_actual);

        if (!$stmt->execute()) {
            die('Error en la ejecución de la consulta: ' . $stmt->error);
        } else {
            echo "Registro insertado correctamente con progreso: " . $progreso_actual . "%";
        }

        $meta_id = $stmt->insert_id;
        $updateQuery = "
            UPDATE Meta
            SET progreso_actual = ?
            WHERE meta_id = ?
        ";

        $stmtUpdate = $this->conn->prepare($updateQuery);
        if ($stmtUpdate === false) {
            die('Error en la preparación de la consulta de actualización: ' . $this->conn->error);
        }

        $stmtUpdate->bind_param("di", $progreso_actual, $meta_id);
        $stmtUpdate->execute();

        $stmt->close();
        $stmtGastos->close();
        $stmtUpdate->close();
    }

    public function deleteMeta($meta_id)
    {
        $stmt = $this->conn->prepare("DELETE FROM Meta WHERE meta_id = ?");
        if ($stmt === false) {
            die('Error en la preparación de la consulta: ' . $this->conn->error);
        }
        $stmt->bind_param("i", $meta_id);
        $stmt->execute();
        $stmt->close();
    }

    public function updateMeta($meta_id, $nombre, $monto_maximo, $categoriagasto_id, $plazo)
    {
        $stmt = $this->conn->prepare("UPDATE meta SET nombre = ?, monto_maximo = ?, categoriagasto_id = ?, plazo = ? WHERE meta_id = ?");
        $stmt->bind_param("sdisi", $nombre, $monto_maximo, $categoriagasto_id, $plazo, $meta_id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function calcularProgreso($meta_id)
    {
        $query = "
            SELECT IFNULL(SUM(G.monto), 0) AS total_gastos
            FROM Gasto G
            JOIN Meta M ON G.categoriagasto_id = M.categoriagasto_id
            WHERE M.meta_id = ?
            AND G.usuario_id = M.usuario_id
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $meta_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $total_gastos = $result['total_gastos'] ?? 0;

        $metaQuery = "SELECT monto_maximo FROM Meta WHERE meta_id = ?";
        $metaStmt = $this->conn->prepare($metaQuery);
        $metaStmt->bind_param("i", $meta_id);
        $metaStmt->execute();
        $metaResult = $metaStmt->get_result()->fetch_assoc();
        $monto_maximo = $metaResult['monto_maximo'];

        $progreso = ($monto_maximo > 0) ? ($total_gastos / $monto_maximo) * 100 : 0;

        $updateQuery = "UPDATE Meta SET progreso_actual = ? WHERE meta_id = ?";
        $updateStmt = $this->conn->prepare($updateQuery);
        $updateStmt->bind_param("di", $progreso, $meta_id);
        $updateStmt->execute();

        return $progreso;
    }

    public function actualizarEstadoMetas()
    {
        $query = "
            UPDATE Meta
            SET estado = CASE
                WHEN progreso_actual >= 100 AND CURDATE() <= plazo THEN 'Alcanzado'
                WHEN progreso_actual < 100 AND CURDATE() > plazo THEN 'No Alcanzado'
                ELSE estado
            END
        ";

        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            die('Error al preparar la consulta: ' . $this->conn->error);
        }

        if (!$stmt->execute()) {
            die('Error al ejecutar la consulta: ' . $stmt->error);
        }

        $stmt->close();
    }

    private function updateMetasData()
    {
        // actualizar estados en tabla Meta
        $updateQuery = "
            UPDATE Meta 
            SET estado = 'No Alcanzado' 
            WHERE estado != 'Alcanzado' 
            AND estado != 'No Alcanzado' 
            AND CURDATE() > plazo 
            AND progreso_actual < 100";

        $updateStmt = $this->conn->prepare($updateQuery);
        if ($updateStmt === false) {
            die('Error al preparar la consulta de actualización: ' . $this->conn->error);
        }

        if (!$updateStmt->execute()) {
            die('Error al ejecutar la consulta de actualización: ' . $updateStmt->error);
        }
        $updateStmt->close();

    }
    public function getMetasNoAlcanzadas($usuario_id)
    {
        $this->updateMetasData();
        $query = "
        SELECT * FROM Meta 
        WHERE estado = 'No Alcanzado' 
        AND progreso_actual < 100
        AND usuario_id = ?";
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            die('Error al preparar la consulta: ' . $this->conn->error);
        }

        $stmt->bind_param('i', $usuario_id);
        if (!$stmt->execute()) {
            die('Error al ejecutar la consulta: ' . $stmt->error);
        }

        $result = $stmt->get_result();
        $metas = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();

        return $metas;
    }

}
?>