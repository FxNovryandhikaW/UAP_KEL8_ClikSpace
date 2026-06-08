<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sign Up - ClickSpace</title>
    <link rel="stylesheet" href="/css/style.css?v=90">
</head>
<body class="auth-page">
<main class="auth-main">
    <div class="auth-card signup-card">
        <div class="auth-logo">CS</div>
        <h1>Create Account</h1>
        <p class="auth-subtitle">Daftar akun untuk mulai melakukan booking studio foto di ClickSpace.</p>
        <?php if (isset($_GET['error'])): ?>
            <div class="auth-error-box">
                <?php
                $msg = [
                    'empty'   => 'Semua data wajib diisi.',
                    'email'   => 'Format email tidak valid.',
                    'whatsapp'=> 'Nomor WhatsApp harus berupa angka 10-15 digit.',
                    'short'   => 'Password minimal 6 karakter.',
                    'password'=> 'Konfirmasi password tidak cocok.',
                    'exists'  => 'Email sudah terdaftar. Silakan login.',
                ];
                echo $msg[$_GET['error']] ?? 'Registrasi gagal. Periksa kembali data kamu.';
                ?>
            </div>
        <?php endif; ?>
        <form action="index.php?route=register_process" method="POST">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" placeholder="Masukkan nama lengkap" required>
            <label>Email</label>
            <input type="email" name="email" placeholder="Masukkan email" required>
            <label>No WhatsApp</label>
            <input type="text" name="no_whatsapp" placeholder="Masukkan nomor WhatsApp" required>
            <label>Password</label>
            <input type="password" name="password" placeholder="Masukkan password" required>
            <label>Konfirmasi Password</label>
            <input type="password" name="konfirmasi_password" placeholder="Ulangi password" required>
            <button type="submit" class="auth-button">Sign Up</button>
        </form>
        <p class="auth-switch">Already have an account? <a href="index.php?route=login">Log In</a></p>
        <a href="index.php?route=home" class="back-home">Kembali ke Home</a>
    </div>
</main>
<script src="/js/validation.js"></script>
</body>
</html>
