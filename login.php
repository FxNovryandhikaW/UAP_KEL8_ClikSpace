<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - ClickSpace</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">

<main class="auth-main">
  <div class="auth-card">
    <div class="auth-logo">CS</div>

    <h1>Welcome Back!</h1>
    <p class="auth-subtitle">Login untuk mengakses booking studio dan melihat riwayat pemesananmu.</p>

    <?php if (isset($_GET['error']) && $_GET['error'] === 'invalid') { ?>
      <div class="auth-error">Email atau password salah.</div>
    <?php } ?>

    <?php if (isset($_GET['success']) && $_GET['success'] === 'registered') { ?>
      <div class="auth-success">Registrasi berhasil. Silakan login.</div>
    <?php } ?>

    <form action="proses_login.php" method="POST">
      <label>Email</label>
      <input type="email" name="email" placeholder="Masukkan email" required>

      <label>Password</label>
      <input type="password" name="password" placeholder="Masukkan password" required>

      <div class="auth-row">
        <label class="remember">
          <input type="checkbox">
          <span>Remember me</span>
        </label>

        <a href="#">Forgot password?</a>
      </div>

      <button type="submit" class="auth-button">Log In</button>
    </form>

    <p class="auth-switch">
      Don't have an account? <a href="register.php">Sign Up</a>
    </p>

    <a href="index.html" class="back-home">Kembali ke Home</a>
  </div>
</main>

</body>
</html>
