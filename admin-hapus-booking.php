<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id_user']) || !isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
  header("Location: login.php");
  exit;
}

if (!isset($_GET['id'])) {
  header("Location: admin-booking.php");
  exit;
}

$id_booking = mysqli_real_escape_string($conn, $_GET['id']);

$ambil_booking = mysqli_query($conn, "SELECT * FROM booking WHERE id_booking='$id_booking'");
$booking = mysqli_fetch_assoc($ambil_booking);

if (!$booking) {
  header("Location: admin-booking.php");
  exit;
}

/* Hapus file bukti pembayaran jika filenya ada */
if (!empty($booking['bukti_pembayaran']) && file_exists($booking['bukti_pembayaran'])) {
  unlink($booking['bukti_pembayaran']);
}

/* Hapus data booking dari database */
$query = mysqli_query($conn, "DELETE FROM booking WHERE id_booking='$id_booking'");

if ($query) {
  header("Location: admin-booking.php?deleted=success");
  exit;
} else {
  header("Location: admin-booking.php?deleted=failed");
  exit;
}
?>
