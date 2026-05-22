<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Sign Up - ClickSpace</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">

<main class="auth-main">
  <div class="auth-card signup-card">
    <div class="auth-logo">CS</div>

    <h1>Create Account</h1>
    <p class="auth-subtitle">Daftar akun untuk mulai melakukan booking studio foto di ClickSpace.</p>

    <?php if (isset($_GET['error'])) { ?>
      <div class="auth-error">
        <?php
          if ($_GET['error'] === 'password') {
            echo 'Password dan konfirmasi password tidak cocok.';
          } elseif ($_GET['error'] === 'exists') {
            echo 'Email sudah terdaftar.';
          } else {
            echo 'Gagal registrasi. Coba lagi.';
          }
        ?>
      </div>
    <?php } ?>

    <form action="proses_register.php" method="POST">
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

    <p class="auth-switch">
      Already have an account? <a href="login.php">Log In</a>
    </p>

    <a href="index.html" class="back-home">Kembali ke Home</a>
  </div>
</main>

</body>
</html>
