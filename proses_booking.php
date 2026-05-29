<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id_user'])) {
  header("Location: login.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header("Location: booking-form.php");
  exit;
}

$id_user = $_SESSION['id_user'];

$id_layanan = isset($_POST['id_layanan']) ? mysqli_real_escape_string($conn, $_POST['id_layanan']) : '';
$nama_customer = isset($_POST['nama_customer']) ? mysqli_real_escape_string($conn, trim($_POST['nama_customer'])) : '';
$no_whatsapp = isset($_POST['no_whatsapp']) ? mysqli_real_escape_string($conn, trim($_POST['no_whatsapp'])) : '';
$tanggal_booking = isset($_POST['tanggal_booking']) ? mysqli_real_escape_string($conn, $_POST['tanggal_booking']) : '';
$jam_booking = isset($_POST['jam_booking']) ? mysqli_real_escape_string($conn, $_POST['jam_booking']) : '';
$metode_pembayaran = isset($_POST['metode_pembayaran']) ? mysqli_real_escape_string($conn, $_POST['metode_pembayaran']) : '';

if (
  $id_layanan == '' ||
  $nama_customer == '' ||
  $no_whatsapp == '' ||
  $tanggal_booking == '' ||
  $jam_booking == '' ||
  $metode_pembayaran == ''
) {
  header("Location: booking-form.php?error=empty");
  exit;
}

if (!preg_match('/^[0-9]{10,15}$/', $no_whatsapp)) {
  header("Location: booking-form.php?error=whatsapp");
  exit;
}

$tanggal_hari_ini = date('Y-m-d');

if ($tanggal_booking < $tanggal_hari_ini) {
  header("Location: booking-form.php?error=tanggal");
  exit;
}

$jam_diizinkan = array(
  "09.00 - 10.00",
  "10.00 - 11.00",
  "11.00 - 12.00",
  "13.00 - 14.00",
  "14.00 - 15.00",
  "15.00 - 16.00"
);

if (!in_array($jam_booking, $jam_diizinkan)) {
  header("Location: booking-form.php?error=jam");
  exit;
}

$metode_diizinkan = array(
  "Transfer Bank",
  "DANA",
  "OVO",
  "QRIS"
);

if (!in_array($metode_pembayaran, $metode_diizinkan)) {
  header("Location: booking-form.php?error=pembayaran");
  exit;
}

$ambil_layanan = mysqli_query($conn, "SELECT * FROM layanan WHERE id_layanan='$id_layanan'");
$layanan = mysqli_fetch_assoc($ambil_layanan);

if (!$layanan) {
  header("Location: booking-form.php?error=layanan");
  exit;
}

$total_harga = $layanan['harga'];

/* Cek agar jadwal tidak bentrok */
$cek_jadwal = mysqli_query($conn, "
  SELECT * FROM booking 
  WHERE tanggal_booking='$tanggal_booking'
  AND jam_booking='$jam_booking'
  AND status_booking != 'Dibatalkan'
");

if (mysqli_num_rows($cek_jadwal) > 0) {
  header("Location: booking-form.php?error=jadwal");
  exit;
}

/* Validasi bukti pembayaran */
if (!isset($_FILES['bukti_pembayaran']) || $_FILES['bukti_pembayaran']['name'] == '') {
  header("Location: booking-form.php?error=file");
  exit;
}

$folder_upload = "uploads/";

if (!is_dir($folder_upload)) {
  mkdir($folder_upload, 0777, true);
}

$nama_file = $_FILES['bukti_pembayaran']['name'];
$tmp_file = $_FILES['bukti_pembayaran']['tmp_name'];
$ukuran_file = $_FILES['bukti_pembayaran']['size'];
$error_file = $_FILES['bukti_pembayaran']['error'];
$ekstensi = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

$ekstensi_diizinkan = array("jpg", "jpeg", "png", "pdf");

if ($error_file !== 0) {
  header("Location: booking-form.php?error=file");
  exit;
}

if (!in_array($ekstensi, $ekstensi_diizinkan)) {
  header("Location: booking-form.php?error=format");
  exit;
}

if ($ukuran_file > 2 * 1024 * 1024) {
  header("Location: booking-form.php?error=size");
  exit;
}

$nama_file_baru = "bukti_" . time() . "_" . rand(100, 999) . "." . $ekstensi;
$lokasi_file = $folder_upload . $nama_file_baru;

$upload = move_uploaded_file($tmp_file, $lokasi_file);

if (!$upload) {
  header("Location: booking-form.php?error=upload");
  exit;
}

$kode_booking = "CS" . date("YmdHis");

$query = "INSERT INTO booking 
(kode_booking, id_user, id_layanan, nama_customer, no_whatsapp, tanggal_booking, jam_booking, metode_pembayaran, bukti_pembayaran, total_harga, status_booking)
VALUES
('$kode_booking', '$id_user', '$id_layanan', '$nama_customer', '$no_whatsapp', '$tanggal_booking', '$jam_booking', '$metode_pembayaran', '$lokasi_file', '$total_harga', 'Menunggu Konfirmasi')";

$simpan = mysqli_query($conn, $query);

if ($simpan) {
  header("Location: success.php?kode=" . $kode_booking);
  exit;
} else {
  header("Location: booking-form.php?error=failed");
  exit;
}
?>