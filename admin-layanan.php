<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id_user']) || !isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
  header("Location: login.php");
  exit;
}

function rupiah($angka) {
  return "Rp" . number_format($angka, 0, ',', '.');
}

$query_layanan = mysqli_query($conn, "SELECT * FROM layanan ORDER BY id_layanan ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Layanan - Admin ClickSpace</title>
  <link rel="stylesheet" href="style.css?v=10">
</head>
<body class="admin-page">

<header>
  <div class="logo">ClickSpace Admin</div>

  <nav>
    <a href="admin-dashboard.php">Dashboard</a>
    <a href="admin-booking.php">Data Booking</a>
    <a href="admin-users.php">Customer</a>
    <a href="admin-layanan.php">Layanan</a>
    <a href="logout.php" class="btn-login">Logout</a>
  </nav>
</header>

<main class="admin-main">

  <section class="admin-page-title">
    <div>
      <p>ADMIN PANEL</p>
      <h1>Data Layanan</h1>
      <span>Daftar paket layanan yang tampil pada website ClickSpace.</span>
    </div>
  </section>

  <section class="admin-service-grid">
    <?php while ($layanan = mysqli_fetch_assoc($query_layanan)) { ?>
      <div class="admin-service-card">
        <img src="<?php echo $layanan['gambar']; ?>" alt="<?php echo $layanan['nama_layanan']; ?>">

        <div>
          <span><?php echo $layanan['kategori']; ?></span>
          <h2><?php echo $layanan['nama_layanan']; ?></h2>
          <p><?php echo $layanan['deskripsi']; ?></p>

          <div class="admin-service-meta">
            <small><?php echo $layanan['durasi']; ?></small>
            <small><?php echo $layanan['kapasitas']; ?></small>
            <small><?php echo $layanan['fasilitas']; ?></small>
          </div>

          <strong><?php echo rupiah($layanan['harga']); ?></strong>
        </div>
      </div>
    <?php } ?>
  </section>

</main>

<footer>
  <p>© 2026 ClickSpace</p>
</footer>

</body>
</html>