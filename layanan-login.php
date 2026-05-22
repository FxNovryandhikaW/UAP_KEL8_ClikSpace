<?php
session_start();
$sudah_login = isset($_SESSION['id_user']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Layanan - ClickSpace</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
  <div class="logo">ClickSpace</div>

  <nav>
    <?php if ($sudah_login) { ?>
      <a href="home-login.php">Home</a>
    <?php } else { ?>
      <a href="index.html">Home</a>
    <?php } ?>

    <a href="layanan-login.php">Layanan</a>
    <a href="booking-form.php">Booking</a>
    <a href="status.php">Riwayat</a>

    <?php if ($sudah_login) { ?>
      <a href="logout.php" class="btn-login">Logout</a>
    <?php } else { ?>
      <a href="login.php" class="btn-login">Login</a>
    <?php } ?>
  </nav>
</header>

<main>

  <section class="service-hero">
    <div class="service-hero-content">
      <p class="service-label">CLICKSPACE STUDIO</p>
      <h1>Temukan Layanan Foto Terbaik</h1>
      <p>Pilih paket foto sesuai kebutuhanmu, mulai dari self studio sampai prewedding.</p>
    </div>
  </section>

  <section class="section service-list-section">
    <div class="service-heading">
      <div>
        <p class="service-label">DAFTAR LAYANAN</p>
        <h2>Paket Foto ClickSpace</h2>
      </div>
    </div>

    <div class="service-grid">

      <div class="service-card">
        <div class="service-image">
          <img src="images/self studio.jpg" alt="Self Studio">
          <span>Favorit</span>
        </div>

        <div class="service-content">
          <p class="service-location">ClickSpace Studio</p>
          <h3>Self Studio</h3>

          <div class="service-info">
            <span>30 Menit</span>
            <span>2 Orang</span>
            <span>Soft File</span>
          </div>

          <div class="service-bottom">
            <strong>Rp50.000</strong>
            <a href="detail-layanan.php?id=1">Lihat Detail →</a>
          </div>
        </div>
      </div>

      <div class="service-card">
        <div class="service-image">
          <img src="images/foto keluarga.jpg" alt="Foto Keluarga">
          <span>Family</span>
        </div>

        <div class="service-content">
          <p class="service-location">ClickSpace Studio</p>
          <h3>Foto Keluarga</h3>

          <div class="service-info">
            <span>45 Menit</span>
            <span>4-6 Orang</span>
            <span>Soft File</span>
          </div>

          <div class="service-bottom">
            <strong>Rp150.000</strong>
            <a href="detail-layanan.php?id=2">Lihat Detail →</a>
          </div>
        </div>
      </div>

      <div class="service-card">
        <div class="service-image">
          <img src="images/graduation.jpg" alt="Graduation">
          <span>Graduation</span>
        </div>

        <div class="service-content">
          <p class="service-location">ClickSpace Studio</p>
          <h3>Graduation</h3>

          <div class="service-info">
            <span>40 Menit</span>
            <span>1-2 Orang</span>
            <span>Soft File</span>
          </div>

          <div class="service-bottom">
            <strong>Rp100.000</strong>
            <a href="detail-layanan.php?id=3">Lihat Detail →</a>
          </div>
        </div>
      </div>

      <div class="service-card">
        <div class="service-image">
          <img src="images/fotobooth.jpg" alt="Photobooth">
          <span>Event</span>
        </div>

        <div class="service-content">
          <p class="service-location">ClickSpace Studio</p>
          <h3>Photobooth</h3>

          <div class="service-info">
            <span>30 Menit</span>
            <span>Acara</span>
            <span>Cetak Foto</span>
          </div>

          <div class="service-bottom">
            <strong>Rp75.000</strong>
            <a href="detail-layanan.php?id=4">Lihat Detail →</a>
          </div>
        </div>
      </div>

      <div class="service-card">
        <div class="service-image">
          <img src="images/prewed.jpg" alt="Prewedding">
          <span>Couple</span>
        </div>

        <div class="service-content">
          <p class="service-location">ClickSpace Studio</p>
          <h3>Prewedding</h3>

          <div class="service-info">
            <span>90 Menit</span>
            <span>2 Orang</span>
            <span>Editing</span>
          </div>

          <div class="service-bottom">
            <strong>Rp300.000</strong>
            <a href="detail-layanan.php?id=5">Lihat Detail →</a>
          </div>
        </div>
      </div>

      <div class="service-card">
        <div class="service-image">
          <img src="images/studio.jpg" alt="Sewa Studio">
          <span>Studio</span>
        </div>

        <div class="service-content">
          <p class="service-location">ClickSpace Studio</p>
          <h3>Sewa Studio</h3>

          <div class="service-info">
            <span>Per Jam</span>
            <span>Indoor</span>
            <span>Properti</span>
          </div>

          <div class="service-bottom">
            <strong>Rp75.000/jam</strong>
            <a href="detail-layanan.php?id=6">Lihat Detail →</a>
          </div>
        </div>
      </div>

    </div>

    <div class="service-action-center">
      <a href="booking-form.php" class="button service-booking-button">Booking Sekarang</a>
    </div>
  </section>

</main>

<footer>
  <p>© 2026 ClickSpace</p>
</footer>

</body>
</html>
