<?php
class UsersController {
    private $conn;
    public function __construct() {
        require_once __DIR__ . '/../../../config/database.php';
        $this->conn = $conn;
    }
    public function listUsers() {
        $keyword = isset($_GET['keyword']) ? $this->conn->real_escape_string($_GET['keyword']) : '';
        $where = "WHERE role='customer'";
        if ($keyword !== '') {
            $where .= " AND (nama_lengkap LIKE '%$keyword%' OR email LIKE '%$keyword%' OR no_whatsapp LIKE '%$keyword%')";
        }
        $query_customer = mysqli_query($this->conn, "
            SELECT users.*, COUNT(booking.id_booking) AS total_booking
            FROM users
            LEFT JOIN booking ON users.id_user = booking.id_user
            $where
            GROUP BY users.id_user
            ORDER BY users.created_at DESC
        ");
        // expose variables for view
        include __DIR__ . '/../Views/admin_users.php';
    }
}
?>
