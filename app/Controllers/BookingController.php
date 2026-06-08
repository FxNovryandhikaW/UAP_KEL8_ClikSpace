<?php
class BookingController {
    private $conn;
    public function __construct() {
        require_once __DIR__ . '/../../../config/database.php';
        $this->conn = $conn;
    }
    public function showForm() {
        include __DIR__ . '/../Views/booking_form.php';
    }
    public function listBookings() {
        include __DIR__ . '/../Views/admin_booking.php';
    }

    // Process booking submission (formerly proses_booking.php)
    public function processBooking(){
        // Ensure POST request
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            header('Location: index.php?route=booking_form');
            exit;
        }
        // Get and sanitize input
        $nama = trim($_POST['nama_customer'] ?? '');
        $whatsapp = trim($_POST['no_whatsapp'] ?? '');
        $id_layanan = (int)($_POST['id_layanan'] ?? 0);
        $tanggal = $_POST['tanggal_booking'] ?? '';
        $jam = $_POST['jam_booking'] ?? '';
        $metode = $_POST['metode_pembayaran'] ?? '';
        $user_id = $_SESSION['id_user'] ?? 0;
        // Basic validation
        if(empty($nama)||empty($whatsapp)||$id_layanan===0||empty($tanggal)||empty($jam)||empty($metode)){
            header('Location: index.php?route=booking_form&error=empty');
            exit;
        }
        // Validate whatsapp number format
        if(!preg_match('/^\d{10,15}$/',$whatsapp)){
            header('Location: index.php?route=booking_form&error=whatsapp');
            exit;
        }
        // Upload bukti pembayaran
        if(!isset($_FILES['bukti_pembayaran']) || $_FILES['bukti_pembayaran']['error'] !== UPLOAD_ERR_OK){
            header('Location: index.php?route=booking_form&error=upload');
            exit;
        }
        $allowed = ['jpg','jpeg','png','pdf'];
        $ext = strtolower(pathinfo($_FILES['bukti_pembayaran']['name'], PATHINFO_EXTENSION));
        if(!in_array($ext,$allowed)){
            header('Location: index.php?route=booking_form&error=format');
            exit;
        }
        if($_FILES['bukti_pembayaran']['size'] > 2*1024*1024){
            header('Location: index.php?route=booking_form&error=size');
            exit;
        }
        $uploadDir = __DIR__ . '/../../../public/uploads/';
        if(!is_dir($uploadDir)){
            mkdir($uploadDir,0755,true);
        }
        $newFileName = uniqid('bukti_').'.'.$ext;
        $destPath = $uploadDir.$newFileName;
        if(!move_uploaded_file($_FILES['bukti_pembayaran']['tmp_name'],$destPath)){
            header('Location: index.php?route=booking_form&error=upload_fail');
            exit;
        }
        // Get harga layanan
        $stmt = $this->conn->prepare('SELECT harga FROM layanan WHERE id_layanan = ?');
        $stmt->bind_param('i',$id_layanan);
        $stmt->execute();
        $res = $stmt->get_result();
        $layanan = $res->fetch_assoc();
        $total_harga = $layanan['harga'];
        // Generate booking code
        $kode_booking = 'BK'.date('YmdHis').$user_id;
        $status = 'Menunggu Konfirmasi';
        $stmt = $this->conn->prepare("INSERT INTO booking (kode_booking, id_user, id_layanan, tanggal_booking, jam_booking, metode_pembayaran, bukti_pembayaran, total_harga, status_booking, created_at) VALUES (?,?,?,?,?,?,?,?,?,NOW())");
        $stmt->bind_param('sissssssd', $kode_booking, $user_id, $id_layanan, $tanggal, $jam, $metode, $newFileName, $total_harga, $status);
        if($stmt->execute()){
            header('Location: index.php?route=booking_form&success=done');
        } else {
            header('Location: index.php?route=booking_form&error=db');
        }
        exit;
    }

    // Additional methods (process, updateStatus, delete) can be added here
}
?>
