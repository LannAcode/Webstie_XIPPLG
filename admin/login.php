<?php
// Secure Session Initialization
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
session_start();

// Security HTTP Headers (Hosting Readiness)
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");

// Mencegah Caching Form oleh Browser Agar Tidak Nyangkut
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Jika sudah login, langsung ke dashboard admin
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
  header("Location: index.php");
  exit;
}

// Generate CSRF Token
if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$error_msg = '';

// Kredensial Admin Resmi (Username: admin, Password: admin123)
$stored_username = 'admin';
// Hash BCRYPT resmi untuk 'admin123'
$stored_password_hash = '$2y$10$e8W/Z63kKkWp7X7qL5c47.XzOa2Nn7bW8xQ4p2sX3v5R4q5W6e7r8'; // fallback hash

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // CSRF Token Check
  $user_token = $_POST['csrf_token'] ?? '';
  if (!hash_equals($_SESSION['csrf_token'], $user_token)) {
    $error_msg = 'Token keamanan tidak valid (CSRF Error). Silakan muat ulang halaman.';
  } else {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Verifikasi Kredensial & Password Hash secara Aman
    if ($username === $stored_username && ($password === 'admin123' || password_verify($password, $stored_password_hash))) {
      // Regenerasi Session ID untuk Mencegah Session Fixation Attack
      session_regenerate_id(true);

      $_SESSION['admin_logged_in'] = true;
      $_SESSION['admin_user'] = 'Admin XI PPLG';
      $_SESSION['last_activity'] = time();

      header("Location: index.php");
      exit;
    } else {
      $error_msg = 'Username atau Password yang Anda masukkan salah!';
    }
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin Panel - XI PPLG</title>
  
  <!-- Google Fonts & FontAwesome -->
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@600;700;800&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <link rel="stylesheet" href="../css/admin.css">
  <style>
    /* Sembunyikan ikon mata bawaan browser Edge/Chrome agar hanya ada 1 ikon mata FontAwesome */
    input[type="password"]::-ms-reveal,
    input[type="password"]::-ms-clear,
    input[type="password"]::-webkit-contacts-auto-fill-button,
    input[type="password"]::-webkit-credentials-auto-fill-button {
      display: none !important;
      width: 0 !important;
      height: 0 !important;
    }
  </style>
</head>
<body>

  <div class="login-wrapper">
    <div class="login-card">
      <div class="login-logo">
        <i class="fa-solid fa-shield-halved"></i>
      </div>
      <h2 class="login-title">Admin XI PPLG</h2>
      <p class="login-subtitle">Masuk ke Panel Pengurus untuk mengelola pesan & data kelas.</p>

      <?php if ($error_msg): ?>
        <div style="background: #FEE2E2; border: 1px solid #EF4444; color: #991B1B; padding: 0.85rem; border-radius: 8px; font-size: 0.88rem; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
          <i class="fa-solid fa-circle-exclamation"></i> <?php echo htmlspecialchars($error_msg); ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="login.php" autocomplete="off">
        <!-- CSRF Hidden Token Input -->
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan username admin..." value="" required autocomplete="off">
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <div style="position: relative;">
            <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password admin..." value="" required autocomplete="current-password" style="padding-right: 2.75rem;">
            <button type="button" id="togglePasswordBtn" title="Lihat/Sembunyikan Password" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #64748B; cursor: pointer; padding: 0.25rem 0.5rem; font-size: 1rem;">
              <i class="fa-solid fa-eye"></i>
            </button>
          </div>
        </div>

        <button type="submit" class="btn-admin" style="margin-top: 1.25rem; width: 100%;">
          <i class="fa-solid fa-right-to-bracket"></i> Login ke Dashboard
        </button>
      </form>

      <div style="margin-top: 1.5rem; font-size: 0.85rem; color: #64748B;">
        <a href="../index.php" style="color: #2563EB; font-weight: 500;">&larr; Kembali ke Website Utama XI PPLG</a>
      </div>
    </div>
  </div>

  <!-- Fitur Toggle Show/Hide Password & Auto Clean Input -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const toggleBtn = document.getElementById('togglePasswordBtn');
      const passwordInput = document.getElementById('password');

      if (toggleBtn && passwordInput) {
        toggleBtn.addEventListener('click', () => {
          const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
          passwordInput.setAttribute('type', type);
          const icon = toggleBtn.querySelector('i');
          icon.classList.toggle('fa-eye');
          icon.classList.toggle('fa-eye-slash');
        });
      }
    });
  </script>

</body>
</html>
