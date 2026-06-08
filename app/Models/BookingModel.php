<?php
class BookingModel {
    private $conn;
    public function __construct($connection) {
        $this->conn = $connection;
    }
    public function getAllBookings($status = null, $keyword = null) {
        $where = "WHERE 1=1";
        if ($status) {
            $status = $this->conn->real_escape_string($status);
            $where .= " AND booking.status_booking='$status'";
        }
        if ($keyword) {
            $keyword = $this->conn->real_escape_string($keyword);
            $where .= " AND (booking.kode_booking LIKE '%$keyword%' OR booking.nama_customer LIKE '%$keyword%' OR layanan.nama_layanan LIKE '%$keyword%')";
        }
        $sql = "SELECT booking.*, layanan.nama_layanan, users.email
                FROM booking
                JOIN layanan ON booking.id_layanan = layanan.id_layanan
                JOIN users ON booking.id_user = users.id_user
                $where
                ORDER BY booking.created_at DESC";
        return $this->conn->query($sql);
    }
    public function getRecentBookings($limit = 5) {
        $sql = "SELECT booking.*, layanan.nama_layanan, users.email
                FROM booking
                JOIN layanan ON booking.id_layanan = layanan.id_layanan
                JOIN users ON booking.id_user = users.id_user
                ORDER BY booking.created_at DESC
                LIMIT $limit";
        return $this->conn->query($sql);
    }
    // Additional CRUD methods (create, updateStatus, delete) can be added as needed
}
?>
