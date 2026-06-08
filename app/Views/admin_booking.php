<?php
session_start();
include "../../config/database.php"; // using config

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
    $where .= " AND (\n        booking.kode_booking LIKE '%$keyword%' \n        OR booking.nama_customer LIKE '%$keyword%' \n        OR layanan.nama_layanan LIKE '%$keyword%'\n    )";
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
<html lang=\"id\">
<head>
    <meta charset=\"UTF-8\">
    <title>Data Booking - Admin ClickSpace</title>
    <link rel=\"stylesheet\" href=\"/css/style.css?v=80\">
</head>
<body class=\"admin-page\">
    <header>
        <div class=\"logo\">ClickSpace Admin</div>
        <nav>
            <a href=\"admin-dashboard.php\">Dashboard</a>
            <a href=\"admin-booking.php\">Data Booking</a>
            <a href=\"admin-users.php\">Customer</a>
            <a href=\"admin-layanan.php\">Layanan</a>
            <a href=\"logout.php\" class=\"btn-login\">Logout</a>
        </nav>
    </header>
    <main class=\"admin-main\">
        <!-- content same as original... -->
    </main>
    <footer>
        <p>© 2026 ClickSpace</p>
    </footer>
<script src="/js/validation.js"></script>
</body>
</html>
