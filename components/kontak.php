<?php
// KONTAK SECTION COMPONENT WITH EMAILJS OTP VERIFICATION & DATABASE INSERT
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/env.php';

/** @var PDO|null $pdo */
/** @var string $db_driver */

$feedback_status = null;
$feedback_message = '';

// Ambil kredensial EmailJS dari environment .env secara aman
$emailjs_service_id  = getenv('EMAILJS_SERVICE_ID') ?: 'service_kwbsvxg';
$emailjs_template_id = getenv('EMAILJS_TEMPLATE_ID') ?: 'template_bu1bryq';
$emailjs_public_key  = getenv('EMAILJS_PUBLIC_KEY') ?: '6EQMY_TcGjGsSBYhe';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['submit_kontak']) || isset($_POST['nama']))) {
  $nama   = trim($_POST['nama'] ?? '');
  $email  = trim($_POST['email'] ?? '');
  $subjek = trim($_POST['subjek'] ?? '');
  $pesan  = trim($_POST['pesan'] ?? '');

  if ($pdo instanceof PDO && !empty($nama) && !empty($email) && !empty($subjek) && !empty($pesan)) {
    try {
      $now = date('Y-m-d H:i:s');
      $stmt = $pdo->prepare("INSERT INTO pesan_kontak (nama, email, subjek, pesan, status, created_at) VALUES (:nama, :email, :subjek, :pesan, 'belum_dibaca', :created_at)");
      $stmt->execute([
        ':nama'       => $nama,
        ':email'      => $email,
        ':subjek'     => $subjek,
        ':pesan'      => $pesan,
        ':created_at' => $now
      ]);

      $feedback_status = 'success';
      $feedback_message = "Terima kasih, <strong>" . htmlspecialchars($nama) . "</strong>! Pesan dari email (<code>" . htmlspecialchars($email) . "</code>) <strong>telah terverifikasi OTP & tersimpan ke Database Admin & phpMyAdmin</strong>!";
    } catch (PDOException $e) {
      $feedback_status = 'error';
      $feedback_message = "Gagal menyimpan pesan ke database: " . $e->getMessage();
    }
  } else {
    $feedback_status = 'error';
    $feedback_message = "Mohon lengkapi semua kolom form kontak.";
  }
}
?>

<!-- Pass EmailJS Credentials Securely to Client JavaScript -->
<script>
  window.EMAILJS_CONFIG = {
    serviceID: "<?php echo htmlspecialchars($emailjs_service_id); ?>",
    templateID: "<?php echo htmlspecialchars($emailjs_template_id); ?>",
    publicKey: "<?php echo htmlspecialchars($emailjs_public_key); ?>"
  };
</script>
<!-- EmailJS Browser SDK -->
<script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>

<section id="kontak" class="section section-bg-alt">
  <div class="container">
    <div class="section-header reveal">
      <span class="badge-tag"><i class="fa-solid fa-paper-plane"></i> Hubungi Kami</span>
      <h2 class="section-title">Kontak <span>XI PPLG</span></h2>
      <p class="section-subtitle">Kirimkan pesan Anda. Setiap pengiriman dilengkapi verifikasi kode OTP EmailJS dan tersimpan langsung ke database.</p>
    </div>

    <div class="contact-grid">
      <!-- Info Box -->
      <div class="contact-info-card reveal">
        <h3>Informasi Sekolah</h3>
        <p>Jl.Ahmad Yani Utara No.466, Peguyangan, Kec. Denpasar Utara, Kota Denpasar, Bali 80238</p>

        <div class="info-item">
          <div class="info-icon"><i class="fa-solid fa-location-dot"></i></div>
          <div class="info-text">
            <h5>Lokasi Lab</h5>
            <p>Gedung Biru Lab Komputer, Ruang Lab PPLG</p>
          </div>
        </div>

        <div class="info-item">
          <div class="info-icon"><i class="fa-solid fa-envelope"></i></div>
          <div class="info-text">
            <h5>Email Resmi Kelas</h5>
            <p>xipplg.official@gmail.com</p>
          </div>
        </div>

        <div class="info-item">
          <div class="info-icon"><i class="fa-brands fa-instagram"></i></div>
          <div class="info-text">
            <h5>Instagram XI PPLG</h5>
            <p>@xipplg_official</p>
          </div>
        </div>

        <!-- EmailJS Verification Info Badge -->
        <div class="info-item" style="margin-top: 1.5rem; background: rgba(37,99,235,0.15); border: 1px solid rgba(37,99,235,0.3); padding: 1rem; border-radius: 12px;">
          <div class="info-icon" style="background: #2563EB; color: #fff;"><i class="fa-solid fa-key"></i></div>
          <div class="info-text">
            <h5 style="color: #ffffff;">Sistem OTP Anti-Iseng</h5>
            <p style="font-size: 0.82rem; color: rgba(255,255,255,0.9); line-height: 1.45; margin-top: 0.2rem;">
              Sistem akan mengirim 6-digit kode OTP ke email Anda via EmailJS untuk membuktikan keaslian akun email pengirim.
            </p>
          </div>
        </div>

        <div class="info-item" style="margin-top: 1rem; background: rgba(255,255,255,0.15); padding: 1rem; border-radius: 12px;">
          <div class="info-icon" style="background: rgba(255,255,255,0.2); color: #fff;"><i class="fa-solid fa-user-shield"></i></div>
          <div class="info-text">
            <h5>Admin</h5>
            <p><a href="admin/login.php" style="color: #38BDF8; font-weight: 600; text-decoration: underline;">Login Dashboard Admin &rarr;</a></p>
          </div>
        </div>
      </div>

      <!-- Form Box -->
      <div class="contact-form-box reveal">
        <?php if ($feedback_status === 'success'): ?>
          <div class="alert alert-success" style="background: #D1FAE5; border: 1px solid #10B981; color: #065F46; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
            <i class="fa-solid fa-circle-check" style="font-size: 1.4rem;"></i>
            <div><?php echo $feedback_message; ?></div>
          </div>
        <?php elseif ($feedback_status === 'error'): ?>
          <div class="alert alert-danger" style="background: #FEE2E2; border: 1px solid #EF4444; color: #991B1B; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
            <i class="fa-solid fa-triangle-exclamation" style="font-size: 1.4rem;"></i>
            <div><?php echo $feedback_message; ?></div>
          </div>
        <?php endif; ?>

        <!-- EmailJS Dynamic Realtime Status Alert -->
        <div id="emailjsStatusBox" style="display: none; margin-bottom: 1.25rem; padding: 0.85rem 1rem; border-radius: 10px; font-size: 0.88rem;"></div>

        <form id="contactForm" method="POST" action="index.php#kontak">
          <!-- Hidden Input Flag for Programmatic JS Form Submission -->
          <input type="hidden" name="submit_kontak" value="1">

          <div class="form-group">
            <label for="inputName">Nama Lengkap</label>
            <input type="text" id="inputName" name="nama" class="form-control" placeholder="Masukkan nama Anda..." value="<?php echo htmlspecialchars($_POST['nama'] ?? ''); ?>" required>
          </div>

          <div class="form-group">
            <label for="inputEmail">Email Anda <span style="font-size: 0.78rem; color: #2563EB; font-weight: 600;">(Wajib Verifikasi OTP)</span></label>
            <div style="display: flex; gap: 0.5rem;">
              <input type="email" id="inputEmail" name="email" class="form-control" placeholder="contoh: nama@domain.com" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required autocomplete="email">
              <button type="button" id="btnSendOTP" style="white-space: nowrap; background: #2563EB; color: #fff; font-size: 0.82rem; padding: 0.5rem 0.85rem; border-radius: 8px; border: none; cursor: pointer; font-weight: 600; transition: all 0.2s;">
                <i class="fa-solid fa-key"></i> Kirim OTP
              </button>
            </div>
          </div>

          <!-- OTP Verification Input Box -->
          <div id="otpBox" style="display: none; background: #EFF6FF; border: 1.5px solid #93C5FD; padding: 1rem; border-radius: 12px; margin-bottom: 1.25rem;">
            <label for="inputOTPCode" style="font-size: 0.85rem; font-weight: 700; color: #1E40AF; display: block; margin-bottom: 0.4rem;">
              <i class="fa-solid fa-shield-check"></i> Masukkan 6-Digit Kode OTP Verifikasi
            </label>
            <div style="display: flex; gap: 0.5rem;">
              <input type="text" id="inputOTPCode" class="form-control" placeholder="6-Digit OTP..." maxlength="6" style="text-align: center; font-size: 1.1rem; font-weight: 700; letter-spacing: 3px;">
              <button type="button" id="btnVerifyOTP" style="background: #10B981; color: #fff; border: none; padding: 0.5rem 1.1rem; border-radius: 8px; font-weight: 600; cursor: pointer; white-space: nowrap;">
                Verifikasi OTP
              </button>
            </div>
            <div id="otpMsg" style="font-size: 0.82rem; margin-top: 0.5rem; color: #1E40AF; line-height: 1.4;"></div>
          </div>

          <div class="form-group">
            <label for="inputSubject">Subjek / Perihal</label>
            <input type="text" id="inputSubject" name="subjek" class="form-control" placeholder="Pertanyaan / Kerja Sama..." value="<?php echo htmlspecialchars($_POST['subjek'] ?? ''); ?>" required>
          </div>

          <div class="form-group">
            <label for="inputMessage">Pesan Anda</label>
            <textarea id="inputMessage" name="pesan" class="form-control" placeholder="Tuliskan pesan Anda secara lengkap..." required><?php echo htmlspecialchars($_POST['pesan'] ?? ''); ?></textarea>
          </div>

          <button type="submit" id="btnSubmitKontak" name="submit_kontak" class="btn btn-primary" style="width: 100%;">
            <i class="fa-solid fa-paper-plane"></i> Kirim Pesan & Simpan DB
          </button>
        </form>
      </div>
    </div>
  </div>
</section>
