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

$status_filter = isset($_GET['status']) ? mysqli_real_escape_string($conn, $_GET['status']) : '';
$keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($conn, $_GET['keyword']) : '';

$where = "WHERE 1=1";

if ($status_filter != '') {
  $where .= " AND booking.status_booking='$status_filter'";
}

if ($keyword != '') {
  $where .= " AND (
    booking.kode_booking LIKE '%$keyword%' 
    OR booking.nama_customer LIKE '%$keyword%' 
    OR layanan.nama_layanan LIKE '%$keyword%'
  )";
}

$query_booking = mysqli_query($conn, "
  SELECT booking.*, layanan.nama_layanan, users.email
  FROM booking
  JOIN layanan ON booking.id_layanan = layanan.id_layanan
  JOIN users ON booking.id_user = users.id_user
  $where
  ORDER BY booking.created_at DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Booking - Admin ClickSpace</title>
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
      <h1>Data Booking</h1>
      <span>Admin dapat melihat pesanan, mengecek bukti pembayaran, dan mengubah status booking.</span>
    </div>
  </section>

  <?php if (isset($_GET['updated']) && $_GET['updated'] == 'success') { ?>
    <div class="admin-alert success">Status booking berhasil diperbarui.</div>
  <?php } ?>

  <section class="admin-filter-card">
    <form method="GET" action="admin-booking.php">
      <input type="text" name="keyword" placeholder="Cari kode, customer, atau layanan" value="<?php echo htmlspecialchars($keyword); ?>">

      <select name="status">
        <option value="">Semua Status</option>
        <option value="Menunggu Konfirmasi" <?php if ($status_filter == 'Menunggu Konfirmasi') echo 'selected'; ?>>Menunggu Konfirmasi</option>
        <option value="Dikonfirmasi" <?php if ($status_filter == 'Dikonfirmasi') echo 'selected'; ?>>Dikonfirmasi</option>
        <option value="Selesai" <?php if ($status_filter == 'Selesai') echo 'selected'; ?>>Selesai</option>
        <option value="Dibatalkan" <?php if ($status_filter == 'Dibatalkan') echo 'selected'; ?>>Dibatalkan</option>
      </select>

      <button type="submit">Filter</button>
      <a href="admin-booking.php">Reset</a>
    </form>
  </section>

  <section class="admin-panel">
    <div class="admin-table-wrap">
      <table class="admin-table booking-table">
        <thead>
          <tr>
            <th>Kode Booking</th>
            <th>Customer</th>
            <th>Layanan</th>
            <th>Jadwal</th>
            <th>Pembayaran</th>
            <th>Bukti</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>

        <tbody>
          <?php if (mysqli_num_rows($query_booking) > 0) { ?>
            <?php while ($booking = mysqli_fetch_assoc($query_booking)) { ?>
              <tr>
                <td>
                  <b><?php echo $booking['kode_booking']; ?></b><br>
                  <small><?php echo date('d M Y H:i', strtotime($booking['created_at'])); ?></small>
                </td>

                <td>
                  <?php echo $booking['nama_customer']; ?><br>
                  <small><?php echo $booking['no_whatsapp']; ?></small><br>
                  <small><?php echo $booking['email']; ?></small>
                </td>

                <td><?php echo $booking['nama_layanan']; ?></td>

                <td>
                  <?php echo date('d M Y', strtotime($booking['tanggal_booking'])); ?><br>
                  <small><?php echo $booking['jam_booking']; ?></small>
                </td>

                <td>
                  <?php echo $booking['metode_pembayaran']; ?><br>
                  <b><?php echo rupiah($booking['total_harga']); ?></b>
                </td>

                <td>
                  <a href="<?php echo $booking['bukti_pembayaran']; ?>" target="_blank" class="admin-proof-link">Lihat Bukti</a>
                </td>

                <td>
                  <span class="admin-badge"><?php echo $booking['status_booking']; ?></span>
                </td>

                <td>
                  <form class="admin-status-form" action="admin-update-status.php" method="POST">
                    <input type="hidden" name="id_booking" value="<?php echo $booking['id_booking']; ?>">

                    <select name="status_booking">
                      <option value="Menunggu Konfirmasi" <?php if ($booking['status_booking'] == 'Menunggu Konfirmasi') echo 'selected'; ?>>Menunggu Konfirmasi</option>
                      <option value="Dikonfirmasi" <?php if ($booking['status_booking'] == 'Dikonfirmasi') echo 'selected'; ?>>Dikonfirmasi</option>
                      <option value="Selesai" <?php if ($booking['status_booking'] == 'Selesai') echo 'selected'; ?>>Selesai</option>
                      <option value="Dibatalkan" <?php if ($booking['status_booking'] == 'Dibatalkan') echo 'selected'; ?>>Dibatalkan</option>
                    </select>

                    <button type="submit">Update</button>
                  </form>
                </td>
              </tr>
            <?php } ?>
          <?php } else { ?>
            <tr>
              <td colspan="8" class="admin-empty">Data booking tidak ditemukan.</td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </section>

</main>

<footer>
  <p>© 2026 ClickSpace</p>
</footer>

</body>
</html>