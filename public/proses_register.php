<?php
// public/proses_register.php
require_once __DIR__ . '/../config/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php?route=register');
    exit;
}

$nama = trim($_POST['nama_lengkap'] ?? '');
$email = trim($_POST['email'] ?? '');
$whatsapp = trim($_POST['no_whatsapp'] ?? '');
$password = $_POST['password'] ?? '';
$confirm = $_POST['konfirmasi_password'] ?? '';

// Basic validation
if (empty($nama) || empty($email) || empty($whatsapp) || empty($password) || empty($confirm)) {
    header('Location: index.php?route=register&error=empty');
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: index.php?route=register&error=email');
    exit;
}
if (!preg_match('/^\d{10,15}$/', $whatsapp)) {
    header('Location: index.php?route=register&error=whatsapp');
    exit;
}
if (strlen($password) < 6) {
    header('Location: index.php?route=register&error=short');
    exit;
}
if ($password !== $confirm) {
    header('Location: index.php?route=register&error=password');
    exit;
}

// Check if email already exists
$stmt = $conn->prepare('SELECT id_user FROM users WHERE email = ? LIMIT 1');
$stmt->bind_param('s', $email);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows > 0) {
    header('Location: index.php?route=register&error=exists');
    exit;
}

// Insert new user (role = customer)
$hash = password_hash($password, PASSWORD_BCRYPT);
$stmt = $conn->prepare('INSERT INTO users (nama_lengkap, email, no_whatsapp, password, role) VALUES (?, ?, ?, ?, ?)');
$role = 'customer';
$stmt->bind_param('sssss', $nama, $email, $whatsapp, $hash, $role);
if ($stmt->execute()) {
    header('Location: index.php?route=login&success=registered');
    exit;
} else {
    header('Location: index.php?route=register&error=failed');
    exit;
}
?>
