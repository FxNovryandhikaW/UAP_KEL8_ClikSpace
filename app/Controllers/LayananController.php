<?php
class LayananController {
    private $conn;
    public function __construct() {
        require_once __DIR__ . '/../../../config/database.php';
        $this->conn = $conn;
    }
    public function listLayanan() {
        $query_layanan = mysqli_query($this->conn, "SELECT * FROM layanan ORDER BY id_layanan ASC");
        include __DIR__ . '/../Views/admin_layanan.php';
    }
    // Additional CRUD methods can be added here (add, edit, delete)
}
?>
