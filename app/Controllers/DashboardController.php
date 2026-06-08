<?php
class DashboardController {
    private $conn;
    public function __construct() {
        require_once __DIR__ . '/../../../config/database.php';
        $this->conn = $conn;
    }
    public function showDashboard() {
        // Fetch dashboard statistics
        $total_booking = mysqli_fetch_assoc(mysqli_query($this->conn, "SELECT COUNT(*) AS total FROM booking"));
        $total_customer = mysqli_fetch_assoc(mysqli_query($this->conn, "SELECT COUNT(*) AS total FROM users WHERE role='customer'"));
        $total_layanan = mysqli_fetch_assoc(mysqli_query($this->conn, "SELECT COUNT(*) AS total FROM layanan"));
        $total_pendapatan = mysqli_fetch_assoc(mysqli_query($this->conn, "SELECT COALESCE(SUM(total_harga),0) AS total FROM booking WHERE status_booking!='Dibatalkan'"));
        $menunggu = mysqli_fetch_assoc(mysqli_query($this->conn, "SELECT COUNT(*) AS total FROM booking WHERE status_booking='Menunggu Konfirmasi'"));
        $dikonfirmasi = mysqli_fetch_assoc(mysqli_query($this->conn, "SELECT COUNT(*) AS total FROM booking WHERE status_booking='Dikonfirmasi'"));
        $selesai = mysqli_fetch_assoc(mysqli_query($this->conn, "SELECT COUNT(*) AS total FROM booking WHERE status_booking='Selesai'"));
        $dibatalkan = mysqli_fetch_assoc(mysqli_query($this->conn, "SELECT COUNT(*) AS total FROM booking WHERE status_booking='Dibatalkan'"));
        $booking_terbaru = mysqli_query($this->conn, "
            SELECT booking.*, layanan.nama_layanan, users.email
            FROM booking
            JOIN layanan ON booking.id_layanan = layanan.id_layanan
            JOIN users ON booking.id_user = users.id_user
            ORDER BY booking.created_at DESC
            LIMIT 5
        ");
        include __DIR__ . '/../Views/admin_dashboard.php';
    }
    // Additional admin methods can be added here
}
?>
