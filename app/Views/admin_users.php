<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Customer - ClickSpace Admin</title>
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
    <section class="admin-page-title">
        <div>
            <p>ADMIN PANEL</p>
            <h1>Data Customer</h1>
            <span>Halaman ini menampilkan daftar akun customer yang sudah terdaftar.</span>
        </div>
    </section>
    <section class="admin-filter-card">
        <form method="GET" action="index.php?route=users">
            <input type="text" name="keyword" placeholder="Cari nama, email, atau WhatsApp" value="<?php echo htmlspecialchars($_GET['keyword'] ?? ''); ?>">
            <button type="submit">Cari</button>
            <a href="index.php?route=users">Reset</a>
        </form>
    </section>
    <section class="admin-panel">
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Nama Customer</th>
                        <th>Email</th>
                        <th>No WhatsApp</th>
                        <th>Total Booking</th>
                        <th>Tanggal Daftar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($query_customer) > 0): ?>
                        <?php while ($customer = mysqli_fetch_assoc($query_customer)): ?>
                            <tr>
                                <td><b><?php echo htmlspecialchars($customer['nama_lengkap']); ?></b></td>
                                <td><?php echo htmlspecialchars($customer['email']); ?></td>
                                <td><?php echo htmlspecialchars($customer['no_whatsapp']); ?></td>
                                <td><span class="admin-badge"><?php echo $customer['total_booking']; ?> booking</span></td>
                                <td><?php echo date('d M Y', strtotime($customer['created_at'])); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="admin-empty">Data customer tidak ditemukan.</td></tr>
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
