<?php
session_start();
include "koneksi.php";

$sudah_login = isset($_SESSION['id_user']);

if (!isset($_GET['id'])) {
  header("Location: layanan-login.php");
  exit;
}

$id_layanan = $_GET['id'];

$query = mysqli_query($conn, "SELECT * FROM layanan WHERE id_layanan='$id_layanan'");
$layanan = mysqli_fetch_assoc($query);

if (!$layanan) {
  header("Location: layanan-login.php");
  exit;
}

$data = [
  1 => [
    "gambar" => "images/self studio.jpg",
    "judul" => "Self Studio Package",
    "old" => "Rp75.000",
    "durasi" => "30 Menit",
    "orang" => "2 Orang",
    "fitur" => "Soft File",
    "alasan" => [
      ["Praktis", "Foto mandiri tanpa perlu fotografer."],
      ["Modern", "Konsep studio simple dan kekinian."],
      ["Hemat", "Harga terjangkau untuk kebutuhan foto."]
    ]
  ],
  2 => [
    "gambar" => "images/foto keluarga.jpg",
    "judul" => "Family Photo Package",
    "old" => "Rp200.000",
    "durasi" => "45 Menit",
    "orang" => "4-6 Orang",
    "fitur" => "Soft File",
    "alasan" => [
      ["Keluarga", "Cocok untuk mengabadikan momen bersama keluarga."],
      ["Nyaman", "Sesi foto dibuat santai agar hasil terlihat natural."],
      ["Memorable", "Hasil foto bisa menjadi kenangan keluarga jangka panjang."]
    ]
  ],
  3 => [
    "gambar" => "images/graduation.jpg",
    "judul" => "Graduation Package",
    "old" => "Rp150.000",
    "durasi" => "40 Menit",
    "orang" => "1-2 Orang",
    "fitur" => "Soft File",
    "alasan" => [
      ["Berharga", "Mengabadikan momen kelulusan."],
      ["Rapi", "Hasil foto formal dan elegan."],
      ["Fleksibel", "Bisa sendiri atau berdua."]
    ]
  ],
  4 => [
    "gambar" => "images/fotobooth.jpg",
    "judul" => "Photobooth Package",
    "old" => "Rp100.000",
    "durasi" => "30 Menit",
    "orang" => "Acara",
    "fitur" => "Cetak Foto",
    "alasan" => [
      ["Seru", "Cocok untuk memeriahkan acara."],
      ["Cepat", "Foto bisa langsung dicetak."],
      ["Interaktif", "Tamu bisa berfoto bebas."]
    ]
  ],
  5 => [
    "gambar" => "images/prewed.jpg",
    "judul" => "Prewedding Package",
    "old" => "Rp350.000",
    "durasi" => "90 Menit",
    "orang" => "2 Orang",
    "fitur" => "Editing",
    "alasan" => [
      ["Romantis", "Cocok untuk foto pasangan dengan konsep elegan."],
      ["Konsep", "Foto dapat dibuat sesuai tema pasangan."],
      ["Editing", "Hasil foto mendapat sentuhan editing agar lebih maksimal."]
    ]
  ],
  6 => [
    "gambar" => "images/studio.jpg",
    "judul" => "Studio Rent Package",
    "old" => "Rp100.000",
    "durasi" => "Per Jam",
    "orang" => "Indoor",
    "fitur" => "Properti",
    "alasan" => [
      ["Fleksibel", "Durasi dapat disesuaikan kebutuhan."],
      ["Lengkap", "Studio dilengkapi properti pendukung."],
      ["Nyaman", "Ruang indoor cocok untuk berbagai konsep."]
    ]
  ]
];

$item = $data[$id_layanan];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Detail Layanan - ClickSpace</title>
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
  <section class="detail-wrapper">

    <div class="detail-left">
      <div class="detail-img">
        <img src="<?php echo $item['gambar']; ?>" alt="<?php echo $layanan['nama_layanan']; ?>">
      </div>

      <div class="why-box">
        <h3>Kenapa pilih paket ini?</h3>

        <div class="why-grid">
          <?php foreach ($item['alasan'] as $a) { ?>
            <div class="why-card">
              <h4><?php echo $a[0]; ?></h4>
              <p><?php echo $a[1]; ?></p>
            </div>
          <?php } ?>
        </div>
      </div>

      <a href="layanan-login.php" class="back-detail">← Kembali ke Layanan</a>
    </div>

    <div class="detail-card">
      <p class="category"><?php echo $layanan['nama_layanan']; ?></p>

      <h1><?php echo $item['judul']; ?></h1>

      <p class="old-price"><?php echo $item['old']; ?></p>
      <p class="new-price">Rp<?php echo number_format($layanan['harga'], 0, ',', '.'); ?></p>

      <div class="tags">
        <span><?php echo $item['durasi']; ?></span>
        <span><?php echo $item['orang']; ?></span>
        <span><?php echo $item['fitur']; ?></span>
      </div>

      <div class="detail-text">
        <p>- Durasi sesi foto <?php echo strtolower($item['durasi']); ?>.</p>
        <p>- Cocok untuk kebutuhan foto di ClickSpace Studio.</p>
        <p>- Mendapatkan hasil foto sesuai paket layanan.</p>
        <p>- Konsep foto dapat disesuaikan dengan kebutuhan customer.</p>
      </div>

      <div class="bonus">
        <p><b>Bonus:</b></p>
        <p>- Arahan pose dari tim studio.</p>
        <p>- Background studio pilihan.</p>
        <p>- Hasil foto pilihan.</p>
      </div>

      <div class="studio-info">
        <p>Lokasi Studio: ClickSpace Studio</p>
        <p>Jam Operasional: 10.00 - 20.00 WIB</p>
        <p>Ditangani oleh tim studio ClickSpace</p>
      </div>

      <a href="booking-form.php" class="book-btn">Booking Sekarang</a>
    </div>

  </section>
</main>

<footer>
  <p>© 2026 ClickSpace</p>
</footer>

</body>
</html>
