<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - ClickSpace</title>
    <link rel="stylesheet" href="/css/style.css?v=10">
</head>
<body class="admin-page">
<header>
    <div class="logo">ClickSpace Admin</div>
    <nav>
        <a href="index.php?route=dashboard">Dashboard</a>
        <a href="index.php?route=booking">Data Booking</a>
        <a href="index.php?route=users">Customer</a>
        <a href="index.php?route=layanan">Layanan</a>
        <a href="index.php?route=logout" class="btn-login">Logout</a>
    </nav>
</header>
<main class="admin-main">
    <!-- Content from original admin-dashboard.php (statistics, recent bookings) -->
    <?php
    // The controller already fetched the required data and set variables.
    // Here we just render them.
    ?>
    <section class="admin-hero">
        <div>
            <p>ADMIN PANEL</p>
            <h1>Dashboard ClickSpace</h1>
            <span>Halo, <?php echo htmlspecialchars($_SESSION['nama_lengkap'] ?? 'Admin'); ?>. Kelola data booking studio dari halaman ini.</span>
        </div>
        <a href="index.php?route=booking" class="admin-hero-button">Kelola Booking</a>
    </section>
    <section class="admin-summary-grid">
        <div class="admin-summary-card"><span>Total Booking</span><strong><?php echo $total_booking['total']; ?></strong><p>Semua booking yang masuk</p></div>
        <div class="admin-summary-card"><span>Total Customer</span><strong><?php echo $total_customer['total']; ?></strong><p>Akun customer terdaftar</p></div>
        <div class="admin-summary-card"><span>Total Layanan</span><strong><?php echo $total_layanan['total']; ?></strong><p>Paket layanan tersedia</p></div>
        <div class="admin-summary-card"><span>Pendapatan</span><strong><?php echo rupiah($total_pendapatan['total']); ?></strong><p>Selain booking dibatalkan</p></div>
    </section>
    <section class="admin-status-grid">
        <div class="admin-status-card waiting"><span>Menunggu</span><strong><?php echo $menunggu['total']; ?></strong></div>
        <div class="admin-status-card confirmed"><span>Dikonfirmasi</span><strong><?php echo $dikonfirmasi['total']; ?></strong></div>
        <div class="admin-status-card done"><span>Selesai</span><strong><?php echo $selesai['total']; ?></strong></div>
        <div class="admin-status-card cancelled"><span>Dibatalkan</span><strong><?php echo $dibatalkan['total']; ?></strong></div>
    </section>
    <section class="admin-panel">
        <div class="admin-panel-title">
            <div>
                <p>DATA TERBARU</p>
                <h2>Booking Terbaru</h2>
            </div>
            <a href="index.php?route=booking">Lihat Semua</a>
        </div>
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Customer</th>
                        <th>Layanan</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($booking_terbaru) > 0): ?>
                        <?php while ($booking = mysqli_fetch_assoc($booking_terbaru)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($booking['kode_booking']); ?></td>
                                <td><b><?php echo htmlspecialchars($booking['nama_customer']); ?></b><br><small><?php echo htmlspecialchars($booking['email']); ?></small></td>
                                <td><?php echo htmlspecialchars($booking['nama_layanan']); ?></td>
                                <td><?php echo date('d M Y', strtotime($booking['tanggal_booking'])); ?></td>
                                <td><?php echo rupiah($booking['total_harga']); ?></td>
                                <td><span class="admin-badge"><?php echo htmlspecialchars($booking['status_booking']); ?></span></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="admin-empty">Belum ada data booking.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>
<footer>
    <p>© 2026 ClickSpace</p>
</footer>
<script src="/js/validation.js"></script>
</body>
</html>
