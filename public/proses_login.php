<?php
// public/proses_login.php
require_once __DIR__ . '/../config/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php?route=login');
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    header('Location: index.php?route=login&error=empty');
    exit;
}

// Basic email format validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: index.php?route=login&error=email');
    exit;
}

$stmt = $conn->prepare('SELECT id_user, nama_lengkap, password, role FROM users WHERE email = ? LIMIT 1');
$stmt->bind_param('s', $email);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
    header('Location: index.php?route=login&error=invalid');
    exit;
}
$user = $res->fetch_assoc();

if (!password_verify($password, $user['password'])) {
    header('Location: index.php?route=login&error=invalid');
    exit;
}

// Set session data
$_SESSION['id_user'] = $user['id_user'];
$_SESSION['nama_lengkap'] = $user['nama_lengkap'];
$_SESSION['role'] = $user['role'];

// Redirect based on role
if ($user['role'] === 'admin') {
    header('Location: index.php?route=dashboard');
} else {
    header('Location: index.php?route=home');
}
exit;
?>
