<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id_user']) || !isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
  header("Location: login.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header("Location: admin-booking.php");
  exit;
}

$id_booking = mysqli_real_escape_string($conn, $_POST['id_booking']);
$status_booking = mysqli_real_escape_string($conn, $_POST['status_booking']);

$status_diizinkan = array('Menunggu Konfirmasi', 'Dikonfirmasi', 'Selesai', 'Dibatalkan');

if (!in_array($status_booking, $status_diizinkan)) {
  header("Location: admin-booking.php");
  exit;
}

mysqli_query($conn, "UPDATE booking SET status_booking='$status_booking' WHERE id_booking='$id_booking'");

header("Location: admin-booking.php?updated=success");
exit;
?>