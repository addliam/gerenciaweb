<?php
class VisitanteModel
{
    private $host = 'localhost';
    private $dbname = 'bdseguridad';
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

    public function getAllVisitantes()
    {
        $result = $this->executeQuery("SELECT * FROM visitantes");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function insertVisitante($nombre, $apellido)
    {
        $stmt = $this->conn->prepare("INSERT INTO visitantes (nombre, apellido) VALUES (?, ?)");
        $stmt->bind_param("ss", $nombre, $apellido);
        return $stmt->execute();
    }
}
?>