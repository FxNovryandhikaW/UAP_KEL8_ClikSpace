<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id_user'])) {
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Booking - ClickSpace</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="booking-gate-page">

<header>
  <div class="logo">ClickSpace</div>
  <nav>
    <a href="index.html">Home</a>
    <a href="layanan-login.php">Layanan</a>
    <a href="booking-form.php">Booking</a>
    <a href="status.php">Riwayat</a>
    <a href="login.php" class="btn-login">Login</a>
  </nav>
</header>

<main class="booking-gate-main">
  <section class="booking-gate-hero">
    <div class="booking-gate-content">
      <h1>Booking Studio Jadi<br>Lebih Mudah</h1>
      <p>
        Untuk melakukan booking studio foto, kamu perlu register atau login terlebih dahulu.
        Setelah masuk, kamu bisa memilih layanan, menentukan jadwal, dan mengisi form booking.
      </p>

      <div class="booking-gate-actions">
        <a href="register.php" class="booking-gate-primary">Register Sekarang</a>
        <a href="login.php" class="booking-gate-secondary">Login di Sini</a>
      </div>
    </div>
  </section>
</main>

</body>
</html>

<?php
  exit;
}

$id_user = $_SESSION['id_user'];

$data_user = mysqli_query($conn, "SELECT * FROM users WHERE id_user='$id_user'");
$user = mysqli_fetch_assoc($data_user);

$data_layanan = mysqli_query($conn, "SELECT * FROM layanan ORDER BY id_layanan ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Form Booking - ClickSpace</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
  <div class="logo">ClickSpace</div>

  <nav>
    <a href="home-login.php">Home</a>
    <a href="layanan-login.php">Layanan</a>
    <a href="booking-form.php">Booking</a>
    <a href="status.php">Riwayat</a>
    <a href="logout.php" class="btn-login">Logout</a>
  </nav>
</header>

<main class="booking-login-main">
  <section class="booking-login-card">

    <div class="booking-login-left">
      <h1>Form Booking Studio</h1>
      <p class="booking-subtitle">
        Lengkapi data booking, pilih layanan, jadwal, dan metode pembayaran.
      </p>

      <form action="proses_booking.php" method="POST" enctype="multipart/form-data">

        <label>Nama Lengkap</label>
        <input type="text" name="nama_customer" placeholder="Masukkan nama lengkap" required>

        <label>No WhatsApp</label>
        <input type="text" name="no_whatsapp" placeholder="Masukkan nomor WhatsApp" required>

        <label>Layanan</label>
        <select name="id_layanan" required>
          <option value="">-- Pilih Layanan --</option>
          <?php while ($layanan = mysqli_fetch_assoc($data_layanan)) { ?>
            <option value="<?php echo $layanan['id_layanan']; ?>">
              <?php echo $layanan['nama_layanan']; ?> - Rp<?php echo number_format($layanan['harga'], 0, ',', '.'); ?>
            </option>
          <?php } ?>
        </select>

        <label>Tanggal</label>
        <input type="date" name="tanggal_booking" required>

        <label>Jam</label>
        <select name="jam_booking" required>
          <option value="">-- Pilih Jam --</option>
          <option value="09.00 - 10.00">09.00 - 10.00</option>
          <option value="10.00 - 11.00">10.00 - 11.00</option>
          <option value="11.00 - 12.00">11.00 - 12.00</option>
          <option value="13.00 - 14.00">13.00 - 14.00</option>
          <option value="14.00 - 15.00">14.00 - 15.00</option>
          <option value="15.00 - 16.00">15.00 - 16.00</option>
        </select>

        <label>Metode Pembayaran</label>
        <select name="metode_pembayaran" required>
          <option value="">-- Pilih Pembayaran --</option>
          <option value="Transfer Bank">Transfer Bank</option>
          <option value="DANA">DANA</option>
          <option value="OVO">OVO</option>
          <option value="QRIS">QRIS</option>
        </select>

        <div class="booking-payment-box">
          <p><b>Transfer Bank:</b> BCA 1234567890 a.n. ClickSpace Studio</p>
          <p><b>DANA:</b> 081234567890 a.n. ClickSpace Studio</p>
          <p><b>OVO:</b> 081234567890 a.n. ClickSpace Studio</p>
          <p><b>QRIS:</b> Tersedia di kasir studio / dikirim melalui WhatsApp admin</p>
        </div>

        <label>Bukti Pembayaran</label>
        <input type="file" name="bukti_pembayaran" accept=".jpg,.jpeg,.png,.pdf" required>

        <button type="submit" class="booking-login-button">Kirim Booking</button>
      </form>
    </div>

    <div class="booking-login-right">
      <img src="images/book.jpg" alt="Booking Studio">

      <div class="booking-image-text">
        <h2>ClickSpace Booking</h2>
        <p>Pilih layanan, tentukan jadwal, lalu upload bukti pembayaran.</p>
      </div>
    </div>

  </section>
</main>

<footer>
  <p>© 2026 ClickSpace</p>
</footer>

</body>
</html>