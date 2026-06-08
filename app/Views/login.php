<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - ClickSpace</title>
    <link rel="stylesheet" href="/css/style.css?v=90">
</head>
<body class="auth-page">
<main class="auth-main">
    <div class="auth-card">
        <div class="auth-logo">CS</div>
        <h1>Welcome Back!</h1>
        <p class="auth-subtitle">Login untuk mengakses booking studio dan melihat riwayat pemesananmu.</p>
        <?php if (isset($_GET['error'])): ?>
            <div class="auth-error-box">
                <?php
                $msg = [
                    'empty'   => 'Email dan password wajib diisi.',
                    'email'   => 'Format email tidak valid.',
                    'invalid' => 'Email atau password salah.',
                    'role'    => 'Role akun tidak valid.',
                    'timeout' => 'Sesi kamu sudah berakhir karena tidak ada aktivitas. Silakan login kembali.',
                ];
                echo $msg[$_GET['error']] ?? 'Login gagal. Silakan coba lagi.';
                ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['success']) && $_GET['success'] == 'registered'): ?>
            <div class="auth-success-box">Registrasi berhasil. Silakan login.</div>
        <?php endif; ?>
        <form action="index.php?route=login_process" method="POST">
            <label>Email</label>
            <input type="email" name="email" placeholder="Masukkan email" required>
            <label>Password</label>
            <input type="password" name="password" placeholder="Masukkan password" required>
            <div class="auth-row">
                <label class="remember"><input type="checkbox">Remember me</label>
                <a href="#">Forgot password?</a>
            </div>
            <button type="submit" class="auth-button">Log In</button>
        </form>
        <p class="auth-switch">Don't have an account? <a href="index.php?route=register">Sign Up</a></p>
        <a href="index.php?route=home" class="back-home">Kembali ke Home</a>
    </div>
</main>
<script src="/js/validation.js"></script>
</body>
</html>
