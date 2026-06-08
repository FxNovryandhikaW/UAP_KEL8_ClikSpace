<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Layanan - ClickSpace Admin</title>
    <link rel="stylesheet" href="/css/style.css?v=70">
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
            <h1>Data Layanan</h1>
            <span>Admin dapat menambah, melihat, mengedit, dan menghapus layanan ClickSpace.</span>
        </div>
        <a href="index.php?route=layanan_add" class="admin-hero-button">+ Tambah Layanan</a>
    </section>
    <?php if (isset($_GET['created']) && $_GET['created'] == 'success'): ?>
        <div class="admin-alert success">Data layanan berhasil ditambahkan.</div>
    <?php endif; ?>
    <?php if (isset($_GET['updated']) && $_GET['updated'] == 'success'): ?>
        <div class="admin-alert success">Data layanan berhasil diperbarui.</div>
    <?php endif; ?>
    <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 'success'): ?>
        <div class="admin-alert success">Data layanan berhasil dihapus.</div>
    <?php endif; ?>
    <section class="admin-service-grid">
        <?php if (mysqli_num_rows($query_layanan) > 0): ?>
            <?php while ($layanan = mysqli_fetch_assoc($query_layanan)): ?>
                <div class="admin-service-card">
                    <img src="/images/<?php echo htmlspecialchars($layanan['gambar']); ?>" alt="<?php echo htmlspecialchars($layanan['nama_layanan']); ?>">
                    <div class="admin-service-content">
                        <span><?php echo htmlspecialchars($layanan['kategori']); ?></span>
                        <h2><?php echo htmlspecialchars($layanan['nama_layanan']); ?></h2>
                        <p><?php echo htmlspecialchars($layanan['deskripsi']); ?></p>
                        <div class="admin-service-meta">
                            <small><?php echo htmlspecialchars($layanan['durasi']); ?></small>
                            <small><?php echo htmlspecialchars($layanan['kapasitas']); ?></small>
                            <small><?php echo htmlspecialchars($layanan['fasilitas']); ?></small>
                        </div>
                        <strong><?php echo rupiah($layanan['harga']); ?></strong>
                        <div class="admin-service-action">
                            <a href="index.php?route=layanan_edit&id=<?php echo $layanan['id_layanan']; ?>" class="admin-edit-btn">Edit Layanan</a>
                            <a href="index.php?route=layanan_delete&id=<?php echo $layanan['id_layanan']; ?>" class="admin-delete-btn" onclick="return confirm('Yakin ingin menghapus layanan ini?');">Hapus</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="empty-box">
                <h3>Belum Ada Layanan</h3>
                <p>Data layanan belum tersedia. Silakan tambah layanan baru.</p>
                <a href="index.php?route=layanan_add" class="button">Tambah Layanan</a>
            </div>
        <?php endif; ?>
    </section>
</main>
<footer>
    <p>© 2026 ClickSpace</p>
</footer>
<script src="/js/validation.js"></script>
</body>
</html>
