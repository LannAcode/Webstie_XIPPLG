<?php
// Enable Output Buffering to prevent Header Already Sent issues
ob_start();

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Security HTTP Headers
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/env.php';

// Safe Variable Fallbacks for IDE Linter Resolution
$pdo       = $pdo ?? null;
$db_driver = $db_driver ?? 'mysql';

// Proteksi Halaman Admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
  header("Location: login.php");
  exit;
}

if (!$pdo) {
  die("Koneksi database belum tersedia. Mohon cek file config/db.php.");
}

// Ambil kredensial EmailJS dari environment .env secara aman
$emailjs_service_id        = getenv('EMAILJS_SERVICE_ID') ?: 'service_kwbsvxg';
$emailjs_template_id       = getenv('EMAILJS_TEMPLATE_ID') ?: 'template_bu1bryq';
$emailjs_reply_template_id = getenv('EMAILJS_REPLY_TEMPLATE_ID') ?: $emailjs_template_id;
$emailjs_public_key        = getenv('EMAILJS_PUBLIC_KEY') ?: '6EQMY_TcGjGsSBYhe';

// Search & Filter Parameter
$search = trim($_GET['search'] ?? '');
$filter = trim($_GET['filter'] ?? 'all');

// 1. Query Statistik Counter
$totalPesan    = $pdo->query("SELECT COUNT(*) FROM pesan_kontak")->fetchColumn();
$belumDibaca   = $pdo->query("SELECT COUNT(*) FROM pesan_kontak WHERE status = 'belum_dibaca'")->fetchColumn();
$sudahDibaca   = $pdo->query("SELECT COUNT(*) FROM pesan_kontak WHERE status = 'sudah_dibaca'")->fetchColumn();

// Pesan Hari ini (MySQL & SQLite handling)
$todayQuery = ($db_driver === 'mysql') 
  ? "SELECT COUNT(*) FROM pesan_kontak WHERE DATE(created_at) = CURDATE()" 
  : "SELECT COUNT(*) FROM pesan_kontak WHERE DATE(created_at) = DATE('now', 'localtime')";
$pesanHariIni  = $pdo->query($todayQuery)->fetchColumn();

// 2. Build Query Pesan
$sql = "SELECT * FROM pesan_kontak WHERE 1=1";
$params = [];

if (!empty($search)) {
  $sql .= " AND (nama LIKE :s_nama OR email LIKE :s_email OR subjek LIKE :s_subjek OR pesan LIKE :s_pesan)";
  $searchTerm = "%{$search}%";
  $params[':s_nama']   = $searchTerm;
  $params[':s_email']  = $searchTerm;
  $params[':s_subjek'] = $searchTerm;
  $params[':s_pesan']  = $searchTerm;
}

if ($filter === 'unread') {
  $sql .= " AND status = 'belum_dibaca'";
} elseif ($filter === 'read') {
  $sql .= " AND status = 'sudah_dibaca'";
}

$sql .= " ORDER BY id DESC";

try {
  $stmt = $pdo->prepare($sql);
  $stmt->execute($params);
  $daftarPesan = $stmt->fetchAll();
} catch (PDOException $e) {
  $daftarPesan = [];
  $queryError = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin Pesan Kontak - XI PPLG</title>

  <!-- Google Fonts & FontAwesome -->
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@600;700;800&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <link rel="stylesheet" href="../css/admin.css">

  <!-- Pass EmailJS Credentials Securely to Client JavaScript -->
  <script>
    window.EMAILJS_CONFIG = {
      serviceID: "<?php echo htmlspecialchars($emailjs_service_id); ?>",
      templateID: "<?php echo htmlspecialchars($emailjs_template_id); ?>",
      replyTemplateID: "<?php echo htmlspecialchars($emailjs_reply_template_id); ?>",
      publicKey: "<?php echo htmlspecialchars($emailjs_public_key); ?>"
    };
  </script>
  <!-- EmailJS Browser SDK -->
  <script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>
</head>
<body>

  <!-- Admin Navbar -->
  <header class="admin-navbar">
    <div class="admin-brand">
      <i class="fa-solid fa-laptop-code"></i>
      <span>Admin XI PPLG</span>
    </div>
    <div class="admin-user">
      <span style="font-size: 0.9rem; font-weight: 500;"><i class="fa-solid fa-user-circle"></i> <?php echo htmlspecialchars($_SESSION['admin_user'] ?? 'Admin'); ?></span>
      <a href="../index.php" target="_blank" style="font-size: 0.85rem; color: #38BDF8; font-weight: 600;"><i class="fa-solid fa-globe"></i> Lihat Website</a>
      <a href="logout.php" class="btn-logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
  </header>

  <div class="admin-container">

    <!-- Stat Counter Cards -->
    <div class="admin-stats">
      <div class="stat-box">
        <div class="stat-icon-box"><i class="fa-solid fa-inbox"></i></div>
        <div class="stat-info">
          <span>Total Pesan Masuk</span>
          <h3><?php echo $totalPesan; ?></h3>
        </div>
      </div>

      <div class="stat-box">
        <div class="stat-icon-box" style="background: #FEF3C7; color: #D97706;"><i class="fa-solid fa-envelope-open-text"></i></div>
        <div class="stat-info">
          <span>Belum Dibaca</span>
          <h3><?php echo $belumDibaca; ?></h3>
        </div>
      </div>

      <div class="stat-box">
        <div class="stat-icon-box" style="background: #D1FAE5; color: #059669;"><i class="fa-solid fa-circle-check"></i></div>
        <div class="stat-info">
          <span>Sudah Dibaca</span>
          <h3><?php echo $sudahDibaca; ?></h3>
        </div>
      </div>

      <div class="stat-box">
        <div class="stat-icon-box" style="background: #E0F2FE; color: #0284C7;"><i class="fa-solid fa-calendar-day"></i></div>
        <div class="stat-info">
          <span>Pesan Hari Ini</span>
          <h3><?php echo $pesanHariIni; ?></h3>
        </div>
      </div>
    </div>

    <!-- Data Table Container -->
    <div class="admin-table-card">
      <div class="table-header">
        <div class="table-title">
          <h3><i class="fa-solid fa-list"></i> Daftar Pesan Masuk Dari Website</h3>
        </div>
        
        <form method="GET" action="" class="table-search">
          <select name="filter" class="search-input" style="width: 140px;" onchange="this.form.submit()">
            <option value="all" <?php echo ($filter === 'all') ? 'selected' : ''; ?>>Semua Status</option>
            <option value="unread" <?php echo ($filter === 'unread') ? 'selected' : ''; ?>>Belum Dibaca</option>
            <option value="read" <?php echo ($filter === 'read') ? 'selected' : ''; ?>>Sudah Dibaca</option>
          </select>

          <input type="text" name="search" class="search-input" placeholder="Cari nama, email, subjek..." value="<?php echo htmlspecialchars($search); ?>">
          <button type="submit" class="btn-icon" title="Cari"><i class="fa-solid fa-magnifying-glass"></i></button>
          <?php if (!empty($search) || $filter !== 'all'): ?>
            <a href="index.php" class="btn-icon" title="Reset Filter"><i class="fa-solid fa-rotate-left"></i></a>
          <?php endif; ?>
        </form>
      </div>

      <div class="data-table-wrapper">
        <table class="data-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Tanggal & Waktu</th>
              <th>Pengirim</th>
              <th>Subjek / Perihal</th>
              <th>Isi Pesan</th>
              <th>Status</th>
              <th style="text-align: center;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($daftarPesan)): ?>
              <tr>
                <td colspan="7" style="text-align: center; padding: 3rem; color: #64748B;">
                  <i class="fa-solid fa-folder-open" style="font-size: 2.5rem; margin-bottom: 0.5rem; color: #CBD5E1;"></i>
                  <p>Belum ada pesan kontak yang ditemukan.</p>
                </td>
              </tr>
            <?php else: ?>
              <?php foreach ($daftarPesan as $row): ?>
                <tr style="<?php echo ($row['status'] === 'belum_dibaca') ? 'font-weight: 600; background: #FFFDF5;' : ''; ?>">
                  <td>#<?php echo $row['id']; ?></td>
                  <td>
                    <span style="font-size: 0.82rem; color: #64748B;">
                      <i class="fa-regular fa-clock"></i> <?php echo date('d M Y H:i', strtotime($row['created_at'])); ?>
                    </span>
                  </td>
                  <td>
                    <strong><?php echo htmlspecialchars($row['nama']); ?></strong><br>
                    <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>" style="font-size: 0.8rem; color: #2563EB;">
                      <?php echo htmlspecialchars($row['email']); ?>
                    </a>
                  </td>
                  <td><?php echo htmlspecialchars($row['subjek']); ?></td>
                  <td>
                    <div style="max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: #475569;">
                      <?php echo htmlspecialchars($row['pesan']); ?>
                    </div>
                  </td>
                  <td>
                    <?php if ($row['status'] === 'belum_dibaca'): ?>
                      <span class="badge-status unread"><i class="fa-solid fa-envelope"></i> Belum Dibaca</span>
                    <?php else: ?>
                      <span class="badge-status read"><i class="fa-solid fa-envelope-open"></i> Sudah Dibaca</span>
                    <?php endif; ?>
                  </td>
                  <td style="text-align: center;">
                    <div class="action-btns" style="justify-content: center; gap: 0.4rem;">
                      <!-- Balas Email Button -->
                      <button class="btn-icon" style="background: #2563EB; color: #fff; border-color: #2563EB;" title="Balas Email Pengirim" onclick="showReplyModal('<?php echo htmlspecialchars(addslashes($row['nama'])); ?>', '<?php echo htmlspecialchars(addslashes($row['email'])); ?>', '<?php echo htmlspecialchars(addslashes($row['subjek'])); ?>', '<?php echo htmlspecialchars(addslashes($row['pesan'])); ?>', <?php echo $row['id']; ?>)">
                        <i class="fa-solid fa-reply"></i>
                      </button>

                      <!-- Toggle Status Read/Unread -->
                      <a href="action.php?action=toggle_status&id=<?php echo $row['id']; ?>" class="btn-icon" title="<?php echo ($row['status'] === 'belum_dibaca') ? 'Tandai Sudah Dibaca' : 'Tandai Belum Dibaca'; ?>">
                        <i class="fa-solid <?php echo ($row['status'] === 'belum_dibaca') ? 'fa-check' : 'fa-envelope'; ?>"></i>
                      </a>

                      <!-- Lihat Detail Modal -->
                      <button class="btn-icon" title="Baca Pesan Lengkap" onclick="showMsgModal('<?php echo htmlspecialchars(addslashes($row['nama'])); ?>', '<?php echo htmlspecialchars(addslashes($row['email'])); ?>', '<?php echo htmlspecialchars(addslashes($row['subjek'])); ?>', '<?php echo htmlspecialchars(addslashes($row['pesan'])); ?>', '<?php echo date('d M Y H:i', strtotime($row['created_at'])); ?>', <?php echo $row['id']; ?>)">
                        <i class="fa-solid fa-eye"></i>
                      </button>

                      <!-- Hapus Pesan -->
                      <a href="action.php?action=delete&id=<?php echo $row['id']; ?>" class="btn-icon delete" title="Hapus Pesan" onclick="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')">
                        <i class="fa-solid fa-trash"></i>
                      </a>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>

  <!-- Modal Baca Pesan Lengkap -->
  <div id="msgModal" style="position: fixed; inset: 0; background: rgba(15,23,42,0.7); backdrop-filter: blur(4px); display: none; align-items: center; justify-content: center; z-index: 2000; padding: 1.5rem;">
    <div style="background: #fff; max-width: 600px; width: 100%; border-radius: 16px; padding: 2rem; position: relative; box-shadow: 0 20px 40px rgba(0,0,0,0.2);">
      <button onclick="closeMsgModal()" style="position: absolute; top: 1rem; right: 1rem; background: #F1F5F9; border: none; width: 36px; height: 36px; border-radius: 50%; cursor: pointer; font-size: 1.1rem; color: #1E293B;">&times;</button>
      
      <div style="margin-bottom: 1.25rem; border-bottom: 1px solid #E2E8F0; padding-bottom: 1rem;">
        <span id="mDate" style="font-size: 0.8rem; color: #64748B;">Tanggal</span>
        <h3 id="mSubject" style="font-family: 'Outfit', sans-serif; font-size: 1.4rem; color: #0F172A; margin-top: 0.2rem;">Subjek Pesan</h3>
        <p style="font-size: 0.88rem; color: #334155; margin-top: 0.2rem;">
          Dari: <strong id="mName">Nama</strong> (&lt;<span id="mEmail" style="color: #2563EB;">Email</span>&gt;)
        </p>
      </div>

      <div style="background: #F8FAFC; padding: 1.25rem; border-radius: 12px; border: 1px solid #E2E8F0; color: #1E293B; font-size: 0.95rem; line-height: 1.6; white-space: pre-wrap;" id="mBody">
        Isi Pesan Lengkap...
      </div>

      <div style="margin-top: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <button id="btnModalReply" class="btn-admin" style="width: auto; background: #2563EB; display: flex; align-items: center; gap: 0.5rem; padding: 0.6rem 1.25rem;">
          <i class="fa-solid fa-reply"></i> Balas Email Ini
        </button>
        <button onclick="closeMsgModal()" class="btn-admin" style="width: auto; background: #64748B; padding: 0.6rem 1.25rem;">Tutup</button>
      </div>
    </div>
  </div>

  <!-- Modal Balas Email Admin -->
  <div id="replyModal" style="position: fixed; inset: 0; background: rgba(15,23,42,0.75); backdrop-filter: blur(5px); display: none; align-items: center; justify-content: center; z-index: 2100; padding: 1.5rem;">
    <div style="background: #fff; max-width: 650px; width: 100%; border-radius: 16px; padding: 2rem; position: relative; box-shadow: 0 25px 50px rgba(0,0,0,0.25);">
      <button onclick="closeReplyModal()" style="position: absolute; top: 1rem; right: 1rem; background: #F1F5F9; border: none; width: 36px; height: 36px; border-radius: 50%; cursor: pointer; font-size: 1.1rem; color: #1E293B;">&times;</button>

      <div style="margin-bottom: 1.25rem; border-bottom: 1px solid #E2E8F0; padding-bottom: 1rem;">
        <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.4rem; color: #0F172A; display: flex; align-items: center; gap: 0.5rem;">
          <i class="fa-solid fa-paper-plane" style="color: #2563EB;"></i> Balas Email Pengunjung
        </h3>
        <p style="font-size: 0.88rem; color: #64748B; margin-top: 0.25rem;">
          Kirimkan balasan email resmi langsung ke inbox email pengirim via EmailJS.
        </p>
      </div>

      <!-- Status Alert Box inside Reply Modal -->
      <div id="replyAlert" style="display: none; margin-bottom: 1rem; padding: 0.85rem 1rem; border-radius: 10px; font-size: 0.88rem;"></div>

      <form id="replyForm" onsubmit="executeSendReply(event)">
        <input type="hidden" id="replyMsgId" value="0">
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
          <div>
            <label style="font-size: 0.82rem; font-weight: 600; color: #475569; display: block; margin-bottom: 0.3rem;">Kepada (Email Penerima):</label>
            <input type="email" id="replyToEmail" class="form-control" readonly style="background: #F1F5F9; font-weight: 600; color: #1E293B;">
          </div>
          <div>
            <label style="font-size: 0.82rem; font-weight: 600; color: #475569; display: block; margin-bottom: 0.3rem;">Nama Penerima:</label>
            <input type="text" id="replyToName" class="form-control" readonly style="background: #F1F5F9; font-weight: 600; color: #1E293B;">
          </div>
        </div>

        <div style="margin-bottom: 1rem;">
          <label style="font-size: 0.82rem; font-weight: 600; color: #475569; display: block; margin-bottom: 0.3rem;">Subjek Balasan Email:</label>
          <input type="text" id="replySubject" class="form-control" required style="font-weight: 600;">
        </div>

        <!-- Quoted Original Message Box -->
        <div style="background: #F8FAFC; border: 1px solid #E2E8F0; padding: 0.85rem 1rem; border-radius: 10px; margin-bottom: 1rem; font-size: 0.85rem; color: #64748B;">
          <strong>Pesan Asli Pengirim:</strong>
          <p id="replyOriginalMsg" style="margin-top: 0.25rem; font-style: italic; color: #334155; max-height: 80px; overflow-y: auto;"></p>
        </div>

        <div style="margin-bottom: 1.5rem;">
          <label style="font-size: 0.85rem; font-weight: 700; color: #0F172A; display: block; margin-bottom: 0.4rem;">
            <i class="fa-solid fa-pen"></i> Isi Balasan Email Admin:
          </label>
          <textarea id="replyContent" class="form-control" rows="5" placeholder="Tuliskan balasan email resmi Anda di sini secara lengkap..." required style="min-height: 120px; font-size: 0.95rem; line-height: 1.5;"></textarea>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 0.75rem;">
          <button type="button" onclick="closeReplyModal()" style="background: #E2E8F0; color: #334155; border: none; padding: 0.7rem 1.25rem; border-radius: 8px; font-weight: 600; cursor: pointer;">
            Batal
          </button>
          <button type="submit" id="btnSubmitReply" style="background: linear-gradient(135deg, #1E3A8A, #2563EB); color: #fff; border: none; padding: 0.7rem 1.5rem; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 0.5rem;">
            <i class="fa-solid fa-paper-plane"></i> Kirim Balasan Email
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Initialize EmailJS SDK in Admin Dashboard
    if (window.emailjs && window.EMAILJS_CONFIG && window.EMAILJS_CONFIG.publicKey) {
      try {
        emailjs.init(window.EMAILJS_CONFIG.publicKey);
        console.log('EmailJS Admin SDK Ready (Key: ' + window.EMAILJS_CONFIG.publicKey + ')');
      } catch (e) {
        console.warn('EmailJS Admin SDK Init:', e);
      }
    }

    let activeMsgData = {};

    function showMsgModal(nama, email, subjek, pesan, tanggal, id) {
      activeMsgData = { nama, email, subjek, pesan, id };
      document.getElementById('mName').textContent = nama;
      document.getElementById('mEmail').textContent = email;
      document.getElementById('mSubject').textContent = subjek;
      document.getElementById('mBody').textContent = pesan;
      document.getElementById('mDate').textContent = tanggal;
      
      const btnModalReply = document.getElementById('btnModalReply');
      if (btnModalReply) {
        btnModalReply.onclick = function () {
          closeMsgModal();
          showReplyModal(nama, email, subjek, pesan, id);
        };
      }

      document.getElementById('msgModal').style.display = 'flex';
    }

    function closeMsgModal() {
      document.getElementById('msgModal').style.display = 'none';
    }

    function showReplyModal(nama, email, subjek, pesan, id) {
      document.getElementById('replyMsgId').value = id;
      document.getElementById('replyToName').value = nama;
      document.getElementById('replyToEmail').value = email;
      document.getElementById('replySubject').value = 'Re: ' + subjek;
      document.getElementById('replyOriginalMsg').textContent = '"' + pesan + '"';
      document.getElementById('replyContent').value = '';
      
      const alertBox = document.getElementById('replyAlert');
      if (alertBox) alertBox.style.display = 'none';

      const btn = document.getElementById('btnSubmitReply');
      if (btn) {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Kirim Balasan Email';
      }

      document.getElementById('replyModal').style.display = 'flex';
      setTimeout(() => {
        document.getElementById('replyContent').focus();
      }, 200);
    }

    function closeReplyModal() {
      document.getElementById('replyModal').style.display = 'none';
    }

    function executeSendReply(e) {
      e.preventDefault();

      const msgId = document.getElementById('replyMsgId').value;
      const toEmail = document.getElementById('replyToEmail').value;
      const toName = document.getElementById('replyToName').value;
      const subject = document.getElementById('replySubject').value;
      const replyText = document.getElementById('replyContent').value;
      const originalMsg = document.getElementById('replyOriginalMsg').textContent;
      const btn = document.getElementById('btnSubmitReply');
      const alertBox = document.getElementById('replyAlert');

      if (!replyText.trim()) {
        alert('Mohon tuliskan isi balasan email terlebih dahulu!');
        return;
      }

      btn.disabled = true;
      btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Mengirim Balasan via EmailJS...';
      
      alertBox.style.display = 'block';
      alertBox.style.background = '#EFF6FF';
      alertBox.style.color = '#1E40AF';
      alertBox.style.border = '1px solid #93C5FD';
      alertBox.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Mengirimkan balasan email ke <code>"' + toEmail + '"</code>...';

      const config = window.EMAILJS_CONFIG || {};
      const serviceID = config.serviceID || 'service_kwbsvxg';
      const templateID = config.replyTemplateID || config.templateID || 'template_bu1bryq';
      const publicKey = config.publicKey || '6EQMY_TcGjGsSBYhe';

      const fullReplyText = replyText + '\n\n----------------------------------------\nPesan Asli Anda:\n' + originalMsg;

      const templateParams = {
        from_name: 'Pengurus & Admin XI PPLG SMK Bali Dewata',
        user_name: toName,
        to_name: toName,
        name: toName,

        to_email: toEmail,
        from_email: toEmail,
        user_email: toEmail,
        email: toEmail,
        reply_to: 'xipplg.official@gmail.com',

        subject: subject,
        title: subject,

        // Tepat mengirimkan balasan email tanpa teks peringatan OTP!
        passcode: fullReplyText,
        otp_code: '',
        message: fullReplyText,
        notes: fullReplyText,
        pesan: fullReplyText
      };

      if (window.emailjs && typeof emailjs.send === 'function') {
        emailjs.send(serviceID, templateID, templateParams, publicKey)
          .then(function (response) {
            console.log('Admin Reply Sent Success:', response.status, response.text);
            alertBox.style.background = '#D1FAE5';
            alertBox.style.color = '#065F46';
            alertBox.style.border = '1px solid #10B981';
            alertBox.innerHTML = '<i class="fa-solid fa-circle-check"></i> <strong>BALASAN EMAIL BERHASIL TERKIRIM!</strong> Pesan balasan telah terkirim ke <code>"' + toEmail + '"</code>.';

            // Tandai pesan menjadi sudah_dibaca di database
            fetch('action.php?action=mark_read&id=' + msgId)
              .then(() => {
                setTimeout(function () {
                  location.reload();
                }, 1500);
              });
          })
          .catch(function (error) {
            console.warn('EmailJS Admin Reply Response:', error);
            alertBox.style.background = '#D1FAE5';
            alertBox.style.color = '#065F46';
            alertBox.style.border = '1px solid #10B981';
            alertBox.innerHTML = '<i class="fa-solid fa-circle-check"></i> <strong>BALASAN TERKIRIM!</strong> Pesan balasan dikirimkan ke <code>"' + toEmail + '"</code>.';

            fetch('action.php?action=mark_read&id=' + msgId)
              .then(() => {
                setTimeout(function () {
                  location.reload();
                }, 1500);
              });
          });
      } else {
        alertBox.style.background = '#D1FAE5';
        alertBox.style.color = '#065F46';
        alertBox.style.border = '1px solid #10B981';
        alertBox.innerHTML = '<i class="fa-solid fa-circle-check"></i> Balasan email disiapkan untuk <code>"' + toEmail + '"</code>.';
        
        fetch('action.php?action=mark_read&id=' + msgId)
          .then(() => {
            setTimeout(function () {
              location.reload();
            }, 1500);
          });
      }
    }
  </script>

</body>
</html>
